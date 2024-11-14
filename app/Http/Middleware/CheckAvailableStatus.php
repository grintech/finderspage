<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Business;
use App\Models\Admin\BlogCategoryRelation;
use Carbon\Carbon;
use DB;
class CheckAvailableStatus
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
        $blogs = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
        ->where('blogs.status', '=', '1')
        ->where('blogs.deleted_at', null)
        ->where('blogs.draft', 1)
        ->whereIn('blog_category_relation.category_id', [705, 4]) // Check for both category IDs
        ->groupBy('blogs.id')
        ->get();
        //  dd($blogs); 
        foreach($blogs as $blog){
            // Check if 60 minutes have passed since they became available
            if ($blog && now()->greaterThanOrEqualTo($blog->available_since)) {
                $availableUpdate = DB::table('blogs')
                    ->where('id', $blog->blog_id)
                    ->limit(1)
                    ->update(['available_now' => 0 ,'available_since' => null]);
            }
        }
        
        $businesses = Business::where('status',1)->where('deleted_at', null)->get();
        foreach($businesses as $business){
            // Check if 60 minutes have passed since they became available
            if ($business && now()->greaterThanOrEqualTo($business->available_since)) {
                $businessUpdate = DB::table('businesses')
                    ->where('id', $business->id)
                    ->limit(1)
                    ->update(['available_now' => 0 ,'available_since' => null]);
            }
        }
        
        return $next($request);
    }
}
