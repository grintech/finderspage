<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BlogsViews;
use App\Models\UserAuth;

class GetBlogViews
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
        if ($request->route('id')) {
            
            $blog_id = $request->route('id');
            $viewBy = UserAuth::getLoginId();
           $Blogs = BlogsViews::where('view_by',$viewBy)->where('Post_id',$blog_id)->first();
           if(isset($Blogs->view_by) && $Blogs->view_by == $viewBy){
             return $next($request);
           }elseif($viewBy == ""){
            return $next($request);
           }else{
            BlogsViews::Create(['Post_id' => $blog_id ,'count' =>  1 , 'view_by' => $viewBy , 'type' => 'Blog']);
           }  
        }
        return $next($request);
    }
}
