<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Follow;
use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Users;
use App\Models\UserAuth;
use App\Models\Setting;
use App\Libraries\General;
use Carbon\Carbon;

class FollowController extends AppController
{
    function __construct()
    {
        parent::__construct();
    }


    function doFollow(Request $request)
    {
        // dd($request->all());
        $data = [
            'follower_id' => $request->follower_id,
            'following_id' => $request->following_id,
            'status' => 1,

        ];

        $data2 = [
            'follower_id' => $request->following_id,
            'following_id' =>$request->follower_id,
            'status' => 1,
        ];
        $user = Users::find($request->following_id);
        $user_following = Users::find($request->follower_id);
        if($data['follower_id'] == $data['following_id']){
            return response()->json(['error' => 'You can\'t connect with yourself.']);
        }
        if($data['following_id'] ==''){
            return response()->json(['error' => 'You have to login first to connect with this user. Thank You.']);
        }
        $record = Follow::withTrashed()->where('follower_id', $request->follower_id)->where('following_id', $request->following_id)->first();
       if(Setting::get_setting("account" ,$request->follower_id) == "Public"){
            if ($record) {
                // dd($record);
                $record->restore();
                $notice = [
                    'from_id' => $request->following_id,
                    'to_id' => $request->follower_id,
                    'type' => 'follow',
                    'message' => $user->username.' is connected with you.',
                    'url' => route('UserProfileFrontend', $user->slug),
                ];
                Notification::create($notice);
                $record->update(['status' =>1]);
                $user = Users::where('id',$request->follower_id)->first();
                // dd($user);
                $codes = [
                        '{first_name}' => $user_following->first_name,
                        '{notification_link}' => route('user.notification'),
                    ];

                    General::sendTemplateEmail(
                        $user->email,
                        'member-connects',
                        $codes
                    );
                    if ($request->follower_id == 19) {
                        General::sendTemplateEmail(
                            'finderspage11@gmail.com',
                            'new-connection-request',
                            $codes
                        );
                    }
                return response()->json(['success' => 'You are connected with ' . $user_following->username . '.']);

            } else {
                // dd($request->all());
                Follow::create($data);
                Follow::create2($data2);
                $notice = [
                'from_id' => $request->following_id,
                'to_id' => $request->follower_id,
                'type' => 'follow',
                'message' => $user_following->username.' is connected with you.',
                'url' => route('UserProfileFrontend', $user_following->slug),
            ];
            Notification::create($notice);
            $user = Users::where('id',$request->following_id)->first();
            $codes = [
                    '{first_name}' => $user->first_name,
                    '{notification_link}' => route('user.notification'),
                ];

                General::sendTemplateEmail(
                    $user->email,
                    'member-connects',
                    $codes
                );
                if ($request->follower_id == 19) {
                    General::sendTemplateEmail(
                        'finderspage11@gmail.com',
                        'new-connection-request',
                        $codes
                    );
                }
            return response()->json(['success'=> 'You are connected with '.$user_following->username . '.']);
            }

       }else{
            if ($record) {
                // dd($record);
                $record->restore();
                $notice = [
                    'from_id' => $request->following_id,
                    'to_id' => $request->follower_id,
                    'type' => 'follow_notification',
                    'message' => $user->username.' has requested to connect with you.',
                    'url' => route('UserProfileFrontend', $user->slug),
                ];
                Notification::create($notice);
                $user = Users::where('id',$request->follower_id)->first();
                $codes = [
                    '{first_name}' => $user->first_name,
                    '{notification_link}' => route('user.notification'),
                ];
                if ($request->follower_id == 19) {
                    General::sendTemplateEmail(
                        'finderspage11@gmail.com',
                        'new-connection-request',
                        $codes
                    );
                }
                return response()->json(['success'=>'Your request has been sent.']);
            } else {
                // dd($request->all());
                unset($data['status']);
                unset($data2['status']);
                Follow::create($data);
                Follow::create2($data2);
                $notice = [
                'from_id' => $request->following_id,
                'to_id' => $request->follower_id,
                'type' => 'follow_notification',
                'message' => $user->username.' has requested to connect with you.',
                'url' => route('UserProfileFrontend', $user->slug),
            ];
            Notification::create($notice);
            $user = Users::where('id',$request->following_id)->first();
            $codes = [
                '{first_name}' => $user->first_name,
                '{notification_link}' => route('user.notification'),
            ];
            if ($request->follower_id == 19) {
                General::sendTemplateEmail(
                    'finderspage11@gmail.com',
                    'new-connection-request',
                    $codes
                );
            }
            return response()->json(['success'=>'Your request has been sent.']);
            }
       }
        
        
    }

    function unFollow(Request $request)
    {
        $record = Follow::where('follower_id',$request->follower_id)->where('following_id',$request->following_id)->first();
        $record->update(['status' => 0]);
         // dd($record);
        $record->delete();
        return response()->json(['success'=>'Disconnected']);
    }



    function RequestAccept(Request $request)
    {   
        // dd($request->all());
        $record = Follow::where('follower_id',$request->Cid)->where('following_id', $request->id)->first();

        // dd($record);

        if(!empty($record)){
            $record->update([
                'status' => $request->status,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $user = UserAuth::getLoginUser();
        }
           
        $user = UserAuth::getLoginUser();
        $notice = [
            'from_id' => $request->Cid,
            'to_id' => $request->id,
            'type' => 'follow-approved',
            'message' => $user->username . ' has accepted your follow request. Now you are connected with ' . $user->username . '.',
            'url' => route('UserProfileFrontend', $user->slug),
        ];        
        Notification::create($notice);
        $requested_user = Users::where('id',$request->id)->first();
            $codes = [
                    '{first_name}' => $requested_user->first_name,
                ];

                General::sendTemplateEmail(
                    $user->email,
                    'member-connects',
                    $codes
                );
        if($record->status == 1){
            return response()->json(['success'=>'Request accepted.']);  
          }else{
            return response()->json(['error'=>'Somthing went wrong.']);  
          }
        
    }
}
