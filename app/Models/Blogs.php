<?php

namespace App\Models;

use App\Models\Admin\Blogs as AdminBlogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Models\User;
use App\Models\BlogCategoryRelation;
use Auth;
use Carbon\Carbon;

class Blogs extends AdminBlogs
{
    use SoftDeletes;
    /**
     * Get resize images
     *
     * @return array
     */
    protected $fillable = ['image1'];
    public function getImageAttribute()
    {
        //return $this->image ? FileSystem::getAllSizeImages($this->image) : null;
        return $this->image1;
    }


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // fundrasier module

    public function create_fundrasier($request){
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_blog_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        }
        Self::create([
                        'title' => $request->title,
                        'sub_category' => $request->sub_category,
                        'image1' => implode(",",$imageNames),
                        'price' => $request->raise_amount,
                        'payment_links' => implode(",",$request->payment_links),
                        'description' => $request->description,
                        'personal_detail' => $request->personal_detail,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'website' => $request->website,
                        'whatsapp' => $request->whatsapp,
                        'whatsapp' => $request->whatsapp,
                    ]);

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
        $blog->choices = $_POST['choices'];
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->status = 0;
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? $data['supplement'] : null;
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
        $blog->min_pay = $data['min_pay'];
        $blog->max_pay = isset($data['max_pay']) ? $data['max_pay'] : null;
        $blog->fixed_pay = isset($data['fixed_pay']) ? $data['fixed_pay'] : null;
        $blog->rate = $data['rate'];
        $blog->description = $data['description'];
        $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
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



     public static function jobEdit($slug , $data)
    {
        // dd($id);
        $blog = Blogs::where('slug',$slug)->first();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
           // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['category']);
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->choices = isset($data['choices']) ? $data['choices'] : null;
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? $data['supplement'] : null;
        $blog->sub_category = isset($data['sub_category']) ? $data['sub_category'] : null;
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
        $blog->min_pay = $data['min_pay'];
        $blog->max_pay = isset($data['max_pay']) ? $data['max_pay'] : null;
        $blog->fixed_pay = isset($data['fixed_pay']) ? $data['fixed_pay'] : null;
        $blog->rate = isset($data['rate']) ? $data['rate'] : null;
        $blog->description = $data['description'];
        $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
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





     public static function realEstate_create($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
         // echo"<pre>"; print_r($data);  die;
        unset($blog['image']);
        $blog->created_by = null;
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
        $blog->bedroom = $data['bedroom'];
        $blog->grage = $data['grage'];
        $blog->area_sq_ft = $data['area_sq_ft'];
        $blog->year_built = $data['year_built'];
        $blog->price = $data['price'];
        // $blog->sale_price = $data['sale_price'];
        $blog->description = $data['description'];
        $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(44);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }

        $blog->post_by = 'user';

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
    
    
    
     public static function blog_create($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
         // echo"<pre>"; print_r($data);  die;
        unset($blog['image']);
        $blog->created_by = 'member'; 
        $blog->description = $data['caption'];
        $blog->subcategory = $data['subcategory'];
        $blog->location = $data['location'];
        $blog->shares = $data['share_option'];
        $blog->comment_off = $data['comment_off'];
        $blog->status = 0;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->user_id = UserAuth::getLoginId();
        $blog->post_type = "Normal Post";
        
        $blog->post_by = 'user';

        if ($blog->save()) {
            
                $blog->slug = Str::slug('blogs') . '-' . General::encode($blog->id);
                $blog->save();
            
            return $blog;
        } else {
            return null;
        }
    }


    public static function realEstate_edit($slug,$data)
    {
        $blog = Blogs::where('slug',$slug)->first();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        //   echo"<pre>"; print_r($data['area_sq_ft']);  die;
        unset($blog['image']);
        unset($blog['categories']);
        unset($blog['sub_category']);
         $blog->created_by = null;
        $blog->property_address = $data['property_address'];
        $blog->modified = date('Y-m-d H:i:s');
        $blog->post_choices = isset($data['post_choices']) ? json_encode($data['post_choices']) : null;
        $blog->landSize = $data['landSize'];
        $blog->units = $data['units'];
        $blog->location = isset($data['location']) ? $data['location'] : null;
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
        $blog->bedroom = $data['bedroom'];
        $blog->grage = $data['grage'];
        $blog->area_sq_ft = $data['area_sq_ft'];
        $blog->year_built = $data['year_built'];
        $blog->choices = $data['choices'];
        $blog->price = $data['price'];
        // $blog->sale_price = $data['sale_price'];
        $blog->description = $data['description'];
        $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
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




    public static function community_create($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['video']);
        unset($blog['document']);
        $blog->created_by = null;
        $blog->status = 0;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->sub_category = $data['sub_category'];
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->event_start_time = isset($data['event_start_time']) ? $data['event_start_time'] : null;
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
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
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;
        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
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




    public static function community_Edit($data,$slug)
    {
        $blog = Blogs::where('slug',$slug)->first();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['video']);
        unset($blog['document']);
        $blog->modified = date('Y-m-d H:i:s');
        $blog->sub_category = $data['sub_category'];
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->event_start_time = isset($data['event_start_time']) ? $data['event_start_time'] : null;
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
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
        $blog->tiktok = isset($data['tiktok']) ? $data['tiktok'] : null;
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;
        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
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



    public static function shopping_create($data)
    {
        $blog = new Blogs();
        unset($data['image']);
        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        
        $blog->created_by = null;
        $blog->status = 0;
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

        $blog->type_of_animal = isset($data['type_of_animal']) ? $data['type_of_animal'] : null;
        $blog->pet_name = isset($data['pet_name']) ? $data['pet_name'] : null;
        $blog->breed = isset($data['breed']) ? $data['breed'] : null;
        $blog->pet_color = isset($data['pet_color']) ? $data['pet_color'] : null;
        $blog->pet_age  = isset($data['pet_age']) ? $data['pet_age'] : null;
        $blog->pet_gender  = isset($data['pet_gender']) ? $data['pet_gender'] : null;
        $blog->pet_size  = isset($data['pet_size']) ? $data['pet_size'] : null;
        $blog->coat  = isset($data['coat']) ? $data['coat'] : null;
        $blog->adoption_fee  = isset($data['adoption_fee']) ? $data['adoption_fee'] : null;
        $blog->health  = isset($data['health']) ? $data['health'] : null;
        $blog->house_trained  = isset($data['house_trained']) ? $data['house_trained'] : null;
        $blog->location  = isset($data['location']) ? $data['location'] : null;

        $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
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


    public static function shopping_edit($slug ,$data)
    {
        $blog = Blogs::where('slug',$slug)->first();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        unset($blog['categories']);
        $blog->created_by = null;
        $blog->modified = date('Y-m-d H:i:s');
        $blog->benifits = isset($data['benifits']) ? json_encode($data['benifits']) : null;
        $blog->supplement = isset($data['supplement']) ? json_encode($data['supplement']) : null;
        $blog->brand_name = isset($data['brand_name']) ? $data['brand_name'] : null;
        $blog->product_url = isset($data['product_url']) ? $data['product_url'] : null;
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
        $blog->product_price  = isset($data['product_price']) ? $data['product_price'] : null;
        $blog->product_sale_price  = isset($data['product_sale_price']) ? $data['product_sale_price'] : null;
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

        $blog->type_of_animal = isset($data['type_of_animal']) ? $data['type_of_animal'] : null;
        $blog->pet_name = isset($data['pet_name']) ? $data['pet_name'] : null;
        $blog->breed = isset($data['breed']) ? $data['breed'] : null;
        $blog->pet_color = isset($data['pet_color']) ? $data['pet_color'] : null;
        $blog->pet_age  = isset($data['pet_age']) ? $data['pet_age'] : null;
        $blog->pet_gender  = isset($data['pet_gender']) ? $data['pet_gender'] : null;
        $blog->pet_size  = isset($data['pet_size']) ? $data['pet_size'] : null;
        $blog->coat  = isset($data['coat']) ? $data['coat'] : null;
        $blog->adoption_fee  = isset($data['adoption_fee']) ? $data['adoption_fee'] : null;
        $blog->health  = isset($data['health']) ? $data['health'] : null;
        $blog->house_trained  = isset($data['house_trained']) ? $data['house_trained'] : null;
        $blog->location  = isset($data['location']) ? $data['location'] : null;

          $blog->user_id = UserAuth::getLoginId();

        if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;

        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
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
        $blog->status = 0;
        $blog->created = date('Y-m-d H:i:s');
        $blog->modified = date('Y-m-d H:i:s');
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->country =  isset($data['country']) ? $data['country'] : null;
        $blog->state =    isset($data['state']) ? $data['state'] : null;
        $blog->city =     isset($data['city']) ? $data['city'] : null;
        $blog->zipcode =  isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->offerd = isset($data['offerd']) ? json_encode($data['offerd']) : null;
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
        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
        $blog->user_id = UserAuth::getLoginId();

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




    public static function Service_update($slug,$data)
    {
        $blog = Blogs::where('slug',$slug)->first();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
          // echo"<pre>"; print_r($data);  die;
        unset($blog['image']);
        $blog->created_by = null;
        $blog->modified = date('Y-m-d H:i:s');
        $blog->location = isset($data['location']) ? $data['location'] : null;
        $blog->country = isset($data['country']) ? $data['country'] : null;
        $blog->state =   isset($data['state']) ? $data['state'] : null;
        $blog->city =    isset($data['city']) ? $data['city'] : null;
        $blog->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
        $blog->offerd = isset($data['offerd']) ? json_encode($data['offerd']) : null;
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
        if ($data['post_type'] == "Normal Post"){
           $blog->normal_post = 1;
           // Get current datetime
            $currentDateTime = Carbon::now();
            // Add 30 days to the current datetime
            $next30Days = $currentDateTime->addDays(30);
            // dd($next30Days);
            $blog->normal_end_date = $next30Days;

        }
        $blog->post_by = 'user';
        $blog->user_id = UserAuth::getLoginId();
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

    public static function remove($id)
    {
        $blog = Blogs::find($id);
        return $blog->delete();
    }


    public static function event($data)
    {
        $blog = new Blogs();

        foreach ($data as $k => $v) {
            $blog->{$k} = $v;
        }
        // echo"<pre>"; print_r(UserAuth::getLoginId());  die;
        unset($blog['image']);
        $blog->created_by = null;
        $blog->status = 0;
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
        $blog->user_id = UserAuth::getLoginId();
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;


        $blog->personal_detail = $detail;
        if ($data['post_type'] == "normal Post"){
           $blog->post_type = 1; 
        }

        $blog->post_by = 'user';
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
        $blog->user_id = UserAuth::getLoginId();
       if(isset($data['personal_detail'])){
            $detail = $data['personal_detail'];
        }else{
            $detail = 'false';
        }
        $blog->personal_detail = $detail;


        $blog->personal_detail = $detail;
        if ($data['post_type'] == "normal Post"){
           $blog->post_type = 1; 
        }
        
        $blog->post_by = 'user';
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
