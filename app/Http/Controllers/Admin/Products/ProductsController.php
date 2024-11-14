<?php


namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Libraries\General;
use App\Models\Admin\Products;
use App\Models\Admin\ProductCategories;
use App\Models\Admin\Admins;
use App\Models\Admin\ProductCategoryRelation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class ProductsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permissions::hasPermission('products', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where = [];
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(products.title LIKE ? or owner.first_name LIKE ? or owner.last_name LIKE ?)'] = [$search, $search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['products.created >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['products.created <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'products.created_by IN ('.$admins.')';
    	}

    	if($request->get('category'))
    	{
    		$productIds = ProductCategoryRelation::distinct()
    			->leftJoin('product_categories', 'product_categories.id', '=', 'product_category_relation.category_id')
    			->whereIn('category_id', $request->get('category'))
    			->orWhereIn('product_categories.parent_id', $request->get('category'))
    			->pluck('product_id')
    			->toArray();
    			
    		$productIds = !empty($productIds) ? implode(',', $productIds) : '0';
    		$where[] = 'products.id IN ('.$productIds.')';
    	}

    	if($request->get('status'))
    	{
    		switch ($request->get('status')) {
    			case 'products.active':
    				$where['status'] = 1;
    			break;
    			case 'non_active':
    				$where['products.status'] = 0;
    			break;
    		}    		
    	}
    	
    	$listing = Products::getListing($request, $where);


    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/products/listingLoop", 
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
			$filters = $this->filters($request);
	    	/** Filter Data **/
	    	return view(
	    		"admin/products/index", 
	    		[
	    			'listing' => $listing,
	    			'categories' => $filters['categories'],
	    			'admins' => $filters['admins']
	    		]
	    	);
	    }
    }

    function filters(Request $request)
    {
    	$categories = ProductCategories::select(['id', 'title', 'parent_id'])->whereNull('parent_id')->get();

		$admins = [];
		$adminIds = Products::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();
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
    		'categories' => $categories,
	    	'admins' => $admins
    	];
    }

    function view(Request $request, $id)
    {
    	if(!Permissions::hasPermission('products', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$product = Products::get($id);
    	if($product)
    	{
	    	return view("admin/products/view", [
    			'product' => $product
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function add(Request $request)
    {
    	if(!Permissions::hasPermission('products', 'create'))
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
	                'title' => 'required|unique:products,title',
	                'description' => 'required',
	                'category' => 'required',
	                'sample_no' => [
	                	'required',
	                	Rule::unique('products')
	                ],
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$categories = [];
	        	if(isset($data['sub_category']) && $data['sub_category'] && (isset($data['category']) && $data['category'])) {
	        		$categories = [$data['sub_category']];
	        	}
	        	else if(isset($data['category']) && $data['category']) {
	        		$categories = $data['category'];
	        	}
	        	unset($data['category']);
	        	unset($data['sub_category']);
	        	
	        	$product = Products::create($data);
	        	if($product)
	        	{
	        		if(!empty($categories))
	        		{
	        			Products::handleCategories($product->id, $categories);
	        		}

	        		$request->session()->flash('success', 'Product created successfully.');
	        		return redirect()->route('admin.products');
	        	}
	        	else
	        	{
	        		$request->session()->flash('error', 'Product could not be saved. Please try again.');
		    		return redirect()->back()->withErrors($validator)->withInput();
	        	}
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Please provide valid inputs.');
		    	return redirect()->back()->withErrors($validator)->withInput();
		    }
		}
	    
	    $categories = ProductCategories::getAllCategorySubCategory();
	    
	    return view("admin/products/add", [
	    			'categories' => $categories
	    		]);
    }

    function edit(Request $request, $id)
    {
    	if(!Permissions::hasPermission('products', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$product = Products::get($id);
    	if($product)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'title' => [
		                	'required',
		                	Rule::unique('products')->ignore($product->id)
		                ],
		                'sample_no' => [
		                	'required',
		                	Rule::unique('products')->ignore($product->id)
		                ],
		                'description' => 'required'
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		
	        		/** ONLY IN CASE OF MULTIPLE IMAGE USE THIS **/
	        		// if(isset($data['image']) && $data['image'])
	        		// {
	        		// 	$data['image'] = json_decode($data['image'], true);
	        		// 	$product->image = $product->image ? json_decode($product->image) : [];
		        	// 	$data['image'] = array_merge($product->image, $data['image']);
		        	// 	$data['image'] = json_encode($data['image']);
		        	// }
		        	// else
		        	// {
		        	// 	unset($data['image']);
		        	// }
		        	/** ONLY IN CASE OF MULTIPLE IMAGE USE THIS **/

		        	/** IN CASE OF SINGLE UPLOAD **/
		        	if(isset($data['image']) && $data['image'])
		        	{
		        		$oldImage = $product->image;
		        	}
		        	else
		        	{
		        		unset($data['image']);
		        		
		        	}
		        	/** IN CASE OF SINGLE UPLOAD **/

		        	$categories = [];
		        	if(isset($data['sub_category']) && $data['sub_category'] && (isset($data['category']) && $data['category'])) {
		        		$categories = [$data['sub_category']];
		        	}
		        	else if(isset($data['category']) && $data['category']) {
		        		$categories = $data['category'];
		        	}
		        	unset($data['category']);
		        	unset($data['sub_category']);

		        	if(Products::modify($id, $data))
		        	{
		        		/** IN CASE OF SINGLE UPLOAD **/
		        		if(isset($oldImage) && $oldImage)
		        		{
		        			FileSystem::deleteFile($oldImage);
		        		}
		        		/** IN CASE OF SINGLE UPLOAD **/

		        		if(!empty($categories))
		        		{
		        			Products::handleCategories($product->id, $categories);
		        		}

		        		$request->session()->flash('success', 'Product updated successfully.');
		        		return redirect()->route('admin.products');
		        	}
		        	else
		        	{
		        		$request->session()->flash('error', 'Product could not be saved. Please try again.');
			    		return redirect()->back()->withErrors($validator)->withInput();
		        	}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}

			$categories = ProductCategories::getAllCategorySubCategory();

			return view("admin/products/edit", [
    			'product' => $product,
    			'categories' => $categories
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permissions::hasPermission('products', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$product = Products::find($id);
    	if($product->delete())
    	{
    		$request->session()->flash('success', 'Product deleted successfully.');
    		return redirect()->route('admin.products');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Product could not be deleted.');
    		return redirect()->route('admin.products');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( ($action != 'delete' && !Permissions::hasPermission('products', 'update')) || ($action == 'delete' && !Permissions::hasPermission('products', 'delete')) ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'active':
    				Products::modifyAll($ids, [
    					'status' => 1
    				]);
    				$message = count($ids) . ' records has been published.';
    			break;
    			case 'inactive':
    				Products::modifyAll($ids, [
    					'status' => 0
    				]);
    				$message = count($ids) . ' records has been unpublished.';
    			break;
    			case 'delete':
    				Products::removeAll($ids);
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
