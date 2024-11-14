<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\UserAuth;
use Carbon\Carbon;

class Video extends Model
{
    use HasFactory;
    protected $table = "videos";
    protected $fillable = [
        'user_id',
        'title',
        'video',
        'image',
        'description',
        'mension',
        'view_as',
        'comment_view_as',
        'location',
        'sub_category',
        'captions',
        'status',
        'video_by',
        'video_type',
        'post_type',
        'schedule',
        'publish_at',
        "normal_post",
        "normal_end_date",
    ];

    public function addVideo($request, $subCategories)
    {
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('video_short'), $videoName);
    
            $posterName = pathinfo($videoName, PATHINFO_FILENAME) . '.jpg';
            $posterPath = 'posters/' . $posterName;
    
            $defaultImage = public_path('images/video-camera.png');
            copy($defaultImage, public_path($posterPath));
    
        } else {
            $videoName = null;
            $posterPath = null;
        }
    
        $user = UserAuth::getLoginId();
        if (isset($user)) {
            $UserID = $user;
            $video_by = 'user';
        } else {
            $UserID = 7; 
            $video_by = 'admin';
        }
    
        // Process the 'mension' field (mentions in a comma-separated string)
        $mensionString = rtrim($request->mension, ',');
        $mentionsArray = explode(',', $mensionString);
        $jsonString = json_encode($mentionsArray);
    
        // Determine view options (view_as, comment_view_as)
        $viewAs = $request->view_as ?? "off";
        $comment_view_as = $request->comment_view_as ?? "off";
    
        if ($request->post_type == "Normal Post") {
            $next30Days = Carbon::now()->addDays(30);
        } else {
            $next30Days = null;
        }
    
        $video = self::create([
            'user_id' => $UserID,
            'title' => $request->title,
            'video' => $videoName,
            'image' => $posterPath,
            'description' => $request->description,
            'video_type' => $request->video_type,
            'mension' => $jsonString,
            'view_as' => $viewAs,
            'comment_view_as' => $comment_view_as,
            'location' => $request->location ?? null,
            'sub_category' => $subCategories ?? null,
            'video_by' => $video_by,
            'captions' => $request->captions,
            'schedule' => $request->schedule ?? null,
            'post_type' => $request->post_type ?? null,
            'normal_post' => $request->post_type == 'Normal Post' ? 1 : 0,
            'normal_end_date' => $next30Days,
        ]);
    
        return $video;
    }
    
    
    public function updateVideo($request, $id, $subCategories)
    {
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('video_short'), $videoName);
    
            $posterName = pathinfo($videoName, PATHINFO_FILENAME) . '.jpg';
            $posterPath = 'posters/' . $posterName;

            $defaultImage = public_path('images/video-camera.png');
            copy($defaultImage, public_path($posterPath));
        } else {
            $videoName = $this->video;
            $posterPath = $this->image;
        }

        $user = UserAuth::getLoginId();
        if (isset($user)) {
            $UserID = $user;
            $video_by = 'user';
        } else {
            $UserID = 7; 
            $video_by = 'admin';
        }

        $string = rtrim($request->mension, ',');
        $array = explode(',', $string);
        $jsonString = json_encode($array);

        $viewAs = isset($request->view_as) ? $request->view_as : "public";
        $viewAscomment = isset($request->comment_view_as) ? $request->comment_view_as : "public";

        $video->update([
          'user_id' => $UserID,
          'title' => $request->title,
          'video' => $videoName,
          'image' => $posterPath,
          'description' => $request->description,
          'video_type' => $request->video_type,
          'mension' => $jsonString,
          'view_as' => $viewAs,
          'comment_view_as' => $viewAscomment,
          'location' => $request->location ?? null,
          'sub_category' => $subCategories ?? null,
          'video_by' => $video_by,
          'captions' => $request->captions,
          'status' => '0',
          'schedule' => $request->schedule ?? null,
          'post_type' => $request->post_type ?? null,
      ]);
      return $video;
    }
}
