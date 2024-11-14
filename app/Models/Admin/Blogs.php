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
use App\Models\User;

class Blogs extends AppModel
{
    protected $table = 'blogs';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public static $paginationLimit = 1000;

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;
    
    /**
    * Blogs -> BlogCategories belongsToMany relation
    *
    * @return BlogCategories
    */
    public function categories()
    {
        return $this->belongsToMany(BlogCategories::class, 'blog_category_relation', 'blog_id', 'category_id');
    }

     /**
    * Blogs -> BlogCategories belongsToMany relation
    *
    * @return BlogCategories
    */
    public function sub_categories()
    {
        return $this->belongsToMany(BlogCategories::class, 'blog_category_relation', 'blog_id', 'sub_category_id');
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
    * Blogs -> Admins belongsTO relation
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

    public static function getListing(Request $request, $where = [])
    {
    	$orderBy = $request->get('sort') ? $request->get('sort') : 'blogs.id';
    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';
    	$page = $request->get('page') ? $request->get('page') : 1;
    	$limit = self::$paginationLimit;
    	$offset = ($page - 1) * $limit;
    	
    	$listing = Blogs::select([
        'blogs.*',
        'owner.first_name as owner_first_name',
        'owner.last_name as owner_last_name'
        ])
        ->distinct()
        ->with([
            'categories' => function($query) {
                $query->select(['blog_categories.id', 'blog_categories.title']);
            }
        ])
        ->leftJoin('admins as owner', 'owner.id', '=', 'blogs.created_by')
        ->where('draft', 1)
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
    public static function getAll($select = [], $where = [], $orderBy = 'blogs.id desc', $limit = null)
    {
    	$listing = Blogs::orderByRaw($orderBy);

    	if(!empty($select))
    	{
    		$listing->select($select);
    	}
    	else
    	{
    		$listing->select([
    			'blogs.*'
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
    	$record = Blogs::where('id', $id)
            ->with([
                'categories' => function($query) {
                    $query->select(['blog_categories.id', 'blog_categories.title']);
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
    public static function getRow($where = [], $orderBy = 'blogs.id desc')
    {
    	$record = Blogs::orderByRaw($orderBy);

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
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['categories']);
        unset($blog['sub_category_oth']);
        $blog->choices = $_POST['choices'];
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? json_encode($data['supplement']) : null;
        $blog->sub_category = $_POST['sub_category'];
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        $blog->fixed_pay = $data['fixed_pay'];
        $blog->rate = $data['rate'];
        $blog->description = $data['description'];
        $blog->draft = 1;
        $blog->status = 1;
        // $blog->user_id = AdminAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        $blog->post_by = 'admin';

        $blog->created_by = null;

        $blog->created = date('Y-m-d H:i:s');
  
        $blog->modified = date('Y-m-d H:i:s');

       
        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
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
     // echo "<pre>";print_r($_POST);die('dev');
    	$blog = Blogs::find($id);

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
           // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['categories']);
        unset($blog['sub_category_oth']);
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->choices = $_POST['choices'];
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? json_encode($data['supplement']) : null;
        $blog->sub_category = $_POST['sub_category'];
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        $blog->fixed_pay = $data['fixed_pay'];
        $blog->rate = $data['rate'];
        $blog->description = $data['description'];
        // $blog->user_id = AdminAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        
        $blog->post_by = 'user';
        
        
        $blog->created_by = null;

        $blog->created = date('Y-m-d H:i:s');
  
        $blog->modified = date('Y-m-d H:i:s');

       
        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
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
    		return Blogs::whereIn('blogs.id', $ids)
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
    	$blog = Blogs::find($id);
    	return $blog->delete();
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
    		return Blogs::whereIn('blogs.id', $ids)
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
        // BlogCategoryRelation::where('blog_id', $id)->delete();
        // Then Save
         // foreach($categories as $c)
         // {
            $relation = new BlogCategoryRelation();
            $relation->blog_id = $id;
            $relation->category_id = $categories;
            $relation->save();
         // }
    }

    public static function handleSubCategories($id, $categories)
    {
        //Delete all first
        // BlogCategoryRelation::where('blog_id', $id)->whereNotNull('sub_category_id')->delete();
        // Then Save
        // dd($categories);
        // foreach($categories as $c)
        // {
            $relation = new BlogCategoryRelation();
            $relation->blog_id = $id;
            $relation->category_id = BlogCategories::where('id', $categories)->pluck('parent_id')->first();
            $relation->sub_category_id = $categories;
            $relation->save();
        // }
    }

     /**
    * Get resize images
    *
    * @return array
    */
    public function getOneResizeImagesAttribute()
    {
        return $this->image ? FileSystem::getOneSizeImages($this->image) : null;
    }

     public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }





    public static function realEstate_create($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
         // echo"<pre>"; print_r($data);  die;
        unset($blog['image']);
        unset($blog['sub_category_oth']);
        unset($blog['image']);
        $blog->created_by = 'admin';
        $blog->property_address = $data['property_address'];
        $blog->draft = 1;
        $blog->status = 1;
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->post_choices = isset($data['post_choices']) ? json_encode($data['post_choices']) : null;
        $blog->choices = isset($data['choices']) ? json_encode($data['choices']) : null;
        $blog->landSize = $data['landSize'];
        $blog->units = $data['units'];
        $blog->country =  isset($data['country']) ? $data['country'] : null;
        $blog->state =    isset($data['state']) ? $data['state'] : null;
        $blog->city =     isset($data['city']) ? $data['city'] : null;
        $blog->zipcode =  isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        $blog->bathroom = $data['bathroom'];
        $blog->grage = $data['grage'];
        $blog->area_sq_ft = $data['area_sq_ft'];
        $blog->year_built = $data['year_built'];
        $blog->price = $data['price'];
    
        $blog->description = $data['description'];
        

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        // if ($data['post_type'] == "normal Post"){
        //    $blog->post_type = 1; 
        // }

        $blog->post_by = 'admin';

        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }

    public static function realEstate_edit($id,$data)
    {
        $blog = Blogs::find($id);

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        unset($blog['image']);
        unset($blog['sub_category_oth']);
        unset($blog['categories']);
        unset($blog['image']);
        $blog->created_by = 'admin';
        $blog->property_address = $data['property_address'];
        $blog->status = 0;
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->post_choices = isset($data['post_choices']) ? json_encode($data['post_choices']) : null;
        $blog->choices = isset($data['choices']) ? json_encode($data['choices']) : null;
        $blog->landSize = $data['landSize'];
        $blog->units = $data['units'];
        $blog->country =  isset($data['country']) ? $data['country'] : null;
        $blog->state =    isset($data['state']) ? $data['state'] : null;
        $blog->city =     isset($data['city']) ? $data['city'] : null;
        $blog->zipcode =  isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        $blog->bathroom = $data['bathroom'];
        $blog->grage = $data['grage'];
        $blog->area_sq_ft = $data['area_sq_ft'];
        $blog->year_built = $data['year_built'];
        $blog->price = $data['price'];
    
        $blog->description = $data['description'];
        

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        

        $blog->post_by = 'admin';

        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }


    public static function shopping_create($data)
    {
        $blog = new Blogs();
        unset($data['image']);
        unset($data['sub_category_oth']);
        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        
        $blog->created_by = null;
        $blog->draft = 1;
        $blog->status = 1;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? json_encode($data['supplement']) : null;
        $blog->brand_name = $data['brand_name'];
        $blog->product_url = $data['product_url'];
        $blog->product_size = $data['product_size'];
        $blog->product_condition = $data['product_condition'];
        $blog->delivery_option = isset($data['delivery_option']) ? $data['delivery_option'] : null;
        $blog->pickup = isset($data['pickup']) ? $data['pickup'] : null;
        $blog->shipping = isset($data['shipping']) ? $data['shipping'] : null;
        // $blog->saleOption = isset($data['saleOption']) ? $data['saleOption'] : null;
        $blog->bid = isset($data['bid']) ? $data['bid'] : null;
        $blog->buy_at_face_value = isset($data['buy_at_face_value']) ? $data['buy_at_face_value'] : null;
        $blog->address = isset($data['address']) ? $data['address'] : null;
        $blog->description  = $data['description'];
        $blog->product_price  = $data['product_price'];
        $blog->product_sale_price  = $data['product_sale_price'];
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        $blog->user_id = AdminAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        $blog->post_by = 'user';

        $blog->created_by = null;

       if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }


    public static function shopping_edit($id ,$data)
    {
        $blog = Blogs::where('id',$id)->first();
        // dd($data);
        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['categories']);
        unset($blog['sub_category_oth']);
        $blog->created_by = null;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? json_encode($data['supplement']) : null;
        $blog->brand_name = $data['brand_name'];
        $blog->product_url = $data['product_url'];
        $blog->product_size = $data['product_size'];
        $blog->product_condition = $data['product_condition'];
        $blog->delivery_option = isset($data['delivery_option']) ? $data['delivery_option'] : null;
        $blog->pickup = isset($data['pickup']) ? $data['pickup'] : null;
        $blog->shipping = isset($data['shipping']) ? $data['shipping'] : null;
        //$blog->saleOption = isset($data['saleOption']) ? $data['saleOption'] : null;
        $blog->bid = isset($data['bid']) ? $data['bid'] : null;
        $blog->buy_at_face_value = isset($data['buy_at_face_value']) ? $data['buy_at_face_value'] : null;
        $blog->address = isset($data['address']) ? $data['address'] : null;
        $blog->description  = $data['description'];
        $blog->product_price  = $data['product_price'];
        $blog->product_sale_price  = $data['product_sale_price'];
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;
        $blog->status = '0';

        $blog->post_by = 'user';

        $blog->created_by = null;

       if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }



     public static function Service_create($data)
    {
        // dd($data);
        $blog = new Blogs();
        
        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r($data['country']);  die;
        unset($blog['image']);
        unset($blog['sub_category_oth']);
        $blog->created_by = null;
        $blog->draft = 1;
        $blog->status = 1;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->country =  isset($data['country']) ? $data['country'] : null;
        $blog->state =    isset($data['state']) ? $data['state'] : null;
        $blog->city =     isset($data['city']) ? $data['city'] : null;
        $blog->zipcode =  isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->special_discounts = isset($data['special_discounts']) ? json_encode($data['special_discounts']) : null;
        $blog->working_hours = isset($data['working_hours']) ? json_encode($data['working_hours']) : null;
        $blog->speak_language = isset($data['speak_language']) ? json_encode($data['speak_language']) : null;
        $blog->amenities = isset($data['amenities']) ? json_encode($data['amenities']) : null;
        $blog->payment_preffer = isset($data['payment_preffer']) ? json_encode($data['payment_preffer']) : null;
        $blog->currency_accept = isset($data['currency_accept']) ? json_encode($data['currency_accept']) : null;
        $blog->description = $data['description'];
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
         if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;
       
        $blog->post_by = 'admin';
        $blog->user_id = AdminAuth::getLoginId();

        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }




    public static function Service_update($id,$data)
    {
        $blog = Blogs::find($id);

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
          // echo"<pre>"; print_r($data);  die;
        unset($blog['image']);
        $blog->created_by = null;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->special_discounts = isset($data['special_discounts']) ? json_encode($data['special_discounts']) : null;
        $blog->working_hours = isset($data['working_hours']) ? json_encode($data['working_hours']) : null;
        $blog->speak_language = isset($data['speak_language']) ? json_encode($data['speak_language']) : null;
        $blog->amenities = isset($data['amenities']) ? json_encode($data['amenities']) : null;
        $blog->payment_preffer = isset($data['payment_preffer']) ? json_encode($data['payment_preffer']) : null;
        $blog->currency_accept = isset($data['currency_accept']) ? json_encode($data['currency_accept']) : null;
        $blog->description = $data['description'];
        $blog->email = isset($data['email']) ? $data['email'] : null;
        $blog->phone = isset($data['phone']) ? $data['phone'] : null;
        $blog->website = isset($data['website']) ? $data['website'] : null;
        $blog->whatsapp = isset($data['whatsapp']) ? $data['whatsapp'] : null;
        $blog->twitter = isset($data['twitter']) ? $data['twitter'] : null;
        $blog->youtube = isset($data['youtube']) ? $data['youtube'] : null;
        $blog->facebook = isset($data['facebook']) ? $data['facebook'] : null;
        $blog->instagram = isset($data['instagram']) ? $data['instagram'] : null;
        $blog->linkedin = isset($data['linkedin']) ? $data['linkedin'] : null;
        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;
        
        $blog->post_by = 'user';
        $blog->status = '0';
        $blog->user_id = AdminAuth::getLoginId();
        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }




     public static function event($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        $blog->created_by = AdminAuth::getLoginId();
        $blog->draft = 1;
        $blog->status = 1;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->event_type = $data['event_type'];
        $blog->event_start_date = $data['event_start_date'];
        $blog->event_start_time = $data['event_start_time'];
        $blog->event_end_time = $data['event_end_time'];
        $blog->rate = $data['rate'];
        $blog->country = $data['country'];
        $blog->state = $data['state'];
        $blog->city = $data['city'];
        $blog->zipcode = $data['zipcode'];
        $blog->description = $data['description'];
        $blog->user_id = AdminAuth::getLoginId();
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;


        $blog->personal_detail = $detail;
        if ($data['post_type'] == "Bump Post") {
          $blog->bumpPost = 1;  
        }elseif($data['post_type'] == "Feature Post"){
          $blog->featured_post = "on";
        }else{
           $blog->post_type = 1; 
        }

        $blog->post_by = 'admin';
        // $blog->poll_question = $data['poll_question'];
        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }


    public static function editevent($data , $id)
    {
        $blog =  Blogs::find($id);

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        $blog->created_by = AdminAuth::getLoginId();
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->event_type = $data['event_type'];
        $blog->event_start_date = $data['event_start_date'];
        $blog->event_start_time = $data['event_start_time'];
        $blog->event_end_time = $data['event_end_time'];
        $blog->rate = $data['rate'];
        $blog->country = $data['country'];
        $blog->state = $data['state'];
        $blog->city = $data['city'];
        $blog->zipcode = $data['zipcode'];
        $blog->description = $data['description'];
        $blog->user_id = AdminAuth::getLoginId();
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;


        $blog->personal_detail = $detail;
        if ($data['post_type'] == "Bump Post") {
          $blog->bumpPost = 1; 
          $blog->featured_post = null;
          $blog->post_type = null; 
        }elseif($data['post_type'] == "Feature Post"){
            $blog->featured_post = "on";
            $blog->bumpPost = null; 
            $blog->post_type = null; 
        }else{
           $blog->post_type = 1; 
           $blog->featured_post = null;
           $blog->bumpPost = null; 
        }
        
        $blog->post_by = 'admin';
        // $blog->poll_question = $data['poll_question'];
        if ($blog->save()) {
            if (isset($data['title']) && $data['title']) {
                $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
                $blog->save();
            }

            return $blog;
        } else {
            return null;
        }
    }
}