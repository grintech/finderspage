<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Entertainment;
use App\Models\UserAuth;

class update_outdated_entertainment_post
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
        $entertainment =Entertainment::where('user_id', $userData->id)
        ->where('status',1)
        ->where('draft',1)
        ->where('deleted_at',null)
        ->pluck('created_at');

        foreach($entertainment as $blog){
          $givenTime = strtotime($blog);
          $currentTimestamp = time();
          $timeDifference = $currentTimestamp - $givenTime;
          $days = floor($timeDifference / (60 * 60 * 24));
          if ($days > 44) {
            DB::table('Entertainment')->update(['status' => 0 ]);
          }
        }
        return $next($request);
    }
}
