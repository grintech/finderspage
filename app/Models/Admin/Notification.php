<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAuth;


class Notification extends AppModel
{
  use SoftDeletes;
  // protected $table = 'notifications';
  protected $guarded = [];
  public $timestamps = false;
  
  
  public function user()
  {
    return $this->belongsTo(UserAuth::class, 'user_id');
  }

  public function notifications($limit = null)
  {
    return Notification::join('users', 'notifications.from_id', '=', 'users.id')
    ->where('to_id', 7)
    ->whereNull('notifications.deleted_at') // Assuming deleted_at is a column in the notifications table
    ->whereNull('users.deleted_at') // Assuming deleted_at is a column in the users table
    ->orderBy('notifications.id', 'DESC')
    ->limit($limit)
    ->get(['notifications.*', 'users.first_name','users.image']);
  }
  public function getAllNotice()
  {
    return Notification::join('users', 'notifications.from_id', '=', 'users.id')->where('to_id', 7)->where('deleted_at',null)->orderBy('id', 'DESC')->get(['notifications.*', 'users.first_name']);
  }
  public function getCount()
  {
    return Notification::where('to_id', 7)->where('deleted_at',null)->where('notifications.read', 0)->count();
  }

  public function getNotification($limit, $id)
  {
      return Notification::join('users', 'notifications.from_id', '=', 'users.id')
            ->whereNull('notifications.deleted_at') // Assuming deleted_at is a column in the notifications table
            ->whereNull('users.deleted_at') // Assuming deleted_at is a column in the users table
            ->where('notifications.to_id', $id)
            ->where('notifications.read', 0)
            ->where('notifications.hidden', 'false')
            ->orderBy('notifications.id', 'DESC')
            ->limit($limit)
            ->get(['notifications.*', 'users.first_name','users.image']);
  }  
  public function getUserCount($id)
  {
      return Notification::where('to_id', $id)->where('deleted_at',null)->where('read', 0)->count();    
  }

  public function get_admin_notification_for_user($id){
    return Notification::join('admins', 'notifications.from_id', '=', 'admins.id')
    ->whereNull('notifications.deleted_at') // Assuming deleted_at is a column in the notifications table
    ->whereNull('admins.deleted_at') // Assuming deleted_at is a column in the admins table
    ->where('notifications.to_id', $id)
    ->where('notifications.read', 0)
    ->orderBy('notifications.id', 'DESC')
    ->get(['notifications.*', 'admins.first_name','admins.image']);

  }





  // get all notification for user //

public function getadminnotificationforuser($id){
    return Notification::join('admins', 'notifications.from_id', '=', 'admins.id')
    ->whereNull('notifications.deleted_at') // Assuming deleted_at is a column in the notifications table
    ->whereNull('admins.deleted_at') // Assuming deleted_at is a column in the admins table
    ->where('notifications.to_id', $id)
    ->where('notifications.read', 1)
    ->orderBy('notifications.id', 'DESC')
    ->get(['notifications.*', 'admins.first_name','admins.image']);

  } 

public function getAllNoticeForUser($id)
{
    return Notification::join('users', 'notifications.from_id', '=', 'users.id')
        ->join('follows', 'notifications.from_id', '=', 'follows.following_id')
        ->whereNull('notifications.deleted_at')
        ->whereNull('users.deleted_at')
        ->where('notifications.to_id', $id)
        ->where('follows.block_notification', 'off')
        ->where('follows.follower_id', $id)
        ->where('notifications.hidden', 'false')
        ->orderBy('notifications.id', 'DESC')
        ->get(['notifications.*', 'users.first_name', 'users.image']);
}
 


  public static function create($data)
  {
    //  dd($data);
    $notice = new Notification();
    $notice->from_id = $data['from_id'];
    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;
    $notice->to_id = $data['to_id'];
    $notice->type = $data['type'];
    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;
    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;
    $notice->message = $data['message'];
    $notice->url = isset($data['url']) ? $data['url'] : null;
    $notice->save();
    // Broadcast the notification using Pusher
    event(new \App\Events\NewNotification($notice));
  }

  public static function create_post($data)
  {
    // dd($data);
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A new {$ad_name} post \"{$data['title']}\" is created by {$data['username']}.";
    }
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }

  public static function feature_create($data)
  {
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} post \"{$data['title']}\" is created by {$data['username']}.";
    }
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }

    public static function bump_create($data)
  {
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is created by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} post \"{$data['title']}\" is created by {$data['username']}.";
    }
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }

  
  public static function update_post($data)
  {
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A {$ad_name} \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A {$ad_name} post \"{$data['title']}\" is updated by {$data['username']}.";
    }    
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }

  public static function feature_update($data)
  {
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A featured {$ad_name} post \"{$data['title']}\" is updated by {$data['username']}.";
    }
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }

    public static function bump_update($data)
  {
    if ($data['cate_id'] == 1) 
    {
        $ad_name = 'business';
        $url = route('business_page.front.single.listing', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 2) 
    {
        $ad_name = 'job';
        $url = route('jobpost', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 4) 
    {
        $ad_name = 'real estate';
        $url = route('real_esate_post', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 5) 
    {
        $ad_name = 'community';
        $url = route('community_single_post', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 6) 
    {
        $ad_name = 'shopping';
        $url = route('shopping_post_single', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 7) 
    {
        $ad_name = 'fundraiser';
        $url = route('single.fundraisers', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 705) 
    {
        $ad_name = 'service';
        $url = route('service_single', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} Ad \"{$data['title']}\" is updated by {$data['username']}.";
    } 
    elseif ($data['cate_id'] == 741) 
    {
        $ad_name = 'entertainment';
        $url = route('Entertainment.single.listing', ['slug' => $data['slug']]);
        $message = "A bump {$ad_name} post \"{$data['title']}\" is updated by {$data['username']}.";
    }
    
    $notice = new Notification();

    $notice->from_id = $data['from_id'];

    $notice->rel_id = isset($data['rel_id']) ? $data['rel_id'] : null;

    $notice->to_id = $data['to_id'];

    $notice->type = $data['type'];

    $notice->cate_id = isset($data['cate_id']) ? $data['cate_id'] : null;

    $notice->notification_by = isset($data['notification_by']) ? $data['notification_by'] : 0;

    $notice->message = $message;

    $notice->url = isset($url) ? $url : null;

    $notice->save();

    event(new \App\Events\NewNotification($notice));
  }
}
