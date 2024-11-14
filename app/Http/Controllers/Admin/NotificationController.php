<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\AppController;
use App\Models\Admin\Follow;
use App\Models\UserAuth;
use App\Models\Admin\Users;

class NotificationController extends AppController
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        Notification::where("read",0)->where('to_id',7)->update(['read'=> 1]);
        $notification = new Notification;
        $data['notify'] = $notification->notifications();
        //  dd($data);
        return view("admin.notification.notification")->with($data);
    }


    public function userNotification()
    {
        Notification::where("read",0)->where('to_id',UserAuth::getLoginId())->update(['read'=> 1]);
        $notification = new Notification;
        $data['notify'] = $notification->notifications();
        // dd($data);
        return view("frontend.dashboard_pages.notification")->with($data);
    }



    public function markAsRead($id)
    {
        // Find the notification by ID
        $notification = Notification::find($id);
        // dd($notification);

        if ($notification) {
            // Update the 'read' column to 1
            $notification->update(['read' => 1]);
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Notification not found.']);
        }
    }


    public function ClearNotification($id)
    {
        // Find the notification by ID
        $notification_Clear = Notification::where('to_id',$id)->get();

        if ($notification_Clear->count() > 0) {
            // Update the 'read' column to 1
            foreach($notification_Clear as $clear){
                    $clear->delete();
            }
            if ($notification_Clear->count() > 1) {
                return redirect()->back()->with(['success' => 'Notifications cleared successfully.']);
            }else{
                return redirect()->back()->with(['success' => 'Notification cleared successfully.']);
            }
        } else {
            return redirect()->back()->with(['success' =>  'Notification not found.']);
        }
    }
    
    public function hide_notification($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->hidden = 'true';
            $notification->save();

            return response()->json(['success' => 'Notification hidden successfully.']);
        }

        return response()->json(['error' => 'Notification not found.']);
    }
    
    public function block_notification($id)
    {
        $notification = Follow::where('follower_id', UserAuth::getLoginId())->where('following_id', $id)->first();

        if ($notification) {
            $notification->block_notification = 'on';
            $notification->save();

            return response()->json(['success' => 'Notifications blocked successfully.']);
        }

        return response()->json(['error' => 'Notification not found.']);
    }
    
    public function show_hidden($id)
    {
    
        $notifications = Notification::find($id);
    
        if ($notifications) {
    
            $hiddenNotifications = Notification::where('to_id', $id)
                                               ->where('hidden', 'true')
                                               ->get(); 
    
            $get_connected_user = Follow::where('follower_id', $id)
                                        ->whereNull('deleted_at')
                                        ->get(); 
            
            if ($hiddenNotifications->isEmpty()) {
                $html = '<div class="list-group-item list-group-item-action">
                            <div class="row justify-content-center">
                                <p class="text-sm mb-0">Empty Hidden Section.</p>
                            </div>
                         </div>';
            } else {
                $html = view('frontend.notification.hidden_notifications', compact('hiddenNotifications', 'get_connected_user'))->render();
            }
    
            return response()->json(['html' => $html]);
        } else {
            $html = '<div class="list-group-item list-group-item-action">
                        <div class="row justify-content-center">
                            <p class="text-sm mb-0">Empty Hidden Section.</p>
                        </div>
                     </div>';
                     
            return response()->json(['html' => $html]);
        }
        
        return response()->json(['error' => 'Notification not found.']);
    }


    public function show_blocked($id)
    {
        $blockedUsers = Follow::where('follower_id', $id)
            ->where('block_notification', 'on')
            ->get();
    
        if ($blockedUsers->isNotEmpty()) {
            
            $html = view('frontend.notification.blocked_notifications', compact('blockedUsers'))->render();
            
            return response()->json(['html' => $html]);
        } else {
            $html = '<div class="list-group-item list-group-item-action">
                            <div class="row justify-content-center">
                                <p class="text-sm mb-0">Empty Block Section.</p>
                            </div>
                        </div>';
                         
                return response()->json(['html' => $html]);
        }
    
        return response()->json(['error' => 'No blocked notifications found.']);
    }
    
    public function unhide_notification($id)
    {
        $notification = Notification::find($id);
        
        if ($notification) {
            $notification->hidden = 'false';
            $notification->save();
            
            return response()->json(['success' => 'Notification unhidden successfully.']);
        }
        
        return response()->json(['error' => 'Notification not found.']);
    }

    public function unblock_notification($id)
    {
        $notification = Follow::where('follower_id', UserAuth::getLoginId())->where('following_id', $id)->first();
                
        if ($notification) {
            $notification->block_notification = 'off';
            $notification->save();
            
            return response()->json(['success' => 'Notification unblock successfully.']);
        }
        
        return response()->json(['error' => 'Notification not found.']);
    }

}