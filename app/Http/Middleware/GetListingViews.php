<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Business;
use App\Models\Entertainment;
use App\Models\UserAuth;
use App\Models\ListingViews;

class GetListingViews
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
        if ($request->route('slug')) {
            $blog_slug = $request->route('slug');
            $blog = null;
            $postType = null;
            $user_id = null;
            $viewBy = null;
    
            // Check for the slug in the Blogs table
            $blog = Blogs::where('slug', $blog_slug)->first();
            if ($blog) {
                $user_id = $blog->user_id;
                $postType = 'blog'; // Set post type to blog
            }
    
            // Check for the slug in the Entertainment table
            if (!$blog) {
                $blog = Entertainment::where('slug', $blog_slug)->first();
                if ($blog) {
                    $user_id = $blog->user_id;
                    $postType = 'entertainment'; // Set post type to entertainment
                }
            }
    
            // Check for the slug in the Business table
            if (!$blog) {
                $blog = Business::where('slug', $blog_slug)->first();
                if ($blog) {
                    $user_id = $blog->user_id;
                    $postType = 'business'; // Set post type to business
                }
            }
    
            // If slug is not found in any of the tables, redirect
            if (empty($blog)) {
                return redirect('/');
            }
    
            if ($user_id != UserAuth::getLoginId()) {
                $viewBy = UserAuth::getLoginId();
            }
            $listingView = ListingViews::where('view_by', $viewBy)
                ->where('Post_id', $blog->id)
                ->where('type', $postType) 
                ->first();

            if (isset($listingView->view_by) && $listingView->view_by == $viewBy) {
                return $next($request);
            } elseif ($viewBy == "") {
                return $next($request);
            } else {
                ListingViews::create([
                    'Post_id' => $blog->id,
                    'count' => 1,
                    'view_by' => $viewBy,
                    'type' => $postType 
                ]);
            }
        }
    
        return $next($request);
    }
    
}