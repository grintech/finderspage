<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AppController extends Controller
{
 	function __construct()
	{
		$notification = new Notification;
		View::share('notifications',$notification->notifications(5));
		View::share ( 'countNotice', $notification->getCount() ? $notification->getCount() : null);  
		

	}
}
