<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\UserAuth;
use App\Models\Admin\BlogCategoryRelation;
use Carbon\Carbon;
use DB;

class update_outdated_post
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
        $userData = UserAuth::getLoginUser();
        $blogs =Blogs::where('user_id', $userData->id)
        ->where('status',1)
        ->where('draft',1)
        ->where('deleted_at',null)
        ->pluck('created');

        foreach($blogs as $blog){
        $givenTime = strtotime($blog);
          $currentTimestamp = time();
          $timeDifference = $currentTimestamp - $givenTime;
          $days = floor($timeDifference / (60 * 60 * 24));
          if ($days > 44) {
            DB::table('blogs')->update(['status' => 0 ]);
          }
        }
        return $next($request);
    }
}
