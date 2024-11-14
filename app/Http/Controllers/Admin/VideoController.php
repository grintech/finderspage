<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\BlogCategories;
use App\Models\Admin\Users;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\Notification;
use App\Libraries\General;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function superAdminlisting()
    {
       $video =  Video::all();
       return view('admin.blogs.postform.videolist', compact('video'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteVideo($id)
    {
        $video =  Video::find($id);
        $video = $video->delete();
        if($video){
            return redirect()->back()->with(['success' => 'Video deleted successfully..!!']);
        }else{
            return redirect()->back()->with(['error' => 'Somthing went wrong. Please try again later.']);
        }
    }


     public function add_video()
    {
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
        $user = Users::where('status', 1)
        ->where('deleted_at', null)
        ->where('verified_at', '!=', null)
        ->select('users.id', 'users.first_name', 'users.image','users.username')
        ->get();
         // dd($user);
       return view('admin.video.addVideo',compact('categories','user'));
    }


    public function getalluser()
    {
        $users = Users::where('status', 1)
        ->where('deleted_at', null)
        ->where('verified_at', '!=', null)
        ->select('users.id', 'users.first_name', 'users.image','users.username')
        ->get();
        foreach ($users as $followUsers) {
            echo '<div class="mainClass1">
                    <div class="img-icon">
                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="' . ($followUsers->image != '' ? asset("assets/images/profile/") . "/" . $followUsers->image : asset('user_dashboard/img/undraw_profile.svg')) . '">
                    </div>
                    <div class="comments-area">
                        <h6 class="folUser">' . $followUsers->username . '</h6>
                    </div>
                </div>';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = $request->categories;

        if (isset($request->sub_category) && $request->sub_category == "Other") {
            $subCategory = BlogCategories::where("title", $request->sub_category_oth)->first();
            $subCategories = $subCategory ? $subCategory->id : null; 
        } else {
            $subCategories = $request->sub_category;
        }

        $video = new Video();
        $video = $video->addVideo($request, $subCategories);

        if (!$video) {
            $request->session()->flash('error', 'Video could not be added. Please try again.');
            return redirect()->back();
        }

        $lastInsertedId = $video->id;

        if (!empty($categories) && $lastInsertedId) {
            $this->handleVideoCategories($lastInsertedId, $categories, $subCategories);
        }

        $videoData = Video::find($lastInsertedId);
        if (!$videoData) {
            $request->session()->flash('error', 'Video not found after saving.');
            return redirect()->back();
        }

        $user = AdminAuth::getLoginUser();
        $userId = AdminAuth::getLoginId();
        $postType = $request->post_type;

        if ($postType == "Feature Post") {
            $notice = [
                'from_id' => $userId,
                'to_id' => 7,
                'type' => 'video',
                'message' => "A new featured video \"{$request->title}\" was created by {$user->first_name}.",
            ];
            Notification::create($notice);
            // return redirect()->route('stripe.feature.video', ['post_id' => General::encrypt($lastInsertedId)]);
        } elseif ($postType == "Bump Post") {
            $notice = [
                'from_id' => $userId,
                'to_id' => 7,
                'type' => 'video',
                'message' => "A new Bump video \"{$request->title}\" was created by {$user->first_name}.",
            ];
            Notification::create($notice);
            // return redirect()->route('stripe.bump.video', ['post_id' => General::encrypt($lastInsertedId)]);
        } else {
            $notice = [
                'from_id' => $userId,
                'to_id' => 7,
                'type' => 'video',
                'message' => "A new video \"{$request->title}\" was created by {$user->first_name}.",
            ];
            Notification::create($notice);
    
            // $codes = [
            //     '{name}' => $user->first_name,
            //     '{post_url}' => route('single.video', ['id' => $lastInsertedId]),
            //     '{post_description}' => $user->description,
            // ];
            // General::sendTemplateEmail($user->email, 'feature-post', $codes);
        }
    
        $followersIds = Users::pluck('id');
        foreach ($followersIds as $followerId) {
            $followerNotice = [
                'from_id' => 7,
                'to_id' => $followerId,
                'type' => 'video',
                'rel_id' => $videoData->id,
                'url' =>  route('single.video', ['id' => $videoData->id]),
                'message' => "A new video \"{$videoData->title}\" was created by FindersPage.",
            ];
            Notification::create($followerNotice);
        }
    

        $followersEmails = Users::pluck('email')->toArray();
        $emailCodes = [
            '{title}' => $videoData->title,
            '{post_url}' => route('single.video', ['id' => $videoData->id]),
        ];
        General::sendTemplateEmail($followersEmails, 'video-by-admin', $emailCodes);

        $request->session()->flash('success', 'Video saved successfully!');
        return redirect()->route('video.list');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $user = Users::where('status', 1)
        ->where('deleted_at', null)
        ->where('verified_at', '!=', null)
        ->select('users.id', 'users.first_name', 'users.image')
        ->get();
       return view('admin.video.editVideo', compact('video','categories','user'));
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
        $categories = $request->categories;
        if(isset($request->sub_category) && $request->sub_category == "Other"){
            $SUBcategories = BlogCategories::where("title", $request->sub_category_oth)->first();
            // dd($categories);
          $subCategories = $SUBcategories->id;  
        }else{
          $subCategories = $request->sub_category;
        }

        $video = Video::find($id);
        $updatedVideo = $video->updateVideo($request, $id , $subCategories);
        if (!empty($categories) && !empty($SUBcategories) && !empty($id)) {
                $this->handleVideoCategories($id, $categories , $subCategories);
            }



    if (empty($updatedVideo)) {

        $user = AdminAuth::getLoginUser();
                    if ($request->post_type == "Feature Post") {
                        $notice = [
                            'from_id' => AdminAuth::getLoginId(),
                            'to_id' => 7,
                            'type' => 'video',
                            'message' => "A featured video \"{$request->title}\" is updated by {$user->first_name}.",
                        ];
                        Notification::create($notice);
                        // return redirect()->route('stripe.feature.video', ['post_id' => General::encrypt($lastInsertedId)]);
                    }elseif($request->post_type == "Bump Post") {
                        $notice = [
                            'from_id' => AdminAuth::getLoginId(),
                            'to_id' => 7,
                            'type' => 'video',
                            'message' => "A bump video \"{$request->title}\" is updated by {$user->first_name}.",
                        ];
                        Notification::create($notice);
                        // return redirect()->route('stripe.bump.video', ['post_id' => General::encrypt($lastInsertedId)]);
                    }else {
                        $notice = [
                            'from_id' => AdminAuth::getLoginId(),
                            'to_id' => 7,
                            'type' => 'video',
                            'url' => route('single.video', ['id' => $request->id]),
                            'message' => "A video \"{$request->title}\" is updated by {$user->first_name}.",
                        ];
                        Notification::create($notice);

                        $codes = [
                            '{name}' => $user->first_name,
                            '{post_url}' => route('single.video', ['id' => $request->id]),
                            '{post_description}' =>  $user->description,

                        ];
  
                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                    }
                
                   $request->session()->flash('success', 'Video updated successfully.');
                    return redirect()->route('video.list');   
                
        } else {
            $request->session()->flash('error', 'Post could not be saved. Please try again.');
            return redirect()->back();
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
        //
    }
}
