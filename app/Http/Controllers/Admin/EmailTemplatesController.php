<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\EmailTemplates;

use Illuminate\Validation\Rule;

use App\Models\Admin\AdminAuth;

use App\Http\Controllers\Admin\AppController;



class EmailTemplatesController extends AppController

{

	function __construct()

	{

		parent::__construct();

	}



    function index(Request $request)

    {

    	if(!AdminAuth::isAdmin())

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$where = [];

    	if($request->get('search'))

    	{

    		$search = $request->get('search');

    		$search = '%' . $search . '%';

    		$where['(email_templates.title LIKE ? or email_templates.subject LIKE ?)'] = [$search, $search];

    	}



    	if($request->get('created_on'))

    	{

    		$createdOn = $request->get('created_on');

    		if(isset($createdOn[0]) && !empty($createdOn[0]))

    			$where['email_templates.created >= ?'] = [

    				date('Y-m-d', strtotime($createdOn[0]))

    			];

    		if(isset($createdOn[1]) && !empty($createdOn[1]))

    			$where['email_templates.created <= ?'] = [

    				date('Y-m-d', strtotime($createdOn[1]))

    			];

    	}



    	$listing = EmailTemplates::getListing($request, $where);

    	if($request->ajax())

    	{

		    $html = view(

	    		"admin/emailTemplates/listingLoop", 

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

	    	return view(

	    		"admin/emailTemplates/index", 

	    		[

	    			'listing' => $listing

	    		]

	    	);

	    }

    }



    function edit(Request $request, $id)

    {

    	if(!AdminAuth::isAdmin())

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$template = EmailTemplates::get($id);

    	if($template)

    	{

	    	if($request->isMethod('post'))

	    	{

	    		$data = $request->toArray();

	    		$validator = Validator::make(

		            $request->toArray(),

		            [

		                'subject' => 'required',

		                'description' => 'required',

		            ]

		        );



		        if(!$validator->fails())

		        {

		        	unset($data['_token']);

		        	if(EmailTemplates::modify($id, $data))

		        	{

		        		$request->session()->flash('success', 'Email template updated successfully.');

		        		return redirect()->route('admin.emailTemplates');

		        	}

		        	else

		        	{

		        		$request->session()->flash('error', 'Template could not be saved. Please try again.');

			    		return redirect()->back()->withErrors($validator)->withInput();

		        	}

			    }

			    else

			    {

			    	$request->session()->flash('error', 'Please provide valid inputs.');

			    	return redirect()->back()->withErrors($validator)->withInput();

			    }

			}



		    return view("admin/emailTemplates/edit", [

		    		'template' => $template

	    		]);

		}

		else

		{

			abort(404);

		}

    }




   public function addTemplate(){
   	if(!AdminAuth::isAdmin())

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}
   	return view('admin.emailTemplates.add_emailTemp');
   }



   public function SaveTemplate(Request $request){

   	if(!AdminAuth::isAdmin())

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}

    	if($request->isMethod('post'))

	    	{

	    		$data = $request->toArray();
	    		// dd($data);
	    		$validator = Validator::make(

		            $request->toArray(),

		            [

		                
		                'title' => 'required',
		                'slug' => 'required',
		                'type' => 'required',
		                'subject' => 'required',
		                'description' => 'required',

		            ]

		        );



		        if(!$validator->fails())

		        {

		        	unset($data['_token']);

		        	if(EmailTemplates::addCode($data))

		        	{

		        		$request->session()->flash('success', 'Email template added successfully.');

		        		return redirect()->route('admin.emailTemplates');

		        	}

		        	else

		        	{

		        		$request->session()->flash('error', 'Template could not be saved. Please try again.');

			    		return redirect()->back()->withErrors($validator)->withInput();

		        	}

			    }

			    else

			    {

			    	$request->session()->flash('error', 'Please provide valid inputs.');

			    	return redirect()->back()->withErrors($validator)->withInput();

			    }

			}


   }

}

