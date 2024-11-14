<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\User;
use App\Libraries\General;
use App\Models\Admin\Notification;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\Follow;
use App\Models\Admin\Users;
class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business = Business::all();
        return view('admin.bussiness_page.bussinesslist',compact('business'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    public function business_Update_status(Request $request)
    {
        
        $blog =  Business::where('id', $request->id)->first();
        if($blog){
            Business::where('id', $request->id)->update(['status'=> $request->status]);
            // dd($blog);
            $usert =  User::where('id', $blog->user_id)->first();
            if($request->status == 1){
                $message = "Your business \"{$blog->business_name}\" is approved.";
            }else{
                 $message = "Your business \"{$blog->business_name}\" is not approved.";
            }
            $notice = [
                    'from_id' => AdminAuth::getLoginId(),
                    'to_id' => $blog->user_id,
                    'type' =>'business',
                    'message' => $message,
                    'notification_by' => '1',
                ];
                    Notification::create($notice);


            // Assuming you have models for Follow and Users
            // dd($request->user_id);
            // Retrieve followers
            $followers = Follow::where('follower_id', $blog->user_id)->pluck('following_id')->toArray();
               // dd($followers);
            foreach ($followers as $followerId) {
                // Retrieve follower details
                $followerDetails = Users::find($followerId);

                // Check if follower details are found
                if ($followerDetails) {
                    // Access individual follower details
                    $followerUserId = $followerDetails->id;
                    $followerFirstName = $followerDetails->first_name;

                    // Create notification
                    $notice = [
                        'from_id' => $blog->user_id,
                        'to_id' => $followerUserId,
                        'type' => 'business',
                        'rel_id' => $blog->id,
                        'cate_id' => $request->cateID,
                        // 'url' = route('business_page.front.single.listing', $blog->slug),
                        'message' => "A new business \"{$blog->business_name}\" is created by {$usert->username}.",
                    ];

                    // Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
                    $image_url = asset('images_blog_img').'/'.$blog->image;
                    $post_url = route('business_page.front.single.listing',$blog->slug);
                    $codes = [
                        '{name}' => $usert->first_name,
                        '{title}' => $blog->business_name,
                        '{image}' => $image_url,
                        '{post_url}' => $post_url,
                        '{posted_date}' => $blog->created_at,

                    ];

                General::sendTemplateEmail(
                    $followerDetails->email,
                    'post-notification-member',
                    $codes
                );
                    }
                 }   
            $codes = [
                        '{first_name}' => $usert->first_name,
                        '{post_url}' => route('business_page.front.single.listing',$blog->slug),
                    ];

                General::sendTemplateEmail(
                    $usert->email,
                    'post-approved-by-admin',
                    $codes
                );
          //dd($usert);
            return response()->json(['Post_success' => 'Updated successfully.']); 

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
        $business = Business::find($id);
        $business = $business->delete();

        if(!$business){
            return redirect()->back()->with(['success' => 'Business deleted successfully.']);
        }else{
            return redirect()->back()->with(['error' => 'somthing went wrong.']);
        }


    }
}
