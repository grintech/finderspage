<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import the Storage facade
use Laravel\Socialite\Facades\Socialite;
use App\Models\Video;
use App\Models\UserAuth;
use App\Models\VideoLikes;
use App\Models\SaveVideo;
use App\Models\VideoComment;
use App\Models\VideoCategoryRelation;
use App\Models\Admin\Users;
use App\Models\Admin\Follow;
use Illuminate\Http\Response;
use App\Models\BlogCategories;
use App\Models\Hashtag;
use Carbon\Carbon;
use App\Models\Admin\Notification;
use App\Libraries\General;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video =  Video::where('view_as', 'public')->where('status', 1)->where('video_by', 'user')->orderByRaw("CASE 
                        WHEN videos.featured_post = 'on' THEN 1 
                        WHEN videos.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, videos.id DESC")->get();
            $users = Users::where('status', 1)
                    ->whereNull('deleted_at')
                    ->get(['image', 'id', 'username']);

                // dd($user);
            return view('frontend.videos.video', compact('video','users'));
        }
    public function DashboardIndex()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 727",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        return view('frontend.dashboard_pages.video', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $video = Video::where('view_as', 'public')->where('status', '1')->orderByRaw("CASE 
                        WHEN videos.featured_post = 'on' THEN 1 
                        WHEN videos.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, videos.id DESC")->get()->toArray();



        // Specify the video ID you want to appear at the top
        $targetVideoId = $id; // Replace 123 with the actual video ID you want to prioritize

        // Find the index of the target video in the array
        $targetVideoIndex = -1;
        foreach ($video as $index => $v) {
            if ($v['id'] == $targetVideoId) {
                $targetVideoIndex = $index;
                break;
            }
        }

        // If the target video is found, move it to the beginning of the array
        if ($targetVideoIndex !== -1) {
            $targetVideo = $video[$targetVideoIndex];
            unset($video[$targetVideoIndex]);
            array_unshift($video, $targetVideo);
        }
        // dd($video);
        $users = Users::whereNull('deleted_at')->select('id', 'image', 'first_name', 'username')->get();
        $new_video =  Video::where('view_as', 'on')->get();
        $likedVideo = VideoLikes::all();
        $vidcomments = VideoComment::where('vid_reply_id',null)->orderBy('created_at', 'desc')->get();

        $vidcommentsReply = VideoComment::whereNotNull('vid_reply_id')->get();

        // dd($vidcommentsReply);

        $vid_comments = VideoComment::where('video_id',$id)->get();
        // dd($vid_comments);
        $get_connected_user = Follow::all();

        $shareComponent = \Share::page(
            'https://finderspage.com/single/video/' . $id,
            'Your share text comes here',
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        // echo "<pre>";print_r($vidcomments);die('developert');
        return view('frontend.videos.single_video', compact('video', 'new_video', 'users', 'likedVideo', 'vidcomments', 'get_connected_user', 'shareComponent','vid_comments','vidcommentsReply'));
    }

    public function listing()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $UserID = UserAuth::getLoginId();
        $video =  Video::where('user_id', $UserID)->get();
        return view('frontend.dashboard_pages.videoList', compact('video'));
    }


    public function Admin_video_listing()
    {
        $video =  Video::where('video_by', 'admin')->where('status', 1)->get();
        return view('frontend.videos.admin_video', compact('video'));
    }

    public function testlisting($id)
    {
        $video = Video::find($id);
        $users = Users::whereNull('deleted_at')->select('id', 'image', 'first_name', 'username')->get();
        $new_video =  Video::where('view_as', 'on')->get();
        $likedVideo = VideoLikes::all();
        $vidcomments = VideoComment::all();
        // echo "<pre>";print_r($vidcomments);die('developert');
        return view('frontend.videos.single_video_old', compact('video', 'new_video', 'users', 'likedVideo', 'vidcomments'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

    
        $categories = $request->categories;
        if (isset($request->sub_category) && $request->sub_category == "Other") {
            $SUBcategories = BlogCategories::where("title", $request->sub_category_oth)->first();
            $subCategories = $SUBcategories->id;
        } else {
            $subCategories = $request->sub_category;
        }
    
        $video = new Video();
        $video = $video->addVideo($request, $subCategories);

        // if (!$video) {
        //     $request->session()->flash('error', 'Video could not be added. Please try again.');
        //     return redirect()->back();
        // }
    
        $lastInsertedId = Video::orderBy('id', 'desc')->value('id');
        if (!empty($categories) && !empty($categories) && !empty($lastInsertedId)) {
            $this->handleVideoCategories($lastInsertedId, $categories, $subCategories);
        }
    
        preg_match_all('/#(\w+)/', $request->description, $matches);
        $hashtags = $matches[1];
    
        // Save hashtags to database
        foreach ($hashtags as $tag) {
            $hashtag = Hashtag::firstOrCreate(['title' => $tag]);
        }
    
        $user = UserAuth::getLoginUser();

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'video',
                'message' => "A new video \"{$request->title}\" is created by {$user->first_name}.",
            ];
            Notification::create($notice);
            $codes = [
                '{name}' => $user->first_name,
                '{post_url}' => route('single.video', ['id' => $lastInsertedId]),
                '{post_description}' =>  $user->description,
            ];
    
            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
    
        $request->session()->flash('success', 'Thanks for your video. We still need to review the changes before they go live. Please allow us to approve it. Thank you for understanding.');
        return redirect()->route('listing.video');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getHasTag(Request $request)
    {
        $array = array_map(function ($value) {
            return str_replace('#', '', $value);
        }, $request->hashtags);

        $result = ''; // Initialize the result variable outside the loop

        foreach ($array as $arr) {
            $hashTags = Hashtag::where('title', 'like', '%' . $arr . '%')->get();

            foreach ($hashTags as $tag) {
                $result .= '<div class="mainClass-hashtag">
                    <div class="comments-area">
                        <h6 class="hashtag-item">' . '#' . $tag->title . '</h6>
                    </div>
                </div>';
            }
        }

        return $result;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $video = Video::find($id);
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 727",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        return view('frontend.dashboard_pages.edit_video', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        // dd($request->location);  
        $categories = $request->categories;
        if (isset($request->sub_category) && $request->sub_category == "Other") {
            $SUBcategories = BlogCategories::where("title", $request->sub_category_oth)->first();
            // dd($categories);
            $subCategories = $SUBcategories->id;
        } else {
            $subCategories = '775';
        }

        $video = Video::find($id);
        $updatedVideo = $video->updateVideo($request, $id, $subCategories);
        if (!empty($categories) && !empty($SUBcategories) && !empty($id)) {
            $this->handleVideoCategories($id, $categories, $subCategories);
        }



        if (!empty($updatedVideo)) {

            $user = UserAuth::getLoginUser();
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'type' => 'video',
                    'message' => "A new video \"{$request->title}\" is created by {$user->first_name}.",
                ];
                Notification::create($notice);

                $codes = [
                    '{name}' => $user->first_name,
                    '{post_url}' => route('single.video', ['id' => $video->id]),
                    '{post_description}' =>  $user->description,

                ];

                General::sendTemplateEmail(
                    $user->email,
                    'feature-post',
                    $codes
                );

            if ($video->status == 1) {
                $request->session()->flash('success', 'Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
                return redirect()->route('listing.video');
            } else {
                $request->session()->flash('success', 'Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
                return redirect()->route('listing.video');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video =  Video::find($id);
        $videoComment = VideoComment::where('video_id', $id)->get();

        $video = $video->delete();
        foreach ($videoComment as $Videocom) {
            $Videocom->delete();
        }
        if (empty($video)) {
            return redirect()->route('listing.video');
        } else {
            return redirect()->route('listing.video');
        }
    }


    public function video_like(Request $request)
    {
        // dd($request->all());
        $videoid = $request->id;
        $userid = $request->login_id;

        $likes = VideoLikes::where('like_by', $userid)->where('video_id', $videoid)->first();
        // dd();
        if (isset($likes->like_by) && $likes->like_by == $userid) {
            if ($likes) {
                $likes->update([
                    'likes' => 1,
                    'like_by' => $userid
                ]);
            }
            return response()->json(['error' => 'Video already liked.']);
        } else {
            VideoLikes::Create(['video_id' => $videoid, 'likes' =>  1, 'like_by' => $userid]);
            return response()->json(['success' => 'Video liked successfully.']);
        }
    }

    public function video_dislike(Request $request)
    {
        $videoid = $request->id;
        $userid = $request->login_id;

        $dislikes = VideoLikes::where('like_by', $userid)->where('video_id', $videoid)->first();
        // dd();
        if (isset($dislikes->like_by) && $dislikes->like_by == $userid) {
            if ($dislikes) {
                $dislikes->update([
                    'likes' => 0,
                    'like_by' => $userid
                ]);
            }
            return response()->json(['error' => 'Video disliked successfully.']);
        } else {
            VideoLikes::Create(['video_id' => $videoid, 'likes' =>  0, 'like_by' => $userid]);
            return response()->json(['success' => 'Video disliked successfully.']);
        }
    }


    public function video_save(Request $request)
    {
        $videoid = $request->video_id;
        $userid = UserAuth::getLoginId();

        $SaveVideo = SaveVideo::where('user_id', $userid)->where('video_id', $videoid)->first();
        // dd();
        if (isset($SaveVideo->user_id) && $SaveVideo->user_id == $userid) {
            if ($SaveVideo) {
                $SaveVideo->delete();
            }
            return response()->json(['success' => 'Video unsave successfully.']);
        } else {
            SaveVideo::Create(['video_id' => $videoid, 'user_id' => $userid]);
            return response()->json(['success' => 'Video saved successfully.']);
        }
    }



    public function video_comment(Request $request)
    {
         
        $videoid = $request->video_id;
        $userid = $request->userid;
        $comment = $request->comment;
        
        $Postcomment =  VideoComment::Create(['video_id' => $videoid, 'comment' =>  $comment, 'user_id' => $userid ]);
        if (empty($Postcomment)) {
            return response()->json(['error' => 'Somthing went wrong..!!']);
        } else {
            return response()->json(['success' => ' Comment post successfully..!!']);
        }
    }


    public function video_comment_reply(Request $request)
    {
        // dd($request->all());
        $videoid = $request->video_id;
        $userid = $request->userid;
        $comment_id = $request->comment_id;
        $comment = $request->comment;
        
        $Postcomment =  VideoComment::Create(['video_id' => $videoid, 'comment' =>  $comment, 'user_id' => $userid ,'vid_reply_id' => $comment_id ,]);
        if (empty($Postcomment)) {
            return response()->json(['error' => 'Somthing went wrong..!!']);
        } else {
            return response()->json(['success' => 'Replied successfully..!!']);
        }
    }


    public function video_comment_update(Request $request, $comment_id)
    {
        $editedComment = $request->editedComment;
        $comment = VideoComment::find($comment_id);
        $comment->comment = $editedComment;
        $comment->save();
        return response()->json(['success' => true]);
    }


    public function video_comment_hide(Request $request)
    {
         // dd($request->all());
        $Comment_status = $request->status;
        $commentId = $request->commentId;
        $comment = VideoComment::find($commentId);   
        $update = $comment->update(['status' => $Comment_status]); 
        if ($update) {
           return response()->json(['success' => 'Comment update successfully.']);
        }else{
            return response()->json(['error' => 'Comment update successfully.']);
        }
        
    }


    public function video_comment_delete($comment_id)
    {
        $comment = VideoComment::find($comment_id);
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => 'Comment deleted successfully.'], 200);
        } else {
            return response()->json(['error' => 'Comment not found'], 404);
        }
    }

    public function getfollower(Request $request)
    {
        $searchUsername = $request->input('username');

        $follower = Follow::where('follower_id', UserAuth::getLoginId())->get();

        $result = '';

        foreach ($follower as $getfollower) {
            $follow_user = Users::where('id', $getfollower->following_id)->where('tag_at', 0)
                ->when($searchUsername, function ($query) use ($searchUsername) {
                    return $query->where('username', 'like', '%' . $searchUsername . '%');
                })
                ->select('id', 'username', 'image')
                ->get();

            foreach ($follow_user as $followUsers) {
                $result .= '<div class="mainClass1">
                    <div class="img-icon">
                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="' . ($followUsers->image != '' ? asset("assets/images/profile/") . "/" . $followUsers->image : asset('user_dashboard/img/undraw_profile.svg')) . '">
                    </div>
                    <div class="comments-area">
                        <h6 class="folUser">' . $followUsers->username . '</h6>
                    </div>
                </div>';
            }
        }

        return $result;
    }




    public  function handleVideoCategories($id, $categories, $subcategories)
    {
        VideoCategoryRelation::where('video_id', $id)->delete();
        $relation = new VideoCategoryRelation();
        $relation->video_id = $id;
        $relation->category_id = $categories;
        $relation->sub_category_id = $subcategories;
        $relation->save();
    }


    public function CronVideo()
    {
        // Uncomment the line below for debugging purposes
        $currentDateTime = now();
        // dd($currentDateTime);

        $vidCron = Video::where('schedule', '<=', $currentDateTime)->update([
            'publish_at' => '1',
            // Add other columns you want to update here.
        ]);

        // You can log the number of updated rows for reference
        \Log::info("Updated rows: $vidCron");

        return response()->json(['success' => true, 'updated_rows' => $vidCron]);
    }



    public function download_video(Request $request)
    {
        // Get the data from the AJAX request (assuming you're passing the video URL)
        $videoUrl = $request->input('video_url');

        // Ensure that the video URL is valid
        if (filter_var($videoUrl, FILTER_VALIDATE_URL)) {
            // Get the video content
            $videoContent = file_get_contents($videoUrl);

            // Generate a unique filename based on the video URL
            $filename = uniqid() . '_' . basename($videoUrl);

            // Set the appropriate response headers
            $headers = [
                'Content-Type' => 'video/mp4', // Adjust the content type based on the video format
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            // Return the video content as a downloadable file
            return response($videoContent, 200, $headers);
        } else {
            return response()->json(['error' => 'Invalid video URL.'], 400);
        }
    }



    public function ShareWidget()
    {
        $shareComponent = \Share::page(
            'https://www.codesolutionstuff.com/generate-rss-feed-in-laravel/',
            'Your share text comes here',
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

        return view('posts', compact('shareComponent'));
    }


    public function UpdatevideoScript()
    {
        $videos = Video::all();
    
        foreach ($videos as $video) {
            $video_old = asset('video_short') . '/' . $video->video;

            $posterName = pathinfo($video_old, PATHINFO_FILENAME) . '.jpg';
            $posterPath = 'posters/' . $posterName;

            $defaultImage = public_path('images/video-camera.png');
            copy($defaultImage, public_path($posterPath));

            $video->update([
                'video' => $video->video, 
                'image' => $posterPath,  
            ]);
        }
    
        return response()->json(['success' => 'Video updated successfully.']);
    }
    
}
