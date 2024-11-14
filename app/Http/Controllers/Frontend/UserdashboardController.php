<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\BlogCategories;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\ServiceHour;
use App\Models\Business;
use App\Models\ProductReview;
use App\Models\Blogs;
use App\Models\Like;
use App\Models\Admin\SubPlan;
use App\Models\Connected_business;
use DB;
use App\Models\Admin\Notification;
use App\Libraries\General;
use App\Models\Admin\Follow;
use App\Models\ListingViews;

class UserdashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        return view('frontend.dashboard_pages.index');
    }

    public function business_page()
    {
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 1",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        $hours = ServiceHour::where('user_id',UserAuth::getLoginId())->first();

        if ($hours === null) {
            // Set default values if $hours is null
            $days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
            $status = json_decode('{"monday":"on","tuesday":"on","wednesday":"on","thursday":"on","friday":"on","saturday":"on"}', true);
            $open_time = json_decode('{"monday":"09:00","tuesday":"09:00","wednesday":"09:00","thursday":"09:00","friday":"09:00","saturday":"09:00","sunday":"09:00"}', true);
            $close_time = json_decode('{"monday":"18:00","tuesday":"18:00","wednesday":"18:00","thursday":"18:00","friday":"18:00","saturday":"18:00","sunday":"19:00"}', true);
            $open_24 = null;
        } else {
            // Proceed if $hours is not null
            $days = !empty($hours['day']) ? json_decode($hours['day'], true) : null;
            $status = !empty($hours['status']) ? json_decode($hours['status'], true) : null;
            $open_time = !empty($hours['open_time']) ? json_decode($hours['open_time'], true) : null;
            $close_time = !empty($hours['close_time']) ? json_decode($hours['close_time'], true) : null;
            $open_24 = !empty($hours['open_24']) ? json_decode($hours['open_24'], true) : null;
            
        }
       return view('frontend.dashboard_pages.create_business_page',compact('categories','hours','days','status','open_time','close_time','open_24'));
    }



    public function store_business_page(Request $request)
{
    $business = new Business();
    // dd($request->all());
    // Set categories and subcategories
    $categories = $request->input('categories', []);
    $subCategories = [];

    // Handle subcategory check
    if ($request->input('sub_category') !== 'Other') {
        $subCategories = $request->input('sub_category', []);
    } else {
        $category = BlogCategories::where("title", $request->input('sub_category_oth'))->first();
        if ($category) {
            $subCategories[] = $category->id;
        }
    }

    // Create business page and get the business ID
    $businessId = $business->create_business_page($request);

    if ($businessId) {
        // Get the logged-in user
        $user = UserAuth::getLoginUser();
        
        // If the user has an unlimited featured post count, mark the business post as featured
        if ($user->featured_post_count === 'Unlimited') {
            Business::where('id', $businessId)
                ->update(['draft' => 1, 'featured' => 'on', 'type' => 'Featured']);
        }

        // Handle categories in batch if they are not empty
        if (!empty($categories)) {
            Blogs::handleCategories($businessId, $categories);
        }

        // Handle subcategories in batch
        if (!empty($subCategories)) {
            foreach($subCategories as $subcate){
                Blogs::handleSubCategories($businessId, $subcate);
            }
        }

        $request->session()->flash('success', 'Business page created successfully.');
        return redirect()->route('business_page.list');	

    } else {
        // Redirect with error message
        return redirect()->back()->with(['error' => 'Something went wrong.']);
    }
}






   public function edit_business_page($slug)
{
    // Redirect to signup if user is not logged in
    if (!UserAuth::isLogin()) {
        return redirect('/signup');
    }

    // Fetch categories with optimized query conditions
    $categories = BlogCategories::getAll(
        ['id', 'title', 'slug', 'image'],
        ["parent_id = 1", "blog_categories.status = 0"],
        'title asc'
    );

    // Fetch business details by slug
    $business = Business::where('slug', $slug)->first();

    // Fetch service hours for the logged-in user
    $hours = ServiceHour::where('user_id', UserAuth::getLoginId())->first();

    // Define default values for hours if not found
    $defaultHours = [
        'days' => ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"],
        'status' => [
            "monday" => "on", "tuesday" => "on", "wednesday" => "on",
            "thursday" => "on", "friday" => "on", "saturday" => "on"
        ],
        'open_time' => [
            "monday" => "09:00", "tuesday" => "09:00", "wednesday" => "09:00",
            "thursday" => "09:00", "friday" => "09:00", "saturday" => "09:00", "sunday" => "09:00"
        ],
        'close_time' => [
            "monday" => "18:00", "tuesday" => "18:00", "wednesday" => "18:00",
            "thursday" => "18:00", "friday" => "18:00", "saturday" => "18:00", "sunday" => "19:00"
        ]
    ];

    // If hours are null, use default values, otherwise decode existing data
    $days = $hours ? json_decode($hours['day'], true) : $defaultHours['days'];
    $status = $hours ? json_decode($hours['status'], true) : $defaultHours['status'];
    $open_time = $hours ? json_decode($hours['open_time'], true) : $defaultHours['open_time'];
    $close_time = $hours ? json_decode($hours['close_time'], true) : $defaultHours['close_time'];
    $open_24 = !empty($hours['open_24']) ? json_decode($hours['open_24'], true) : null;

    // Return the view with the required data
    return view('frontend.dashboard_pages.edit_business_page', compact('business', 'hours', 'days', 'status', 'open_time', 'close_time', 'categories','open_24'));
}


    public function update_business_page(Request $request, $id)
    {
        // dd($request->all());
        $business = Business::find($id);
        
        // Start with an empty array
        $categories = $subCategories = [];
    
        // Set the categories if present
        if (isset($request['category']) && $request['category']) {
            $categories = $request['category'];
        }
    
        // Handle subcategory check more efficiently
        if (isset($request['sub_category']) && $request['sub_category'] != 'Other') {
            $subCategories = $request['sub_category'];
        } elseif (isset($request['sub_category_oth'])) {
            $category = BlogCategories::firstOrCreate(['title' => $request['sub_category_oth']]);
            $subCategories[] = $category->id;
        }
    
        // Wrap everything in a transaction
        DB::beginTransaction();
    
        try {
            // Update the business page
            // dd($business);
            $businessId = $business->update_business_page($request, $id);
            // dd($business);
            if (!$businessId) {
                // dd($businessId);
                // Handle categories
                if (!empty($categories)) {
                    Blogs::handleCategories($id, $categories);
                }
    
                // Handle subcategories in bulk
                if (!empty($subCategories)) {
                    foreach($subCategories as $subcate){
                    Blogs::handleSubCategories($id, $subcate);
                    }
                }
    
                DB::commit(); // Commit the transaction
    
                // Redirect with success message
                return redirect()->back()->with(['success' => 'Business page updated successfully.']);
            } else {
                throw new \Exception('Business page update failed.');
            }
            } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on failure
    
            // Redirect with error message
            return redirect()->back()->with(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function business_page_list()
    {
        $business = Business::select('*')
            ->where('user_id', UserAuth::getLoginId())
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get();

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
            
        return view('frontend.dashboard_pages.bussiness_page_list', compact('business', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function business_listing()
    {
        $business_page =  Business::where('status', 1)->orderBy('id', 'desc')->get();
        // dd($business_page);
        return view('frontend.business.business_listing',compact('business_page'));
    }

    public function business_single_listing($slug)
    {
        $business = Business::where('slug', $slug)->first();
        $latest_business = Business::where('status', 1)
                            ->where('featured', 'on')
                            ->orderBy('id', 'desc') // Order by 'created_at' in descending order
                            ->limit(3)
                            ->get();
        //  dd($Lastest_business);
        // echo"<pre>";print_r($Lastest_business);die('developer');
        $followers = Follow::where('follower_id', $business->user_id)->where('status',1)->pluck('following_id')->toArray();
        $followerDetailsArray = [];
        foreach ($followers as $followerId) {
            $followerDetails = Users::where('id', $followerId)->select('id', 'first_name', 'image','slug','username')->first();
            // Check if the user details were found
            if ($followerDetails) {
                // Add follower details to the array
                $followerDetailsArray[] = [
                    'id' => $followerDetails->id,
                    'first_name' => $followerDetails->first_name,
                    'image' => $followerDetails->image,
                    'slug' => $followerDetails->slug,
                    'username' => $followerDetails->username,
                ];
            }
        }


        $shareComponent = \Share::page(
            'https://www.finderspage.com/business-single-list/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);


        // dd($followerDetailsArray);
        if (!$business) {
            abort(404, 'Business not found');
        }

        $viewsCount = ListingViews::where('post_id' , $business->id)->where('type', 'business')->count();

        $connected_business_member =  Connected_business::where('business_id',$business->id)->get();
        // dd($connected_business_member);
    
        // Retrieve all reviews for the business with their associated users
        $reviews = ProductReview::where('product_id', $business->id)
                                ->where('type', 'business')
                                ->with('user') // Assuming a relationship is defined in ProductReview model
                                ->get();

        $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
                                ->where('likes.blog_id',$business->id)
                                ->select('likes.*')
                                ->where('likes.type', 'Business')
                                ->get();
        $existingRecord = DB::table('saved_post')
                                ->where('user_id', UserAuth::getLoginId())
                                ->where('post_id', $business->id)
                                ->where('post_type', 'Business')
                                ->exists();
    
        return view('frontend.business.business_single_listing', compact('business', 'existingRecord','reviews','latest_business','followerDetailsArray','connected_business_member','BlogLikes','shareComponent','viewsCount'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Invite(Request $request)
    {
        // dd($request->all());
        $Connected_business = new  Connected_business();
        $user_data = UserAuth::getUser($request->from_id);
        
        $Connected_business = $Connected_business->create_connected_business($request);
        if(!$Connected_business){
            $notice = [
                'from_id' => $request->from_id,
                'to_id' => $request->user_id,
                'type' => 'invite',
                'url' => $request->business_url,
                'rel_id' => $request->business_id,
                'message' => $user_data->username .' invited you to connect to there business page.',
                ];
            Notification::create($notice); 
            return response()->json(['status' => 'success', 'message' => 'Member invited successfully.']);

        }
        
 
        // $codes = [
        //     '{name}' => $user->username,
        //     '{post_url}' => route('business_page.front.single.listing', ['slug' => $request->slug]);
        //     '{post_description}' =>  $user->description,

        // ];

        // General::sendTemplateEmail(
        //     $user->email,
        //     'feature-post',
        //     $codes
        // );
    }

    public function accept_invitation(Request $request)
    {
        $business_id = $request->business_id;
        $user_id = $request->user_id;
        $status = $request->status;

        // Find the connected business record
        $connected_business = Connected_business::where('business_id', $business_id)
            ->where('user_id', $user_id)
            ->first();

        // Check if the record exists
        if ($connected_business) {
            // Update the status
            $connected_business->status = $status;
            
            // Save the changes
            $connected_business->save();

            return response()->json(['message' => 'Status updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Record not found.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business =  Business::find($id);
        $business =  $business->delete(); 
        if ($business) {
            return redirect()->back()->with(['success' => 'Business deleted successfully.']);
        } else {
            // Redirect with error message
            return redirect()->back()->with(['error' => 'Something went wrong.']);
        }

    }




}
