<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAuth;
use App\Models\reviewModel;
use App\Models\Admin\Users;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\BlogPost;
use App\Models\Business;
use App\Models\Entertainment;
use Session;
use App\Models\Admin\Notification;
use Illuminate\Support\Facades\DB;
use App\Libraries\General;
use Carbon\Carbon;


class reviewController extends Controller
{

    public function reviewRegister(Request $request)

    {  

        $request->validate([

            'rating' => 'required',

        ]);
        $user_details = UserAuth::getLoginUser(); // Assuming this method returns the authenticated user
        // dd($user_details); 
        $userId = $user_details->id;

        $review = new reviewModel();

        $review->user_id = $userId;
        $review->name = $user_details->first_name;

        $review->rating = $request->input('rating');
        $review->description = $request->input('description');

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('review_video'), $videoName);
        }
        $review->video = $videoName;
        DB::table('users')
            ->where('id', $userId)
            ->update(['review' => 1,'free_bump' =>1]);

        $review->save();

        $notice = [
        'from_id' => UserAuth::getLoginId(),
        'to_id' => 7,
        'type' => 'user',
        'message' => "A new review has been submitted by \"{$user_details->username}\".",
        'url' => route('UserProfileFrontend', $user_details->slug),
        ];
        Notification::create($notice);
        Session::flash('success', 'Review submitted successfully.');
        return redirect()->back();

    }


    public function if_bump_post_count($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if($user->bump_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->bump_post_count - 1;
            }

            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 
                        'bumpPost_start_date' => $start_date, 
                        'bumpPost_end_date' => $end_date ,
                        'bump_post_count' =>$new_post_count,
                    ]);
            }

            $blog = Blogs::where('id', $post_id)->first();

            if ($blog->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $blogs = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blog_category_relation.blog_id', $post_id)
                ->select('blog_category_relation.category_id')
                ->first();


            if ($blog->created > Carbon::now()->subDays(38)->toDateString())
            {
                if ($blogs->category_id == 2) 
                {
                    $ad_name = 'job';
                    $url = route('jobpost', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 4) 
                {
                    $ad_name = 'real estate';
                    $url = route('real_esate_post', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 5) 
                {
                    $ad_name = 'community';
                    $url = route('community_single_post', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 6) 
                {
                    $ad_name = 'shopping';
                    $url = route('shopping_post_single', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 7) 
                {
                    $ad_name = 'fundraiser';
                    $url = route('single.fundraisers', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 705) 
                {
                    $ad_name = 'service';
                    $url = route('service_single', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
            } else {
                if ($blogs->category_id == 2) 
                {
                    $ad_name = 'job';
                    $url = route('jobpost', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 4) 
                {
                    $ad_name = 'real estate';
                    $url = route('real_esate_post', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 5) 
                {
                    $ad_name = 'community';
                    $url = route('community_single_post', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 6) 
                {
                    $ad_name = 'shopping';
                    $url = route('shopping_post_single', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 7) 
                {
                    $ad_name = 'fundraiser';
                    $url = route('single.fundraisers', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 705) 
                {
                    $ad_name = 'service';
                    $url = route('service_single', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
            }

            $notice1 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => $blogs->category_id,
                'type' => 'bump',
                'rel_id' => $blog->id,
                'message' => $message,
                'url' => $url,
            ];

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => $blogs->category_id,
                'type' => 'bump',
                'rel_id' => $blog->id,
                'message' => "Your Ad \"{$blog->title}\" has been bumped.",
                'url' => $url,
            ];
            
            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{first_name}' => $user->first_name,
                '{post_url}' => route('blogPostSingle',$blog->slug),
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }


    public function if_bump_post_count_blogs($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', $user_id)->first();
            if($featureUser->bump_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $featureUser->bump_post_count - 1;
            }
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' =>$new_post_count,
                    ]);
            }

             // Post Updated aginst PostID 
            $Blog_post = BlogPost::where('id', $post_id)->first();
            if ($Blog_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 728,
                'type' => 'subscription',
                'rel_id' => $Blog_post->id,
                'message' => "A new bump blog \"{$Blog_post->title}\" is created by {$featureUser->username}.",
                'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'cate_id' => 728,
                'type' => 'payment',
                'rel_id' => $Blog_post->id,
                'message' => "Your blog \"{$Blog_post->title}\" has been bumped.",
                'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $featureUser->first_name,
                '{post_url}' => route('blogPostSingle',$Blog_post->slug),
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }



    public function if_bump_post_count_business($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if($user->bump_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->bump_post_count - 1;
            }
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' =>$new_post_count,
                    ]);
            }

             // Post Updated aginst PostID 
            $Business = Business::where('id', $post_id)->first();
            if ($Business->id) {
                DB::table('businesses')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'type' => 'Bump',
                        'bumpPost' => 1,
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            if ($Business->created_at > Carbon::now()->subDays(38)->toDateString())
            {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 1,
                    'type' => 'bump',
                    'rel_id' => $Business->id,
                    'message' => "A new business \"{$Business->business_name}\" is bumped by {$user->username}.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
            } else {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 1,
                    'type' => 'bump',
                    'rel_id' => $Business->id,
                    'message' => "A business \"{$Business->business_name}\" is bumped by {$user->username}.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
            }

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => 1,
                'type' => 'bump',
                'rel_id' => $Business->id,
                'message' => "Your business \"{$Business->business_name}\" has been bumped.",
                'url' => route('business_page.front.single.listing', $Business->slug),
            ];
         
            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{first_name}' => $user->first_name,
                '{post_url}' => route('blogPostSingle',$Business->slug),
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Your business bumped successfully.');

         return redirect()->back();
    }



    public function if_bump_post_count_entertainment($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if($user->bump_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->bump_post_count - 1;
            }
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' => $new_post_count,
                    ]);
            }

             // Post Updated aginst PostID 
            $Entertainment = Entertainment::where('id', $post_id)->first();
            if ($Entertainment->id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'post_type' => 'Bump Post',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            if ($Entertainment->created_at > Carbon::now()->subDays(38)->toDateString())
            {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'bump',
                    'rel_id' => $Entertainment->id,
                    'message' => "A new entertainment post \"{$Entertainment->Title}\" is bumped by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $Entertainment->slug),
                ];
            } else {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'bump',
                    'rel_id' => $Entertainment->id,
                    'message' => "A entertainment post \"{$Entertainment->Title}\" is bumped by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $Entertainment->slug),
                ];
            }

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => 741,
                'type' => 'bump',
                'rel_id' => $Entertainment->id,
                'message' => "Your entertainment post \"{$Entertainment->Title}\" has been bumped.",
                'url' => route('Entertainment.single.listing', $Entertainment->slug),
            ];

            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{first_name}' => $user->first_name,
                '{post_url}' => route('Entertainment.single.listing',$Entertainment->slug),
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }



    public function if_bump_is_free($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 
                        'bumpPost_start_date' => $start_date, 
                        'bumpPost_end_date' => $end_date,
                        'free_bump' => 0,
                    ]);
            }

             // Post Updated aginst PostID 
            $blog = Blogs::where('id', $post_id)->first();
            if ($blog->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $blogs = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blog_category_relation.blog_id', $post_id)
                ->select('blog_category_relation.category_id')
                ->first();

            if ($blog->created > Carbon::now()->subDays(38)->toDateString())
            {
                if ($blogs->category_id == 2) 
                {
                    $ad_name = 'job';
                    $url = route('jobpost', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 4) 
                {
                    $ad_name = 'real estate';
                    $url = route('real_esate_post', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 5) 
                {
                    $ad_name = 'community';
                    $url = route('community_single_post', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 6) 
                {
                    $ad_name = 'shopping';
                    $url = route('shopping_post_single', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 7) 
                {
                    $ad_name = 'fundraiser';
                    $url = route('single.fundraisers', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 705) 
                {
                    $ad_name = 'service';
                    $url = route('service_single', $blog->slug);
                    $message = "A new {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
            } else {
                if ($blogs->category_id == 2) 
                {
                    $ad_name = 'job';
                    $url = route('jobpost', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 4) 
                {
                    $ad_name = 'real estate';
                    $url = route('real_esate_post', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 5) 
                {
                    $ad_name = 'community';
                    $url = route('community_single_post', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 6) 
                {
                    $ad_name = 'shopping';
                    $url = route('shopping_post_single', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 7) 
                {
                    $ad_name = 'fundraiser';
                    $url = route('single.fundraisers', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
                elseif ($blogs->category_id == 705) 
                {
                    $ad_name = 'service';
                    $url = route('service_single', $blog->slug);
                    $message = "A {$ad_name} Ad \"{$blog->title}\" is bumped by {$user->username}.";
                } 
            }

            $notice1 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => $blogs->category_id,
                'type' => 'bump',
                'rel_id' => $blog->id,
                'message' => $message,
                'url' => $url,
            ];

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => $blogs->category_id,
                'type' => 'bump',
                'rel_id' => $blog->id,
                'message' => "Your Ad \"{$blog->title}\" has been bumped.",
                'url' => $url,
            ];
            
            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }



    public function if_bump_is_free_blogs($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'free_bump' => 0,
                    ]);
            }

             // Post Updated aginst PostID 
            $Blog_post = BlogPost::where('id', $post_id)->first();
            if ($Blog_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 728,
                'type' => 'subscription',
                'rel_id' => $Blog_post->id,
                'message' => "A new bump blog \"{$Blog_post->title}\" is created by {$featureUser->username}.",
                'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'cate_id' => 728,
                'type' => 'payment',
                'rel_id' => $Blog_post->id,
                'message' => "Your blog \"{$Blog_post->title}\" has been bumped.",
                'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
            ];
            Notification::create($notice);

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }


    public function if_bump_is_free_business($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 
                        'bumpPost_start_date' => $start_date, 
                        'bumpPost_end_date' => $end_date ,
                        'free_bump' => 0,
                    ]);
            }

             // Post Updated aginst PostID 
            $Business = Business::where('id', $post_id)->first();
            if ($Business->id) {
                DB::table('businesses')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'type' => 'Bump',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            if ($Business->created_at > Carbon::now()->subDays(38)->toDateString())
            {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 1,
                    'type' => 'bump',
                    'rel_id' => $Business->id,
                    'message' => "A new business \"{$Business->business_name}\" is bumped by {$user->username}.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
            } else {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 1,
                    'type' => 'bump',
                    'rel_id' => $Business->id,
                    'message' => "A business \"{$Business->business_name}\" is bumped by {$user->username}.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
            }

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => 1,
                'type' => 'bump',
                'rel_id' => $Business->id,
                'message' => "Your business \"{$Business->business_name}\" has been bumped.",
                'url' => route('business_page.front.single.listing', $Business->slug),
            ];
         
            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }


    public function if_bump_is_free_entertainment($post_id){
        // dd($post_id);
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        // Update User 
            $user_id = UserAuth::getLoginId();
            $user = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 
                        'bumpPost_start_date' => $start_date, 
                        'bumpPost_end_date' => $end_date ,
                        'free_bump' => 0,
                    ]);
            }

             // Post Updated aginst PostID 
            $Entertainment = Entertainment::where('id', $post_id)->first();
            if ($Entertainment->id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'post_type' => 'Bump Post',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        
                    ]);
            }

            if ($Entertainment->created_at > Carbon::now()->subDays(38)->toDateString())
            {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'bump',
                    'rel_id' => $Entertainment->id,
                    'message' => "A new entertainment post \"{$Entertainment->Title}\" is bumped by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $Entertainment->slug),
                ];
            } else {
                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'bump',
                    'rel_id' => $Entertainment->id,
                    'message' => "A entertainment post \"{$Entertainment->Title}\" is bumped by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $Entertainment->slug),
                ];
            }

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => 741,
                'type' => 'bump',
                'rel_id' => $Entertainment->id,
                'message' => "Your entertainment post \"{$Entertainment->Title}\" has been bumped.",
                'url' => route('Entertainment.single.listing', $Entertainment->slug),
            ];

            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $user->email,
                'Bump-post-success',
                $codes
            ); 

         Session::flash('success', 'Bumped successfully.');

         return redirect()->back();
    }



    public function is_post_is_feature($post_id){
        // dd($post_id);
        $user = UserAuth::getLoginUser();
        $blog = Blogs::where('id',$post_id)->first();
        $blogs = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
            ->where('blog_category_relation.blog_id', $post_id)
            ->select('blog_category_relation.category_id')
            ->first();
        // dd($blogs->category_id);

        // $category_name = BlogCategories::where('id', $blogs->category_id)->pluck('title')->first();

        if ($blog->created > Carbon::now()->subDays(38)->toDateString())
        {
            if ($blogs->category_id == 2) 
            {
                $ad_name = 'job';
                $url = route('jobpost', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 4) 
            {
                $ad_name = 'real estate';
                $url = route('real_esate_post', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 5) 
            {
                $ad_name = 'community';
                $url = route('community_single_post', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 6) 
            {
                $ad_name = 'shopping';
                $url = route('shopping_post_single', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 7) 
            {
                $ad_name = 'fundraiser';
                $url = route('single.fundraisers', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 705) 
            {
                $ad_name = 'service';
                $url = route('service_single', $blog->slug);
                $message = "A new {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
        } else {
            if ($blogs->category_id == 2) 
            {
                $ad_name = 'job';
                $url = route('jobpost', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 4) 
            {
                $ad_name = 'real estate';
                $url = route('real_esate_post', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 5) 
            {
                $ad_name = 'community';
                $url = route('community_single_post', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 6) 
            {
                $ad_name = 'shopping';
                $url = route('shopping_post_single', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 7) 
            {
                $ad_name = 'fundraiser';
                $url = route('single.fundraisers', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
            elseif ($blogs->category_id == 705) 
            {
                $ad_name = 'service';
                $url = route('service_single', $blog->slug);
                $message = "A {$ad_name} Ad \"{$blog->title}\" is featured by {$user->username}.";
            } 
        }
        // if ($category_name == 'Jobs') {
        //     $route = route('jobpost', $blog->slug);
        // } elseif ($category_name == 'Shopping') {
        //     $route = route('shopping_post_single', $blog->slug);
        // } elseif ($category_name == 'Welcome to our Community') {
        //     $route = route('community_single_post', $blog->slug);
        // } elseif ($category_name == 'Real Estate') {
        //     $route = route('real_esate_post', $blog->slug);
        // } elseif ($category_name == 'Services') {
        //     $route = route('service_single', $blog->slug);
        // }

        
        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
            //  dd($user->featured_post_count);
            if($user->featured_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->featured_post_count - 1;
            }
           
            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
            
            $notice1 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => $blogs->category_id,
                'type' => 'feature',
                'rel_id' => $blog->id,
                'message' => $message,
                'url' => $url,
                ];

            $notice2 = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'cate_id' => $blogs->category_id,
                'type' => 'feature',
                'rel_id' => $blog->id,
                'message' => "Your Ad \"{$blog->title}\" has been featured.",
                'url' => $url,
            ];

            $notices = [$notice1, $notice2];

            foreach ($notices as $notice) {
                Notification::create($notice);
            }

            $codes = [
                '{name}' => $user->username,
                '{post_url}' => $url,
                '{post_description}' => $user->description,
            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
           
            session::flash('success', 'Featured successfully.');
            return redirect()->back();
        }
    }


    public function is_post_is_feature_blog($post_id){
        $user = UserAuth::getLoginUser();
        $blog = BlogPost::where('id',$post_id)->first();
        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
            // dd($user->featured_post_count);
            if($user->featured_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->featured_post_count - 1;
            }
            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
            BlogPost::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 728,
                'type' => 'post',
                'rel_id' => $blog->id,
                'message' => "A new post \"{$blog->title}\" is featured by {$user->username}.",
                'url' => route('blogPostSingle', $blog->slug),
            ];
            Notification::create($notice); 

            $codes = [
                '{name}' => $user->username,
                '{post_url}' => route('blogPostSingle', $blog->slug),
                '{post_description}' => $user->description,

            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
           
            session::flash('success', 'Featured successfully.');
            return redirect()->back();
        }
    }




    public function is_post_is_feature_entertainment($post_id){

        $user = UserAuth::getLoginUser();
        $blog = Entertainment::where('id',$post_id)->first();

        // if ($blog->category_id == 741) 
        // {
        //     $ad_name = 'entertainment';
        //     $url = route('Entertainment.single.listing', $blog->slug);
        //     $message = "A new {$ad_name} post \"{$blog->Title}\" is featured by {$user->username}.";
        // }

        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
            // dd($user->featured_post_count);
            if($user->featured_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->featured_post_count - 1;
            }
            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
            Entertainment::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);

            if ($blog->created_at > Carbon::now()->subDays(38)->toDateString())
            {
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'post',
                    'rel_id' => $blog->id,
                    'message' => "A new entertainment post \"{$blog->Title}\" is featured by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $blog->slug),
                    ];
            } else {
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'post',
                    'rel_id' => $blog->id,
                    'message' => "A entertainment post \"{$blog->Title}\" is featured by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $blog->slug),
                    ];
            }
            Notification::create($notice); 

            $codes = [
                '{name}' => $user->username,
                '{post_url}' => route('Entertainment.single.listing', $blog->slug),
                '{post_description}' => $user->description,

            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
           
            session::flash('success', 'Featured successfully.');
            return redirect()->back();
        }
    }


    public function is_post_is_feature_business($post_id){
        $user = UserAuth::getLoginUser();
        $blog = Business::where('id',$post_id)->first();

        // if ($blogs->category_id == 1) 
        // {
        //     $ad_name = 'business';
        //     $url = route('business_page.front.single.listing', $blog->slug);
        //     $message = "A new {$ad_name} \"{$blog->business_name}\" is featured by {$user->username}.";
        // } 
        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
            // dd($user->featured_post_count);
            if($user->featured_post_count == 'Unlimited'){
                $new_post_count = 'Unlimited';
            }else{
                $new_post_count = (int) $user->featured_post_count - 1;
            }
            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
            Business::where('id', $blog->id)->update(['draft'=> '1','featured' => 'on','type' =>'Featured']);
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 1,
                'type' => 'post',
                'rel_id' => $blog->id,
                'message' => "A new business \"{$blog->business_name}\" is featured by {$user->username}.",
                'url' => route('business_page.front.single.listing', ['slug' => $blog->slug]),
                ];
            Notification::create($notice); 

            $codes = [
                '{name}' => $user->username,
                '{post_url}' => route('business_page.front.single.listing', $blog->slug),
                '{post_description}' => $user->description,

            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
           
            session::flash('success', 'Your business featured successfully.');
            return redirect()->back();
        }
    }
}
