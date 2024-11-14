<?php



/**

 * BlogCategories Class

 *

 * @package    BlogCategoriesController

 * @copyright  2021 Globiz Technology Inc..

 * @author     Ritish Vermani <ritish.vermani@globiztechnology.com>

 * @version    Release: 1.0.0

 * @since      Class available since Release 1.0.0

 */





namespace App\Http\Controllers\Admin\Blogs;



use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\Settings;

use App\Models\Admin\Permissions;

use App\Models\Admin\AdminAuth;

use App\Libraries\General;

use App\Models\Admin\BlogCategories;

use App\Models\Admin\Admins;

use Illuminate\Validation\Rule;

use App\Libraries\FileSystem;

use App\Http\Controllers\Admin\AppController;

use App\Rules\UniqueCategoryTitle;



class BlogCategoriesController extends AppController

{

	function __construct()

	{

		parent::__construct();

	}

	
	public function getchild(Request $request) {

		$parentID = $_POST['selectedParent'];

		$listing = BlogCategories::getAll(
						['blog_categories.id', 'blog_categories.title'],
						['blog_categories.parent_id' => $parentID],
						'blog_categories.title desc'
					);
		$data = array();
		foreach ($listing as $key => $object) {
			$data[] = array(
				'id' =>$object->id,
				'title' =>$object->title,
			);
		}

		return response($data);
	}
		

    function index(Request $request)

    {
		if(!Permissions::hasPermission('blog_categories', 'listing'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$where = [];
		$listing = BlogCategories::getListing($request, $where);
		foreach ($listing as $list => $listValue) {
				
			$parent_id = $listValue->parent_id; 
			$where = ['blog_categories.id' => $parent_id];
			$singlelisting = BlogCategories::getListing($request, $where)->pluck('parent_title')->first();
			$listValue->super_parent_id = $singlelisting; 

			
		}
		
    	if($request->ajax())

    	{

		    $html = view(

	    		"admin/blogs/categories/listingLoop", 

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

			$categories = BlogCategories::getAll(

	    		[

	    			'blog_categories.id',

	    			'blog_categories.title'

	    		],

	    		[

	    			'blog_categories.parent_id is null'

	    		],

	    		'blog_categories.title desc'

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


			 
	    	// dd($categories);
	    	return view(

	    		"admin/blogs/categories/index", 

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

    	if(!Permissions::hasPermission('blog_categories', 'create'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	if($request->isMethod('post'))

    	{
    		   // echo "<pre>";print_r($_POST);die('mydev');
    		$data = $request->toArray();

    		unset($data['_token']);



    		$validator = Validator::make(

	            $request->toArray(),

	            [

	                 'title' => ['required', new UniqueCategoryTitle($request->parent_id)],

	            ]

	        );



	        if(!$validator->fails())

	        {

	        	$category = BlogCategories::create($data);

	        	if($category)

	        	{

	        		$request->session()->flash('success', 'Blog category created successfully.');

	        		return redirect()->route('admin.blogs.categories');

	        	}

	        	else

	        	{

	        		$request->session()->flash('error', 'Blog could not be saved. Please try again.');

		    		return redirect()->back()->withErrors($validator)->withInput();

	        	}

		    }

		    else

		    {

		    	$request->session()->flash('error', 'Please provide valid inputs.');

		    	return redirect()->back()->withErrors($validator)->withInput();

		    }

		}

	    

	    $categories = BlogCategories::getAll(

	    		[

	    			'blog_categories.id',

	    			'blog_categories.title'

	    		],

	    		[

	    			'blog_categories.parent_id is null'

	    		],

	    		'blog_categories.title desc'

	    	);



	    return view("admin/blogs/categories/add", [

	    		'categories' => $categories

    		]);

    }




    function add_shopping_cate(Request $request)

    {
		
    	if($request->isMethod('post'))

    	{
			
    		if(isset($request->title)){
    			
    		// echo "<pre>";print_r($_POST);die('mydev');
    		$data = $request->toArray();

    		unset($data['_token']);



    		$validator = Validator::make(

	            $request->toArray(),

	            [

	                 'title' => 'required|unique:blog_categories,title'

	            ]

	        );



	        if(!$validator->fails())

	        {

	        	$category = BlogCategories::create($data);

	        	if($category)

	        	{

	        		$request->session()->flash('success', 'Blog category created successfully.');

	        		return response()->json(['success'=>'Category created successfully.']);

	        	}

	        	else

	        	{

	        		$request->session()->flash('error', 'Blog could not be saved. Please try again.');

		    		return response()->json(['error'=>'Blog could not be saved. Please try again.']);

	        	}

		    }

		    else

		    {

		    	$request->session()->flash('error', 'Please provide valid inputs.');

		    	return response()->json(['error'=>'Please provide valid inputs.']);

		    }

    		}else{
    			return response()->json(['success'=>'Receved a blank title.']);
    		}

		}

    }



    function edit(Request $request, $id)

    {


    	if(!Permissions::hasPermission('blog_categories', 'update'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$category = BlogCategories::get($id);

    	

    	if($category)

    	{

	    	if($request->isMethod('post'))

	    	{

	    		$data = $request->toArray();

	    		$validator = Validator::make(

		            $request->toArray(),

		            [

		                'title' => [

		                	'required',

		                	Rule::unique('blog_categories')->ignore($category->id)

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

		        	if(BlogCategories::modify($id, $data))

		        	{

		        		/** IN CASE OF SINGLE UPLOAD **/

		        		if(isset($oldImage) && $oldImage)

		        		{

		        			FileSystem::deleteFile($oldImage);

		        		}

		        		/** IN CASE OF SINGLE UPLOAD **/



		        		$request->session()->flash('success', 'Blog category updated successfully.');

		        		return redirect()->route('admin.blogs.categories');

		        	}

		        	else

		        	{

		        		$request->session()->flash('error', 'Category could not be saved. Please try again.');

			    		return redirect()->back()->withErrors($validator)->withInput();

		        	}

			    }

			    else

			    {

			    	$request->session()->flash('error', 'Please provide valid inputs.');

			    	return redirect()->back()->withErrors($validator)->withInput();

			    }

			}



    		$categories = BlogCategories::getAll(

	    		[

	    			'blog_categories.id',

	    			'blog_categories.title'

	    		],

	    		[

	    			'blog_categories.parent_id is null'

	    		],

	    		'blog_categories.title desc'

	    	);

		    return view("admin/blogs/categories/edit", [

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

    	if(!Permissions::hasPermission('blog_categories', 'delete'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$admin = BlogCategories::find($id);

    	if($admin->delete())

    	{

    		$request->session()->flash('success', 'Blog category deleted successfully.');

    		return redirect()->route('admin.blogs.categories');

    	}

    	else

    	{

    		$request->session()->flash('error', 'Blog category could not be deleted.');

    		return redirect()->route('admin.blogs.categories');

    	}

    }



    function bulkActions(Request $request, $action)

    {

    	if( ($action != 'delete' && !Permissions::hasPermission('blog_categories', 'update')) || ($action == 'delete' && !Permissions::hasPermission('blog_categories', 'delete')) ) 

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}

    	

    	$ids = $request->get('ids');

    	if(is_array($ids) && !empty($ids))

    	{

    		switch ($action) {

    			case 'delete':

    				BlogCategories::removeAll($ids);

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

