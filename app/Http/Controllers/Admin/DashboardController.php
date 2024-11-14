<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\BlogCategories;
use App\Models\Admin\Blogs;
use App\Models\UserEnquiry;
use Illuminate\Http\Request;
use App\Models\Admin\Settings;
use App\Libraries\General;
use App\Models\Admin\Users;
use App\Models\Admin\Products;
use App\Models\Admin\ContactUs;
use App\Models\Admin\Feedback;
use App\Models\Admin\CreatorReviews;
use App\Models\Admin\PurchasedPlans;
use App\Models\Admin\ProductForms;


class DashboardController extends AppController
{
	function __construct()
	{
		parent::__construct();

	}

	function index(Request $request)
	{
		$check = new Users();
		$blog = new Blogs();
		$individual = count($check->getAll('id', ['role' => 'individual'])) ?? 0;
		$business = count($check->getAll('id', ['role' => 'business'])) ?? 0;
		$inactiveProducts = BlogCategories::whereNull('parent_id')->count();
		$totalpost = Blogs::count();
		$featuredPost = count($blog->getAll('id', ['featured_post' => 'on'])) ?? 0;
		$enquries = UserEnquiry::count();
		return view("admin/dashboard/dashboard", [
			'individual' => $individual,
			'business' => $business,
			'inactiveProducts' => $inactiveProducts,
			'totalpost' => $totalpost,
			'featuredPost' => $featuredPost,
			'enquries' => $enquries,
		]);
	}

}