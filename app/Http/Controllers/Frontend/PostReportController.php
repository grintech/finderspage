<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostReport;
use App\Models\UserAuth;
use Auth;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Admin\Notification;
use App\Models\Admin\Users;

class PostReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
         if (!UserAuth::isLogin()) {
             return redirect('/signup');
         }
        //  dd($request->all());
         $exreport = PostReport::where('post_id', $request->post_id)
                               ->where('reported_by', $request->user_id)
                               ->first();
 
         if ($exreport) {
             return response()->json(['error' => 'You have already reported this post.']);
         }

         $postReport = new PostReport();
         $result = $postReport->addReport($request);

         if ($result) 
         {
         $blogPost = BlogPost::select('user_id', 'slug')->where('id', $request->post_id)->first();
         if (!$blogPost) {
             return response()->json(['error' => 'Blog post not found.']);
         }
 
         $to_user = Users::select('username')->where('id', $blogPost->user_id)->first();
         if (!$to_user) {
             return response()->json(['error' => 'User not found.']);
         }
 
         $userData = UserAuth::getLoginUser();
         $route = url('blogs', $blogPost->slug);

         $notice1 = [
             'from_id' => UserAuth::getLoginId(),
             'to_id' => $blogPost->user_id,
             'type' => 'post',
             'cate_id' => 728,
             'rel_id' => $request->post_id,
             'url' => $route,
             'message' =>'Someone reported on your post.',
         ];
 
         $notice2 = [
             'from_id' => UserAuth::getLoginId(),
             'to_id' => 7,
             'type' => 'post',
             'cate_id' => 728,
             'rel_id' => $request->post_id,
             'url' => $route,
             'message' => $userData->username . ' reported on ' . $to_user->username . '\'s post.',
         ];
 
         $notices = [$notice1, $notice2];
 
         // Create notifications
         foreach ($notices as $notice) {
             Notification::create($notice);
         }
 
         return response()->json(['success' => 'Successfully reported.']);
        }
     }

     public function fundraiser_report(Request $request)
     {
         if (!UserAuth::isLogin()) {
             return redirect('/signup');
         }
        //  dd($request->all());
         $existingReport = PostReport::where('post_id', $request->post_id)
                 ->where('reported_by', $request->user_id)
                 ->first();
 
         if ($existingReport) {
         return response()->json(['error' => 'You have already reported this post.']);
         }
 
         $postReport = new PostReport();
         $isReported = $postReport->addReport($request);
 
         if ($isReported) {
             $post = Blogs::select('user_id', 'slug')->where('id', $request->post_id)->first();
             if (!$post) {
                 return response()->json(['error' => 'Post not found.']);
             }
     
             $to_user = Users::select('username')->where('id', $post->user_id)->first();
             if (!$to_user) {
                 return response()->json(['error' => 'User not found.']);
             }
     
             $userData = UserAuth::getLoginUser();
             $route = url('fundraiser/single', $post->slug);
 
             $notices = [
                 [
                     'from_id' => UserAuth::getLoginId(),
                     'to_id' => $post->user_id,
                     'type' => 'post',
                     'cate_id' => 7,
                     'rel_id' => $request->post_id,
                     'url' => $route,
                     'message' =>'Someone reported on your post.',
                 ],
                 [
                     'from_id' => UserAuth::getLoginId(),
                     'to_id' => 7,
                     'type' => 'post',
                     'cate_id' => 7,
                     'rel_id' => $request->post_id,
                     'url' => $route,
                     'message' => $userData->username . ' reported on ' . $to_user->username . '\'s post.',
                 ]
             ];
 
             foreach ($notices as $notice) {
                 Notification::create($notice);
             }
     
             return response()->json(['success' => 'Successfully reported.']);
         } else {
             return response()->json(['error' => 'Something went wrong. Please try again later.']);
         }
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
