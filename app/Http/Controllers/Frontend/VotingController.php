<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Session;
use Stripe;
use DB;
use App\Libraries\General;
use App\Models\UserAuth;
use Carbon\Carbon;
use App\Models\Voting;

class VotingController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signupuser');
        }
        
        $user_id = UserAuth::getLoginId();
        $blog_id = base64_decode($request->post_id);
        $check = Voting::where('user_id',$user_id)->where('blog_id',$blog_id)->first();
        if(!$check){
             $vote = new Voting();
            $vote->user_id =  UserAuth::getLoginId();
            $vote->blog_id =  base64_decode($request->post_id);
            $vote->question_id = $request->question_id;
            $vote->option_id = $request->vote;
            $vote->save();

              // $request->session()->flash('error', 'Blog could not be save. Please try again.');
                        return redirect()->back()->withSuccess('Your response has been successfuly saved.');
        } else {

            return redirect()->back()->withError('You have alreday voted for this event.');

           }
       

      
        
    }

}