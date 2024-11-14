<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\General;
use App\Models\Admin\Follow;
use App\Models\Admin\ProfileCategory;
use App\Models\Admin\Users;
use App\Models\BlogCategories;
use App\Models\BlogCategoryRelation;
use App\Models\UserAuth;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Resume;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/login');
        }


       $resume_setting = Setting::get_setting("resume_setting", UserAuth::getLoginId());
    
       $currentUserId = UserAuth::getLoginId();
        // Query the database
        $resumeType = Resume::where('user_id', $currentUserId)->value('resume_type');
       
        $business_userID = General::decrypt($id);
        $user = Users::where('id', $business_userID)->first();

        // for follow
        $follows = Follow::where('following_id', UserAuth::getLoginId())->where('follower_id', $business_userID)->first();
        // dd($follows);
        $followers = Follow::where('follower_id', $business_userID)->count();
        $following = Follow::where('following_id', $business_userID)->count();

        //Users all posts
        $all_posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('status', 1)->where('user_id', UserAuth::getLoginId())->get();
        // Get Find a job Category Posts
        $find_job_posts = array();
        $find_job_id = '2';
        $post_ids = BlogCategoryRelation::where('category_id', $find_job_id)->pluck('blog_id')->toArray();
        if (count($post_ids)) {
            $post_ids = array_unique($post_ids);
            $find_job_posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('status', 1)->where('user_id', UserAuth::getLoginId())->whereIn('id', $post_ids)->get();
        }

        //Get Real Estate/Loading Posts
        $post_ids = array();
        $real_estate_posts = array();
        $real_estate_id = '4';
        $post_ids = BlogCategoryRelation::where('category_id', $real_estate_id)->pluck('blog_id')->toArray();
        if (count($post_ids)) {
            $post_ids = array_unique($post_ids);
            $real_estate_posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('status', 1)->where('user_id', UserAuth::getLoginId())->whereIn('id', $post_ids)->get();
        }

        //Welcome to our community
        $post_ids = array();
        $our_community_posts = array();
        $our_community_id = '5';
        $post_ids = BlogCategoryRelation::where('category_id', $our_community_id)->pluck('blog_id')->toArray();
        if (count($post_ids)) {
            $post_ids = array_unique($post_ids);
            $our_community_posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('status', 1)->where('user_id', UserAuth::getLoginId())->whereIn('id', $post_ids)->get();
        }

        //Online Shoping
        $post_ids = array();
        $online_shopping_posts = array();
        $online_shopping_id = '6';
        $post_ids = BlogCategoryRelation::where('category_id', $online_shopping_id)->pluck('blog_id')->toArray();
        if (count($post_ids)) {
            $post_ids = array_unique($post_ids);
            $online_shopping_posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('status', 1)->where('user_id', UserAuth::getLoginId())->whereIn('id', $post_ids)->get();
        }

        $profilePercentage = $this->calculateProfilePercentage($user);

        $setting = Setting::where('user_id',UserAuth::getLoginId())->get();
         $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =1045",
            ],
            'title asc',
        );
            // dd($profilePercentage);
        return view("frontend.dashboard_pages.profile", [
            'user' => $user, 'all_posts' => $all_posts, 'find_job_posts' => $find_job_posts,
            'real_estate_posts' => $real_estate_posts, 'our_community_posts' => $our_community_posts,
            'online_shopping_posts' => $online_shopping_posts,
            'follows' => $follows,
            'followers' => $followers,
            'following' => $following,
            'Percentage' => $profilePercentage,
            'setting' => $setting,
            'resume_setting' =>  $resume_setting,
            'resume_type' => $resumeType,
            'categories' => $categories,
        ]);
        // return view("frontend.dashboard_pages.profile");
    }



    public function edit_profile($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/login');
        }
        $user_id = General::decrypt($id);
        $user = Users::where('id', $user_id)->first();
        $category = ProfileCategory::where('user_roles', 'individual')->get();
        $setting = Setting::where('user_id',UserAuth::getLoginId())->get();

        //Usage example:
        $profilePercentage = $this->calculateProfilePercentage($user);
         // dd($country);

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =1045",
            ],
            'title asc',
        );
        // dd( $categories);s
        return view("frontend.dashboard_pages.edit_profile", ['user' => $user, 'category' => $category ,'Percentage' => $profilePercentage ,'setting' => $setting , 'categories'=> $categories ]);
        // return view("frontend.dashboard_pages.edit_profile");
    }

    public function updateProfile(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/login');
        }

        // dd($request->all());
        $filteredArray = array_filter($request->business_website, function($value) {
            return !empty($value);
        });
    
        $primaryIndex = (int)$request->primary_website;

        if (array_key_exists($primaryIndex, $filteredArray)) {

            $primaryWebsite = $filteredArray[$primaryIndex];

            unset($filteredArray[$primaryIndex]);

            $filteredArray = array_values($filteredArray);

            array_unshift($filteredArray, $primaryWebsite);
        }
        // dd($filteredArray);

        $filteredTitle = array_filter($request->website_title, function($value) {
            return !empty($value);
        });

        if (array_key_exists($primaryIndex, $filteredTitle)) {

            $primaryWebsite = $filteredTitle[$primaryIndex];

            unset($filteredTitle[$primaryIndex]);

            $filteredTitle = array_values($filteredTitle);

            array_unshift($filteredTitle, $primaryWebsite);
        }
        // dd($filteredTitle);

        $user = Users::find($id);

         // dd($user->first_time_login);
        // if ($request->hasFile('Zodiac_image')) {
        //             $Zodiac = $request->file('Zodiac_image');
        //             $ZodiacName = time() . '.' . $Zodiac->getClientOriginalExtension();
        //             $Zodiac->move(public_path('/assets/images/profile'), $ZodiacName);
        //             $user->Zodiac_image = $ZodiacName;
        //         }

        $birthdate = $request->birthday;
         // dd($birthdate);
        // Parse the birthdate and calculate the zodiac sign
        if(!empty($birthdate)){
        $birthDate = strtotime($birthdate);
        $month = date('n', $birthDate);
        $day = date('j', $birthDate);

        $zodiacSigns = [
            'Aquarius' => [1, 20, 2, 18, 'aquarius.png'],
            'Pisces' => [2, 19, 3, 20, 'Pisces.png'],
            'Aries' => [3, 21, 4, 19, 'Aries.png'],
            'Taurus' => [4, 20, 5, 20, 'Taurus.png'],
            'Gemini' => [5, 21, 6, 20, 'Gemini.png'],
            'Cancer' => [6, 21, 7, 22, 'Cancer.png'],
            'Leo' => [7, 23, 8, 22, 'Leo.png'],
            'Virgo' => [8, 23, 9, 22, 'Virgo.png'],
            'Libra' => [9, 23, 10, 22, 'Libra.png'],
            'Scorpio' => [10, 23, 11, 21, 'Scorpio.png'],
            'Sagittarius' => [11, 22, 12, 21, 'Sagittarius.png'],
            'Capricorn' => [12, 22, 1, 19, 'Capricorn.png'],
        ];

        foreach ($zodiacSigns as $sign => $dates) {
        list($startMonth, $startDay, $endMonth, $endDay, $image) = $dates;
        if (($month == $startMonth && $day >= $startDay) || ($month == $endMonth && $day <= $endDay)) {
            $zodiacName = $sign;
            $zodiacImage = $image;
            break;
        }
    }

}
        if($request->Tiktok != ""){
            $tiktok = '@'.$request->Tiktok;
        }else{
            $tiktok ="";
        }
       
        // dd($tiktok);
        
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = $request->last_name;
        $user->zodiac_name = isset($zodiacName) ? $zodiacName : null;
        $user->Zodiac_image = isset($zodiacImage) ? $zodiacImage : null;
        $user->email = $request->email;
        $user->first_time_login = 1;
        $user->username = $request->username;
        $user->dob = $birthdate;
        $user->bio = $request->bio;
        $user->phonenumber = $request->phonenumber;
        $user->website_title = implode(',', $filteredTitle);
        $user->business_website = implode(',', $filteredArray);
        $user->address = $request->address;
        $user->state = $request->state;
        $user->zipcode = $request->zipcode;
        $user->twitter = $request->twitter;
        $user->youtube = $request->youtube;
        $user->facebook = $request->facebook;
        $user->instagram = $request->instagram;
        $user->linkedin = $request->linkedin;
        $user->Tiktok = $tiktok;
        $user->role_category = $request->category;
        $user->profession = $request->profession;
        $profilePercentage = $this->calculateProfilePercentage($user);
        $user->profile_percent = $profilePercentage['percent'];
        $user->update(); //Update the data

        $codes = [
                    '{first_name}' =>$request->first_name,
                ];
        General::sendTemplateEmail(
                            $request->email,
                            'profile-update',
                            $codes
                        );
        if($user->first_time_login == 0){
            $request->session()->flash('success', 'Profile has been updated successfully. Now you can create post.');
            return redirect()->route('index_user', ['id' => General::encrypt($user->id)]);
        }
        $request->session()->flash('success', 'Profile has been updated successfully');
        $category = ProfileCategory::where('user_roles', 'individual')->get();
        // return view("frontend.business.user.edit_profile", ['user' => $user, 'category' => $category]);
        // return redirect()->route('businessUserProfile', ['id' => General::encrypt($user->id)]);
         return redirect()->route('user_profile', ['id' => General::encrypt($user->id)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function profile_image(Request $request)
        {
            if ($request->hasFile('dp')) {
                $image = $request->file('dp');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/images/profile');
                $image->move($destinationPath, $name);

                $update_pro = Users::where('id', $request->id)
                    ->update(['image' => $name ]);

                if ($update_pro) {
                    return response()->json(['success' => 'Profile image updated.']);
                } else {
                    return response()->json(['error' => 'Something went wrong.']);
                }
            } else {
                // Handle the case when no file is uploaded (image removed)
                $update_pro = Users::where('id', $request->id)
                    ->update(['image' => null]); // Assuming 'image' column is nullable

                if ($update_pro) {
                    return response()->json(['success' => 'Profile image removed.']);
                } else {
                    return response()->json(['error' => 'Something went wrong.']);
                }
            }
        }
    // public function profile_image(Request $request)
    // {

    //     if ($request->hasFile('dp')) {
    //         $image = $request->file('dp');
    //         $name = time() . '.' . $image->getClientOriginalExtension();
    //         $destinationPath = public_path('/assets/images/profile');
    //         $image->move($destinationPath, $name);
    //         $update_pro = Users::where('id', $request->id)
    //         ->update(['image' => $name ]);

    //         $user =  Users::find($request->id);
    //         $profilePercentage = $this->calculateProfilePercentage($user);
    //         $user->profile_percent = $profilePercentage['percent'];
    //         $user->update(); // Update the data
    //     if($update_pro){
    //          return response()->json(['success' => 'Profile image updated.']);
            
    //     }
    //          return response()->json(['error' => 'Something went wrong.']);
       
    //     }

        

         
    // }

    public function profile_cover_image(Request $request)
        {
            if ($request->hasFile('dp')) {
                $image = $request->file('dp');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/assets/images/profile');
                $image->move($destinationPath, $name);

                $update_pro = Users::where('id', $request->id)
                    ->update(['cover_img' => $name ]);

                if ($update_pro) {
                    return response()->json(['success' => 'Cover image updated.']);
                } else {
                    return response()->json(['error' => 'Something went wrong.']);
                }
            } else {
                // Handle the case when no file is uploaded (cover image removed)
                $update_pro = Users::where('id', $request->id)
                    ->update(['cover_img' => null]); // Assuming 'cover_img' column is nullable

                if ($update_pro) {
                    return response()->json(['success' => 'Cover image removed.']);
                } else {
                    return response()->json(['error' => 'Something went wrong.']);
                }
            }
        }


    // public function profile_cover_image(Request $request)
    // {
       
    //     if ($request->hasFile('dp')) {
    //         $image = $request->file('dp');
    //         $name = time() . '.' . $image->getClientOriginalExtension();
    //         $destinationPath = public_path('/assets/images/profile');
    //         $image->move($destinationPath, $name);
    //         $update_pro = Users::where('id', $request->id)
    //     ->update(['cover_img' => $name ]);
    //     if($update_pro){
    //          return response()->json(['success' => 'Cover image updated.']);
            
    //     }
    //          return response()->json(['error' => 'Something went wrong.']);
       
    //     }    
    // }

public function calculateProfilePercentage(Users $user)
    {
        $weights = [
            'first_name' => 10,
            'email' => 10,
            'image' => 10,
            'phonenumber' => 10,
            'bio' => 10,
            'business_website' => 10,
            'address' => 10,
        ];
    $completionStatus = [
        'first_name' => $user->first_name ? 1 : 0,
        'email' => $user->email ? 1 : 0,
        'image' => $user->image ? 1 : 0,
        'phonenumber' => $user->phonenumber ? 1 : 0,
        'bio' => $user->bio ? 1 : 0,
        'business_website' => $user->business_website ? 1 : 0,
        'address' => $user->address ? 1 : 0,
    ];

    // echo '<pre>'; print_r($completionStatus); echo '</pre>';

    $firsterror = $emailerror = $imageerror = $phonenumbererror = $bioerror = $business_error = $addresserror  = '';

    foreach ($completionStatus as $key => $value) {
        if ($value === 0) {
            if ($key === 'first_name') {
                $firsterror = "Please fill in the first name to complete your profile!";
            }
            if ($key === 'email') {
                $emailerror = "Please fill in the email to complete your profile!";
            }
            if ($key === 'image') {
                $imageerror = "Please upload an image to complete your profile!";
            }
            if ($key === 'phonenumber') {
                $phonenumbererror = "Please fill in the phone number to complete your profile!";
            }
            if ($key === 'bio') {
                $bioerror = "Please fill in the bio to complete your profile!";
            }
            if ($key === 'business_website') {
                $business_error = "Please fill in the website to complete your profile!";
            }
            if ($key === 'address') {
                $addresserror = "Please fill in the address to complete your profile!";
            }
        }
    }
        // echo 'DEV HERE'.$phonenumbererror;
        

        $totalWeight = array_sum($weights);
        $weightedCompletion = array_map(function ($status, $weight) {
            return $status * $weight;
        }, $completionStatus, $weights);

        $profilePercentage = (array_sum($weightedCompletion) / $totalWeight) * 100;

         $newvar = [
            'first_name' => $firsterror,
            'email' => $emailerror,
            'image' =>  $imageerror,
            'phonenumber' => $phonenumbererror,
            'bio' => $bioerror,
            'business_website' => $business_error,
            'address' => $addresserror,
            'percent' => $profilePercentage,
        ];

           
        return $newvar;
    }
    

    public function fetch_state(Request $request)
    {   
       // dd($request->all()); 
        $user = Users::find($request->userid);
        // dd($user);
        $state = State::where('country_id', $request->id)->get();
        $stateHtml = "";

        foreach ($state as $states) {
          $stateHtml .= "<option " . ($user->state == $states["id"] ? 'selected' : '') . " value='" . $states["id"] . "'>" . $states["name"] . "</option>";
        }
        return response()->json(
            [
                'success' => 'Profile image updated.',
                "option_html" => $stateHtml
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resume_setting(Request $request)
    {
        $settingName = 'resume_setting';
        $settingValue = $request->resume;
        $userid = UserAuth::getLoginId();

        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
        ];

       $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );

        if ($setting->wasRecentlyCreated) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getconnectedUser($id)
    {
        $user_id = $id;
        // $followers = Follow::where('following_id', $user_id)->get();
        $followers_id = Follow::where('follower_id', $user_id)->where('status',1)->pluck('following_id')->toArray();
        $followerArray = [];

        foreach ($followers_id as $follower_id) {
            $follower = Users::find($follower_id);

            // Now $follower contains the user data for each follower
            if ($follower) {
                // Build an array with follower data
                $followerArray[] = [
                    'id' => $follower->id,
                    'first_name' => $follower->first_name,
                    'image' => $follower->image,
                    'username' => $follower->username,
                    'cover_img' => $follower->cover_img,
                    'slug' => $follower->slug,
                    // Add other properties you want to include

                ];
            }
            // dd($followers);
        }

        return view('frontend.FollowersList',compact('followerArray'));
        
    }


    public function Do_Not_Disturb(Request $request)
    {
    // dd($request->all());
        if($request->dnd_status == 1){
            $user = Users::where('id', $request->id)
                    ->update([
                        'DND' => $request->dnd_status,
                ]);
            if($user){
                 return response()->json(['success' => 'Do not disturb is active.']);
                
            }else{
               return response()->json(['error' => 'Somthing went wrong.']);
            }
        }elseif($request->dnd_status == 0){
            $user = Users::where('id', $request->id)
                    ->update([
                        'DND' => $request->dnd_status,
                ]);
            if($user){
                return response()->json(['success' => 'Do not disturb is inactive.']);
            }else{
                return response()->json(['error' => 'Somthing went wrong.']);
            }
        }
    }
}
