<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Libraries\General;
use App\Models\Admin\ProductCategories;
use App\Models\Admin\Admins;
use Illuminate\Validation\Rule;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class MainCategoriesController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permissions::hasPermission('main_categories', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where[] = 'product_categories.parent_id is null';
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(product_categories.title LIKE ? or parent.title LIKE ? or owner.first_name LIKE ? or owner.last_name LIKE ?)'] = [$search, $search, $search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['product_categories.created >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['product_categories.created <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('category'))
    	{
    		$parentIds = $request->get('category');
    		$parentIds = implode(',', $parentIds);
    		$where[] = 'product_categories.parent_id IN ('.$parentIds.')';
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'product_categories.created_by IN ('.$admins.')';
    	}

    	$listing = ProductCategories::getListing($request, $where);
    	
    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/products/mainCategories/listingLoop", 
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
			/** Filter Data **/
			$categories = ProductCategories::getAll(
	    		[
	    			'product_categories.id',
	    			'product_categories.title'
	    		],
	    		[
	    			'product_categories.parent_id is null'
	    		],
	    		'product_categories.title desc'
	    	);

	    	$admins = Admins::getAll(
	    		[
	    			'admins.id',
	    			'admins.first_name',
	    			'admins.last_name'
	    		],
	    		[
	    			'admins.status' => 1
	    		],
	    		'concat(admins.first_name, admins.last_name) desc'
	    	);
	    	/** Filter Data **/

	    	return view(
	    		"admin/products/mainCategories/index", 
	    		[
	    			'listing' => $listing,
	    			'categories' => $categories,
	    			'admins' => $admins
	    		]
	    	);
	    }
    }

    function add(Request $request)
    {
    	if(!Permissions::hasPermission('main_categories', 'create'))
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
	                'title' => 'required|unique:product_categories,title'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$category = ProductCategories::create($data);
	        	if($category)
	        	{
	        		$request->session()->flash('success', 'Product category created successfully.');
	        		return redirect()->route('admin.products.mainCategories');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Product category could not be saved. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
	    
	    $categories = ProductCategories::getAll(
	    		[
	    			'product_categories.id',
	    			'product_categories.title'
	    		],
	    		[
	    			'product_categories.parent_id is null'
	    		],
	    		'product_categories.title desc'
	    	);

	    return view("admin/products/mainCategories/add", [
	    		'categories' => $categories
    		]);
    }

    function edit(Request $request, $id)
    {
    	if(!Permissions::hasPermission('main_categories', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$category = ProductCategories::get($id);
    	if($category)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		unset($data['_token']);
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'title' => [
		                	'required',
		                	Rule::unique('product_categories')->ignore($category->id)
		                ]
		            ]
		        );

		         if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		
		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $category->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/

		        	if(ProductCategories::modify($id, $data))
		        	{
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		if(isset($oldImage) && $oldImage)
		        		{
		        			FileSystem::deleteFile($oldImage);
		        		}
		        		/** IN CASE OF SINGLE UPLOAD **/

		        		$request->session()->flash('success', 'Product category updated successfully.');
		        		return redirect()->route('admin.products.mainCategories');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Product category could not be saved. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }

		     //    if(!$validator->fails())
		     //    {	        		
		     //    	if(ProductCategories::modify($id, $data))
		     //    	{
		     //    		$request->session()->flash('success', 'Product category updated successfully.');
		     //    		return redirect()->route('admin.products.mainCategories');
		     //    	}
		     //    	else
		     //    	{
		     //    		$request->session()->flash('error', 'Product category could not be save. Please try again.');
			    // 		return redirect()->back()->withErrors($validator)->withInput();
		     //    	}
			    // }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

    		$categories = ProductCategories::getAll(
	    		[
	    			'product_categories.id',
	    			'product_categories.title'
	    		],
	    		[
	    			'product_categories.parent_id is null'
	    		],
	    		'product_categories.title desc'
	    	);
		    return view("admin/products/mainCategories/edit", [
		    		'categories' => $categories,
		    		'category' => $category
	    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permissions::hasPermission('main_categories', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$admin = ProductCategories::find($id);
    	if($admin->delete())
    	{
    		$request->session()->flash('success', 'Product category deleted successfully.');
    		return redirect()->route('admin.products.mainCategories');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Product category could not be deleted.');
    		return redirect()->route('admin.products.mainCategories');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permissions::hasPermission('main_categories', 'update')) || ($action == 'delete' && !Permissions::hasPermission('main_categories', 'delete')) ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}
    	
    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'delete':
    				ProductCategories::removeAll($ids);
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
