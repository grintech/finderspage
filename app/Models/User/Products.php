<?php

namespace App\Models\User;

use App\Models\Admin\Products as AdminProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends AdminProducts
{

    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [], $orderBy = 'products.id desc', $limit = null)
    {
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit = $limit ? $limit : self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	$listing = Products::select([
	    		'products.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name'
	    	])
            ->distinct()
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.title', 'product_categories.slug']);
                }
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'products.created_by')
            ->orderByRaw($orderBy);

	    if(!empty($where))
	    {
	    	foreach($where as $query => $values)
	    	{
	    		if(is_array($values))
                    $listing->whereRaw($query, $values);
                elseif(!is_numeric($query))
                    $listing->where($query, $values);
                else
                    $listing->whereRaw($values);
	    	}
	    }

	    // Put offset and limit in case of pagination
	    if($page !== null && $page !== "" && $limit !== null && $limit !== "")
	    {
	    	$listing->offset($offset);
	    	$listing->limit($limit);
	    }
        
	    $listing = $listing->paginate($limit);

	    return $listing;
    }

    /**
    * To get single record by slug
    * @param $id
    */
    public static function getBySlug($slug)
    {
        $record = Products::where('products.slug', $slug)
            ->where('status', 1)
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.parent_id', 'product_categories.title', 'product_categories.slug']);
                },
                'owner' => function($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                },
            ])
            ->first();
            
        return $record;
    }
}