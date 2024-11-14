<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PostView;
use App\Models\UserAuth;


class RecordPostView
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
       
        if ($request->route('user_id')) {
            
            $user = $request->route('user_id');
            $viewBy = UserAuth::getLoginId();
           $profile = PostView::where('view_by',$viewBy)->where('user_id',$user)->first();
           if(isset($profile->view_by) && $profile->view_by == $viewBy){
             return $next($request);
           }elseif($viewBy == ""){
            return $next($request);
           }else{
            PostView::Create(['user_id' => $user ,'count' =>  1 , 'view_by' => $viewBy]);
           }  
        }

        return $next($request);

    }
}
