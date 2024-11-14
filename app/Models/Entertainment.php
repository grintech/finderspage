<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entertainment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="Entertainment";
    protected $fillable=[
                            "user_id",
                            "Title",
                            "slug",
                            "sub_category",
                            "paying",
                            "gender",
                            "male_age_range",
                            "female_age_range",
                            "amount",
                            "publish_date",
                            "role_name",
                            "deadline",
                            "producer",
                            "director",
                            "writer",
                            "casting_director",
                            "audition_dates",
                            "email",
                            "phone_no",
                            "website",
                            "links",
                            "video",
                            "image",
                            "description",
                            "post_type",
                            "location",
                            "normal_post",
                            "normal_end_date",
                            "deleted_at"
                        ];

    public function add_Entertainment($data){
     // dd($data);
        if (isset($data['image'])) {
            $images = $data['image'];
            $imageNames = [];

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_entrtainment');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }

        }else{
            $imageNames[]=null;
        }
        if(isset($data['video'])){
            $video = $data['video'];
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('images_entrtainment'), $videoName);
        }else{
            $videoName = null;
        }

         // dd($request->all());
        if ($data['post_type'] == "Normal Post"){
            $currentDateTime = Carbon::now();
            $next30Days = $currentDateTime->addDays(30);
        }else{
            $next30Days = null;
        }

        $slug = $this->slugify($data['title'],$divider = '-');
        self::create([
                        'user_id' => UserAuth::getLoginId(),
                        'Title'=>$data['title'],
                        'slug'=>$slug,
                        'sub_category'=>$data['sub_category'],
                        'paying'=>$data['paying'],
                        'gender'=>isset($data['gender']) ? $data['gender'] : null,
                        'male_age_range'=>isset($data['male_age_range']) ? $data['male_age_range'] : null,
                        'female_age_range'=>isset($data['female_age_range']) ? $data['female_age_range'] : null,
                        'amount'=>isset($data['amount']) ? $data['amount'] : null,
                        'publish_date'=>isset($data['publish_date']) ? $data['publish_date'] : null,
                        'role_name'=>$data['role_name'],
                        'deadline'=>$data['deadline'],
                        'producer'=>$data['producer'],
                        'director'=>$data['director'],
                        'normal_post' => isset($data['post_type']) ? ($data['post_type'] == 'Normal Post' ? 1 : 0) : 0,
                        'normal_end_date'=>$next30Days,
                        'post_type'=>$data['post_type'],
                        'writer'=>$data['writer'],
                        'casting_director'=>$data['casting_director'],
                        'audition_dates'=>$data['audition_dates'],
                        'email'=>$data['email'],
                        'phone_no'=>$data['phone_no'],
                        'website'=>$data['website'],
                        'links'=>$data['links'],
                        'video'=>$videoName,
                        'image'=>implode(',', $imageNames), 
                        'description'=>$data['description'], 
                        'location'=>$data['location'], 
                    ]);



    }





    public function update_Entertainment($data ,$id){
    //  dd($data);
     if (isset($data['image'])) {
        $images = $data['image'];
        $imageNames = [];
    
        foreach ($images as $image) {
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images_entrtainment');
            $image->move($destinationPath, $name);
            $imageNames[] = $name;
        }
    
        // Append new images to the existing image array
        if (!empty($this->image)) {
            $existingImages = explode(',', $this->image);
            $allImages = array_merge($existingImages, $imageNames);
            $imageNames = $allImages;
        }
    } else {
        $imageNames = $this->image;
        
    }

        if(isset($data['video'])){
            $video = $data['video'];
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('images_entrtainment'), $videoName);
        }else{
          $videoName  =$this->video;
        }
        $slug = $this->slugify($data['title'],$divider = '-');
         // dd($request->all());

        $this::update([
                        'user_id' => UserAuth::getLoginId(),
                        'Title'=>$data['title'],
                        'slug'=>$slug,
                        'sub_category'=>$data['sub_category'],
                        'paying'=>$data['paying'],
                        'gender'=>isset($data['gender']) ? $data['gender'] : null,
                        'male_age_range'=>isset($data['male_age_range']) ? $data['male_age_range'] : null,
                        'female_age_range'=>isset($data['female_age_range']) ? $data['female_age_range'] : null,
                        'amount'=>isset($data['amount']) ? $data['amount'] : null,
                        'location'=>$data['location'],
                        'publish_date'=>isset($data['publish_date']) ? $data['publish_date'] : null,
                        'role_name'=>$data['role_name'],
                        'deadline'=>$data['deadline'],
                        'producer'=>$data['producer'],
                        'director'=>$data['director'],
                        'post_type'=>$data['post_type'],
                        'writer'=>$data['writer'],
                        'casting_director'=>$data['casting_director'],
                        'audition_dates'=>$data['audition_dates'],
                        'email'=>$data['email'],
                        'phone_no'=>$data['phone_no'],
                        'website'=>$data['website'],
                        'links'=>$data['links'],
                        'video'=>$videoName,
                        'image' => is_array($imageNames) ? (count($imageNames) > 1 ? implode(',', $imageNames) : (isset($imageNames[0]) ? $imageNames[0] : null)) : null,
                        'description'=>$data['description'], 
                    ]);



    }


    public static function slugify($text, string $divider = '-')
    {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, $divider);

      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }
}
