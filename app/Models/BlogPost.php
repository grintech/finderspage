<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;
use Carbon\Carbon;
use App\Models\BlogCategories;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "blog_post";
    protected $fillable = ['user_id', 'title','slug', 'location', 'subcategory', 'content','comment_view_public_private', 'privacy_option', 'schedule', 'image', 'posted_by', 'featured_post', 'bumpPost', "normal_post", "normal_end_date",'status','fundraiser_link','deleted_at'];


    public function add_Blog_post($request)
    {
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_blog_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        } else {
            $imageNames[] = '1688636936.jpg';
        }


        if ($request->post_type == "Normal Post") {
            $currentDateTime = Carbon::now();
            $next30Days = $currentDateTime->addDays(30);
        } else {
            $next30Days = null;
        }

        if (isset($request->comment_view_public_private)) {
            $comment_view_public = $request->comment_view_public_private;
        } else {
            $comment_view_public = "off";
        }
    //creating a slug

    // $title = $request->title;

    // // Convert title to lowercase
    // $slug = strtolower($title);

    // // Replace spaces with hyphens or underscores
    // $slug = str_replace(' ', '-', $slug);

    // // Remove special characters or non-alphanumeric characters
    // $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

    // dd($slug);

    $slug = $this->slugify($request->title,$divider = '-');

        if ($request->subcategory == "5244") {
            $category = BlogCategories::where("title", $request->sub_category_oth)->first();
            if ($category) {
                $subcategory = $category->id;
            }
        } else {
            $subcategory = $request->subcategory ?? [];
        }
        self::create([
            'user_id' => UserAuth::getLoginId(),
            'title' => $request->title,
            'slug' => $slug,
            'location' => $request->location,
            'subcategory' => $subcategory,
            'content' => $request->content,
            'comment_view_public_private' => $comment_view_public,
            'privacy_option' => $request->privacyOption,
            'schedule' => $request->schedule,
            'image' => implode($imageNames, ','),
            'posted_by' => ($request->user_id == 19) ? 'admin' : $request->posted_by,
            'normal_post' => isset($request->post_type) ? ($request->post_type == 'Normal Post' ? 1 : 0) : 0,
            'normal_end_date' => $next30Days,
            'fundraiser_link' => $request->fundraiser_link,
        ]);        
    }


    public function update_Blog_post($request)
    {
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];
        
            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_blog_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        
            // Append new images to the existing image string
            if (!empty($this->image)) {
                $existingImages = explode(',', $this->image);
                $allImages = array_merge($existingImages, $imageNames);
                $imgName = implode(',', $allImages);
            } else {
                $imgName = implode(',', $imageNames);
            }
        } else {
            $imgName = $this->image;
        }
        
        if (isset($request->comment_view_public_private)) {
            $comment_view_public_as = $request->comment_view_public_private;
        } else {
            $comment_view_public_as = "public";
        }
  
        $this->update([
            'user_id' => UserAuth::getLoginId(),
            'title' => $request->title,
            'location' => $request->location,
            'subcategory' => $request->subcategory,
            'content' => $request->content,
            'comment_view_public_private' => $comment_view_public_as,
            'privacy_option' => $request->privacyOption,
            'schedule' => $request->schedule,
            'image' => $imgName,
            'fundraiser_link' => $request->fundraiser_link,
        ]);
    }


    public static function slugify($text, string $divider = '-', int $randomLength = 4)
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
            $text = 'n-a';
        }
    
        // add random string at the end
        $randomString = substr(md5(uniqid(rand(), true)), 0, $randomLength);
        $text .= $divider . $randomString;
    
        return $text;
    }
    
}
