<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserAuth;
use App\Models\Blogs;
use Illuminate\Support\Facades\DB;
class CheckSubscriptionPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = UserAuth::getLoginUser();
            $userId = $user->id;



           $count = DB::table('blogs')
                ->where('user_id', $userId)
                ->where('featured_post', 'on')
                ->count();

            $count += DB::table('blog_post')
                ->where('user_id', $userId)
                ->where('featured_post', 'on')
                ->count();

            $count += DB::table('Entertainment')
                ->where('user_id', $userId)
                ->where('featured_post', 'on')
                ->count();

            $count += DB::table('videos')
                ->where('user_id', $userId)
                ->where('featured_post', 'on')
                ->count();

        // Count the number of featured posts the user has
        $featured_post_count = $user->featured_post_count;


// dd($featured_post_count);
    if($user->free_listing!= 1){

    
        if($featured_post_count==null){

            return redirect()->back()->with('error_subscription_new', 'For featured post Kindly subscribe plans.');
        }else{

            // Check if the user has reached the limit for featured posts
            if ($count >= $featured_post_count && $featured_post_count!="Unlimited") {
                return redirect()->back()->with('error_subscription_check', 'You have reached the limit for featured posts.Kindly upgrade your plan.');
            }
        }
        // Allow the request to proceed if the user hasn't reached the limit
        return $next($request);
    }else{
     return $next($request); 
    }   
}

}
