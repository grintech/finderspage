<?php

namespace App\Http\Controllers\Frontend;

// use App\Http\Controllers\Controller;
use App\Libraries\General;
use App\Models\Admin\Follow;
use App\Models\Admin\ProfileCategory;
use App\Models\Admin\Users;
use App\Models\BlogCategoryRelation;
use App\Models\UserAuth;
use Illuminate\Http\Request;

class UserProfileController extends AppController
{
    public function __construct()
    {
        parent::__construct();
   
    }

    public function UserProfile(Request $request, $id)
    {
        
        $business_userID = General::decrypt($id);
        $user = Users::where('id', $business_userID)->first();

        // for follow
        $follows = Follow::where('following_id', UserAuth::getLoginId())->where('follower_id', $business_userID)->first();
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

        return view("frontend.business.user.profile", [
            'user' => $user, 'all_posts' => $all_posts, 'find_job_posts' => $find_job_posts,
            'real_estate_posts' => $real_estate_posts, 'our_community_posts' => $our_community_posts,
            'online_shopping_posts' => $online_shopping_posts,
            'follows' => $follows,
            'followers' => $followers,
            'following' => $following
        ]);

        // return view("frontend.dashboard_pages.profile", [
        //     'user' => $user, 'all_posts' => $all_posts, 'find_job_posts' => $find_job_posts,
        //     'real_estate_posts' => $real_estate_posts, 'our_community_posts' => $our_community_posts,
        //     'online_shopping_posts' => $online_shopping_posts,
        //     'follows' => $follows,
        //     'followers' => $followers,
        //     'following' => $following
        // ]);
    }



    public function businessUserProfile(Request $request, $id)
    {
        
        // $business_userID = General::decrypt($id);
        $business_userID = $id;
        $user = Users::where('id', $business_userID)->first();

        // for follow
        $follows = Follow::where('following_id', UserAuth::getLoginId())->where('follower_id', $business_userID)->first();
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

        return view("frontend.business.business_page", [
            'user' => $user, 'all_posts' => $all_posts, 'find_job_posts' => $find_job_posts,
            'real_estate_posts' => $real_estate_posts, 'our_community_posts' => $our_community_posts,
            'online_shopping_posts' => $online_shopping_posts,
            'follows' => $follows,
            'followers' => $followers,
            'following' => $following
        ]);
    }

    // Show Edit User Profile page
    public function editUserProfile(Request $request, $id)
    {
        //die('HERE');
        $user_id = General::decrypt($id);
        $user = Users::where('id', $user_id)->first();
        $category = ProfileCategory::where('user_roles', 'individual')->get();
        return view("frontend.business.user.edit_profile", ['user' => $user, 'category' => $category]);
    }

    // Update User profile
    public function updateUserProfile(Request $request, $id)
    {
        //echo"<pre>"; print_r($request->all());  die;
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|string',
            'website' => 'required|url',
            'phone' => 'numeric|required',
            'address' => 'required',
            'category' => 'required',
            'dp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = Users::find($id);
        $user->first_name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phone;
        $user->business_website = $request->website;
        $user->address = $request->address;
        $user->role_category = $request->category;
        if ($request->hasFile('dp')) {
            $image = $request->file('dp');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/profile');
            $image->move($destinationPath, $name);
            $user->image = $name;
        }
        $user->update(); // Update the data
        $request->session()->flash('success', 'Profile has been updated successfully.');
        $category = ProfileCategory::where('user_roles', 'individual')->get();
        // return view("frontend.business.user.edit_profile", ['user' => $user, 'category' => $category]);
        // return redirect()->route('businessUserProfile', ['id' => General::encrypt($user->id)]);
         return redirect()->route('index_user', ['id' => General::encrypt($user->id)]);
    }

    // Show Edit Business Profile page
    public function editBusinessProfile(Request $request, $id)
    {
        $user_id = General::decrypt($id);
        $user = Users::where('id', $user_id)->first();
        return view("frontend.business.edit_profile", ['user' => $user]);
    }

    // Update Business profile
    public function updatebusinessProfile(Request $request, $id)
    {
        // echo"<pre>"; print_r($request->all());  die;
        // $uid = General::decrypt($id);
        $this->validate($request, [
            'business_email' => 'required|email',
            'business_name' => 'required|string',
            //'business_dp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = Users::find($id);
        $user->business_name = $request->business_name;
        $user->business_email = $request->business_email;
        $user->business_phone = $request->business_phone;
        $user->business_website = $request->business_website;
        $user->business_address = $request->business_address;
        $user->role_category = $request->role_category;
        if ($request->hasFile('business_dp')) {
            $image = $request->file('business_dp');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/business');
            $image->move($destinationPath, $name);
            $user->business_images = $name;
        }
        // Mon
        $user->mon_am = $request->mon_am;
        $user->mon_pm = $request->mon_pm;
        // Tue
        $user->tue_am = $request->tue_am;
        $user->tue_pm = $request->tue_pm;
        // Wed
        $user->wed_am = $request->wed_am;
        $user->wed_pm = $request->wed_pm;
        // Thursday
        $user->thur_am = $request->thur_am;
        $user->thur_pm = $request->thur_pm;
        // Fri
        $user->fri_am = $request->fri_am;
        $user->fri_pm = $request->fri_pm;
        // Sat
        $user->sat_am = $request->sat_am;
        $user->sat_pm = $request->sat_pm;
        // Sun
        $user->sun_am = $request->sun_am;
        $user->sun_pm = $request->sun_pm;

        $user->all_business = $request->all_business;
        $user->wheelchair = $request->wheelchair;
        $user->black_owned = $request->black_owned;
        $user->latinx_owned = $request->latinx_owned;
        $user->women_owned = $request->women_owned;
        $user->asian_owned = $request->asian_owned;
        $user->lgbtq_owned = $request->lgbtq_owned;
        $user->veteran_owned = $request->veteran_owned;
        $user->bike_parking = $request->bike_parking;
        $user->ev_charging = $request->ev_charging;
        $user->plastic_free = $request->plastic_free;
        $user->vaccination_required = $request->vaccination_required;
        $user->fully_vaccinated = $request->fully_vaccinated;
        $user->masks_required = $request->masks_required;
        $user->staff_wears_masks = $request->staff_wears_masks;
        $user->android_pay = $request->android_pay;
        $user->apple_pay = $request->apple_pay;
        $user->credit_card = $request->credit_card;
        $user->cryptocurrency = $request->cryptocurrency;
        $user->waitlist_reservations = $request->waitlist_reservations;
        $user->online_ordering = $request->online_ordering;
        $user->dogs_allowed = $request->dogs_allowed;
        $user->military = $request->military;
        $user->flower_delivery = $request->flower_delivery;

        $user->update(); // Update the data
        $request->session()->flash('success', 'Business profile has been updated successfully.');
        return redirect()->route('businessUserProfile', ['id' => General::encrypt($id)]);
    }

        function delete(Request $request, $id)
        {
            $uid = General::decrypt($id);
            $user = Users::find($uid);

            
            // dd($user);
            if($user)

            {

                if($user->delete())
                {
                    UserAuth::logout();
                    $request->session()->flash('success', 'User deleted successfully.');

                    return redirect()->route('homepage.index');

                }

                else

                {

                    $request->session()->flash('error', 'User category could not be delete.');

                    return redirect()->back();

                }

            }

            else

            {

                abort(404);

            }

        }



}
