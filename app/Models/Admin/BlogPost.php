<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\AdminAuth;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;
    protected $table = "blog_post";
    protected $fillable = ['user_id', 'title', 'slug', 'subcategory', 'content', 'image', 'posted_by'];

    public function addBlogpost($request)
    {

      // dd($request->all());
        $imageNames = $this->handleImages($request);
        $slug = $this->createUniqueSlug($request->title);

        self::create([
            'user_id' => AdminAuth::getLoginId(),
            'title' => $request->title,
            'slug' => $slug,
            'subcategory' => $request->subcategory,
            'content' => $request->content,
            'image' => implode(',', $imageNames),
            'posted_by' => $request->posted_by,
        ]);
    }

    public function updateBlogpost($request)
    {
        $imageNames = $this->handleImages($request);
        $slug = $this->createUniqueSlug($request->title, $this->user_id);

        $this->update([
            'user_id' => AdminAuth::getLoginId(),
            'title' => $request->title,
            'slug' => $slug,
            'subcategory' => $request->subcategory,
            'content' => $request->content,
            'image' => implode(',', $imageNames),
            'posted_by' => $request->posted_by,
        ]);
    }

    private function handleImages($request)
    {
        $imageNames = [];
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_blog_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        } else {
            $imageNames[] = '1688636936.jpg';
        }

        return $imageNames;
    }

    private function createUniqueSlug($title, $postId = 0)
    {
        $slug = $this->slugify($title);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->where('id', '!=', $postId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
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
