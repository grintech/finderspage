<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Libraries\General;
use App\Models\Admin\Feedback;
use App\Models\Admin\Admins;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class FeedbackController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permissions::hasPermission('feedback', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    		
    	}

    	$where = [];
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(feedback.email LIKE ? or feedback.category LIKE ?)'] = [$search, $search];

    	}

        if($request->get('category'))
        {
            $orWhere = [];
            foreach ($request->get('category') as $key => $value) {
                $orWhere[] = "feedback.category LIKE '{$value}'";
            }
            $where[] = '('.implode(' or ', $orWhere).')';
        }

        if($request->get('rating'))
        {
            $range = $request->get('rating');
            if(is_array($range))
                $where['rating >= ? and rating <= ?'] = [$range[0], $range[1]];
            else
                $where['rating <= ?'] = [$range];
        }

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['feedback.created >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['feedback.created <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('status'))
    	{
    		switch ($request->get('status')) {
    			case 'active':
    				$where['feedback.status'] = 1;
    			break;
    			case 'non_active':
    				$where['feedback.status'] = 0;
    			break;
    		}    		
    	}
        
    	$listing = Feedback::getListing($request, $where);


    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/feedback/listingLoop", 
	    		[
	    			'listing' => $listing
	    		]
	    	)->render();

		    return Response()->json([
		    	'status' => 'success',
	            'html' => $html,
	            'page' => $listing->currentPage(),
	            'counter' => $listing->perPage(),
	            'count' => $listing->total(),
	            'pagination_counter' => $listing->currentPage() * $listing->perPage()
	        ], 200);
		}
		else
		{
			$filters = $this->filters($request);
	    	return view(
	    		"admin/feedback/index", 
	    		[
	    			'listing' => $listing,
	    			'admins' => $filters['admins']
	    		]
	    	);
	    }
    }

    function filters(Request $request)
    {
		$admins = [];
		$adminIds = Feedback::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();
		if($adminIds)
		{
	    	$admins = Admins::getAll(
	    		[
	    			'admins.id',
	    			'admins.first_name',
	    			'admins.last_name',
	    			'admins.status',
	    		],
	    		[
	    			'admins.id in ('.implode(',', $adminIds).')'
	    		],
	    		'concat(admins.first_name, admins.last_name) desc'
	    	);
	    }
    	return [
	    	'admins' => $admins
    	];
    }

    function add(Request $request)
    {
    	if(!Permissions::hasPermission('feedback', 'create'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		unset($data['_token']);

    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'email' => 'required',
	                'description' => 'required',
	                'category' => 'required',
	                'rating' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$feedback = Feedback::create($data);
	        	if($feedback)
	        	{
	        		$request->session()->flash('success', 'Feedback created successfully.');
	        		return redirect()->route('admin.feedback');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Feedback could not be saved. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}

	    return view("admin/feedback/add", [
	    		]);
    }

    function view(Request $request, $id)
    {
    	if(!Permissions::hasPermission('feedback', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$feedback = Feedback::get($id);
    	if($feedback)
    	{
	    	return view("admin/feedback/view", [
    			'page' => $feedback
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function edit(Request $request, $id)
    {
    	if(!Permissions::hasPermission('feedback', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$feedback = Feedback::get($id);

    	if($feedback)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'email' => [
		                	'required'
		                ],
		                'description' => 'required'
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		
		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $faq->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/

		        	if(Feedback::modify($id, $data))
		        	{
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		if(isset($oldImage) && $oldImage)
		        		{
		        			FileSystem::deleteFile($oldImage);
		        		}
		        		/** IN CASE OF SINGLE UPLOAD **/

		        		$request->session()->flash('success', 'Feedback updated successfully.');
		        		return redirect()->route('admin.feedback');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Feedback could not be saved. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

			return view("admin/feedback/edit", [
    			'page' => $feedback
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permissions::hasPermission('feedback', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = Feedback::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'Feedback deleted successfully.');
    		return redirect()->route('admin.feedback');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Feedback could not be deleted.');
    		return redirect()->route('admin.feedback');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permissions::hasPermission('feedback', 'update')) || ($action == 'delete' && !Permissions::hasPermission('feedback', 'delete')) )
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'active':
    				Feedback::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been published.';
    			break;
    			case 'inactive':
    				Feedback::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been unpublished.';
    			break;
    			case 'delete':
    				Feedback::removeAll($ids);
    				$message = count($ids) . ' records has been deleted.';
    			break;
    		}

    		$request->session()->flash('success', $message);

    		return Response()->json([
    			'status' => 'success',
	            'message' => $message,
	        ], 200);		
    	}
    	else
    	{
    		return Response()->json([
    			'status' => 'error',
	            'message' => 'Please select atleast one record.',
	        ], 200);	
    	}
    }
}
