<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use App\Models\Admin\Users;
use App\Models\UserAuth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\BlogCategories;


class AppController extends Controller
{
	

 	function __construct()
	{
		
	}

	public function getchildcat(Request $request) {
		$parentID = $request->input('selectedParent');
	
		if ($parentID == 6) {
			$sub_blog_categories = BlogCategories::where('parent_id', '>', 0)->orderBy('title', 'asc')->get();
			foreach ($sub_blog_categories as $listValue) {
				$listValue->main_parent_id = BlogCategories::where('id', $listValue->parent_id)->pluck('parent_id')->first();
			}
	
			$parentList = [];
			foreach ($sub_blog_categories as $main) {
				if ($main->parent_id == "6" || $main->main_parent_id == "6") {
					if (empty($main->main_parent_id)) {
						$parentList[] = [
							'id' => $main->id,
							'title' => $main->title,
							'slug' => $main->slug,
							'parentID' => $parentID
						];
					}
				}
			}
	
			$response = [];
			foreach ($parentList as $parent) {
				$response[] = [
					'id' => $parent['id'],
					'title' => $parent['title'],
					'slug' => $parent['slug'],
					'parentID' => $parent['parentID']
				];
	
				foreach ($sub_blog_categories as $sub) {
					if ($sub->parent_id == $parent['id']) {
						$response[] = [
							'id' => $sub->id,
							'title' => '&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;' . $sub->title,
							'slug' => $sub->slug,
							'parentID' => $parent['parentID']
						];
					}
				}
			}
	
			return response()->json($response);
	
		} else {
			$listing = BlogCategories::where('parent_id', $parentID)->orderBy('title', 'asc')->get(['id', 'title', 'slug']);
	
			$data = [];
			foreach ($listing as $object) {
				$data[] = [
					'id' => $object->id,
					'title' => $object->title,
					'slug' => $object->slug,
					'parentID' => $parentID 
				];
			}
	
			return response()->json($data);
		}
	}	
	
}
