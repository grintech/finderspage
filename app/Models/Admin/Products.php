<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use Illuminate\Support\Str;
use App\Libraries\General;

class Products extends AppModel
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;
    
    /**
    * Products -> ProductCategories belongsToMany relation
    *
    * @return ProductCategories
    */
    public function categories()
    {
        return $this->belongsToMany(ProductCategories::class, 'product_category_relation', 'product_id', 'category_id');
    }

    /**
    * Get resize images
    *
    * @return array
    */
    public function getResizeImagesAttribute()
    {
        return $this->image ? FileSystem::getAllSizeImages($this->image) : null;
    }

    /**
    * Products -> Admins belongsTO relation
    * 
    * @return Admins
    */
    public function owner()
    {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [], $limit = null)
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'products.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
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
            ->orderBy($orderBy, $direction);

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
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'products.id desc', $limit = null)
    {
    	$listing = Products::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'products.*'
    		])
            ->distinct()
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.parent_id', 'product_categories.title', 'product_categories.slug']);
                }
            ]);	
    	}

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
	    
	    if($limit !== null && $limit !== "")
	    {
	    	$listing->limit($limit);
	    }

	    $listing = $listing->get();
        
	    return $listing;
    }

    /**
    * To get single record by id
    * @param $id
    */
    public static function get($id)
    {
    	$record = Products::where('id', $id)
            ->with([
                'categories' => function($query) {
                    $query->select(['product_categories.id', 'product_categories.parent_id', 'product_categories.title']);
                },
                'owner' => function($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                },
            ])
            ->first();
            
	    return $record;
    }

    /**
    * To get single record by slug
    * @param $id
    */
    public static function getBySlug($slug)
    {
        $record = Products::where('products.slug', $slug)
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

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'products.id desc')
    {
    	$record = Products::orderByRaw($orderBy);

	    foreach($where as $query => $values)
	    {
	    	if(is_array($values))
                $record->whereRaw($query, $values);
            elseif(!is_numeric($query))
                $record->where($query, $values);
            else
                $record->whereRaw($values);
	    }
	    
	    $record = $record->limit(1)->first();

	    return $record;
    }

    /**
    * To insert
    * @param $where
    * @param $orderBy
    */
    public static function create($data)
    {
    	$product = new Products();

    	foreach($data as $k => $v)
    	{
    		$product->{$k} = $v;
    	}

        $product->created_by = AdminAuth::getLoginId();
    	$product->created = date('Y-m-d H:i:s');
    	$product->modified = date('Y-m-d H:i:s');
	    if($product->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $product->slug = Str::slug($product->title) . '-' . General::encode($product->id);
                $product->save();
            }

	    	return $product;
	    }
	    else
	    {
	    	return null;
	    }
    }

    /**
    * To update
    * @param $id
    * @param $where
    */
    public static function modify($id, $data)
    {
    	$product = Products::find($id);
    	foreach($data as $k => $v)
    	{
    		$product->{$k} = $v;
    	}

    	$product->modified = date('Y-m-d H:i:s');
	    if($product->save())
	    {
            if(isset($data['title']) && $data['title'])
            {
                $product->slug = Str::slug($product->title) . '-' . General::encode($product->id);
                $product->save();
            }

	    	return $product;
	    }
	    else
	    {
	    	return null;
	    }
    }

    
    /**
    * To update all
    * @param $id
    * @param $where
    */
    public static function modifyAll($ids, $data)
    {
    	if(!empty($ids))
    	{
    		return Products::whereIn('products.id', $ids)
		    		->update($data);
	    }
	    else
	    {
	    	return null;
	    }

    }

    /**
    * To delete
    * @param $id
    */
    public static function remove($id)
    {
    	$product = Products::find($id);
    	return $product->delete();
    }

    /**
    * To delete all
    * @param $id
    * @param $where
    */
    public static function removeAll($ids)
    {
    	if(!empty($ids))
    	{
    		return Products::whereIn('products.id', $ids)
		    		->delete();
	    }
	    else
	    {
	    	return null;
	    }

    }

    /**
    * Save and handle categories
    * @param $id
    * @param $categories array
    */
    public static function handleCategories($id, $categories)
    {
        //Delete all first
        ProductCategoryRelation::where('product_id', $id)->delete();
        // Then Save
        foreach($categories as $c)
        {
            $relation = new ProductCategoryRelation();
            $relation->product_id = $id;
            $relation->category_id = $c;
            $relation->save();
        }
    }
}