<?php


namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Libraries\General;
use App\Models\Admin\ProductForms;
use App\Models\Admin\Products;
use App\Models\Admin\Admins;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class ProductOrdersController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
    	if(!Permissions::hasPermission('product_orders', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$where[] = " product_forms.form_type = 'order' ";
    	if($request->get('search'))
    	{
    		$search = $request->get('search');
    		$search = '%' . $search . '%';
    		$where['(product.title LIKE ? or product_forms.first_name LIKE ? or product_forms.last_name LIKE ? or product_forms.email LIKE ? or product_forms.cell_number LIKE ?)'] = [$search, $search, $search, $search, $search];
    	}

    	if($request->get('created_on'))
    	{
    		$createdOn = $request->get('created_on');
    		if(isset($createdOn[0]) && !empty($createdOn[0]))
    			$where['product_forms.created >= ?'] = [
    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))
    			];
    		if(isset($createdOn[1]) && !empty($createdOn[1]))
    			$where['product_forms.created <= ?'] = [
    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))
    			];
    	}

    	if($request->get('products'))
    	{
    		$products = $request->get('products');
    		$products = $products ? implode(',', $products) : 0;
    		$where[] = 'product_forms.product_id IN ('.$products.')';
    	}

    	if($request->get('admins'))
    	{
    		$admins = $request->get('admins');
    		$admins = $admins ? implode(',', $admins) : 0;
    		$where[] = 'product_forms.created_by IN ('.$admins.')';
    	}
    	
    	$listing = ProductForms::getListing($request, $where);

    	if($request->ajax())
    	{
		    $html = view(
	    		"admin/products/orders/listingLoop", 
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
	    		"admin/products/orders/index", 
	    		[
	    			'listing' => $listing,
                    'products' => $filters['products']
	    		]
	    	);
	    }
    }

    function filters(Request $request)
    {
    	$products = Products::select(['id', 'title', 'sample_no'])->get();
        return [
            'products' => $products
        ];
    }

    function view(Request $request, $id)
    {
    	if(!Permissions::hasPermission('product_orders', 'listing'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$productForm = ProductForms::get($id);
    	if($productForm && $productForm->form_type == 'order')
    	{
	    	return view("admin/products/orders/view", [
    			'page' => $productForm
    		]);
		}
		else
		{
			abort(404);
		}
    }

    function delete(Request $request, $id)
    {
    	if(!Permissions::hasPermission('product_orders', 'delete'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$productForm = ProductForms::find($id);
    	if($productForm->delete())
    	{
    		$request->session()->flash('success', 'Product Order deleted successfully.');
    		return redirect()->route('admin.products.orders');
    	}
    	else
    	{
    		$request->session()->flash('error', 'Product Order could not be deleted.');
    		return redirect()->route('admin.products.orders');
    	}
    }

    function bulkActions(Request $request, $action)
    {
    	if( $action == 'delete' && !Permissions::hasPermission('product_orders', 'delete') ) 
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$ids = $request->get('ids');
    	if(is_array($ids) && !empty($ids))
    	{
    		switch ($action) {
    			case 'delete':
    				ProductForms::removeAll($ids);
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
