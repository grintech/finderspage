<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\Admin\Notification;
use App\Libraries\General;
use App\Models\BlogCategories;
use App\Models\BlogPost;
use App\Models\Admin\Blogs;
use App\Models\BlogComments;
use App\Models\reviewModel;
use App\Models\Admin\SubPlan;
use Carbon\Carbon;
use App\Models\Admin\Follow;

class BlogpostController extends Controller
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
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =728",
            ],
            'title asc',
        );

        //        $categoryCount = count($categories);

        // echo "Total categories: " . $categoryCount;die();
        return view('frontend.dashboard_pages.add_blog', compact('categories'));
    }




    public function blogFormsave(Request $request)
    {
        // Check if user is logged in
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
    
        // dd($request->all());
        // if ($request->post_type == "Feature Post") {
        //         $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
        //         $response = $middleware->handle($request, function ($request) {
                   
        //         });

        //         if ($response) {
        //             return $response; // Return the response from the middleware
        //         }
        //     }
    

        $blog_post = new BlogPost();

        $categories = $request->categories ?? [];
        $subCategories = [];
    
        if ($request->subcategory == "5244") {
            $category = BlogCategories::where("title", $request->sub_category_oth)->first();
            if ($category) {
                $subCategories = $category->id;
            }
        } else {
            $subCategories = $request->subcategory ?? [];
        }

        // dd($subCategories);
    
        // Save the blog post
        $blog_post = $blog_post->add_Blog_post($request); 

        $lastInsertedId = BlogPost::orderBy('id', 'desc')->value('id');
        $blog_post =  BlogPost::where('id' , $lastInsertedId)->first();
    
        if (!$blog_post) {
            $request->session()->flash('error', 'Post could not be created. Please try again.');
            return redirect()->back();
        } else {
            $user = UserAuth::getLoginUser();
            $lastInsertedId = $blog_post->id;
    
            // Handle category associations
            if (!empty($categories)) {
                Blogs::handleCategories($lastInsertedId, $categories);
            }
        
            // Handle subcategory associations
            if (!empty($subCategories)) {
                Blogs::handleSubCategories($lastInsertedId, $subCategories);
            }
            if ($request->post_type == "Feature Post") {
                        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0){
                            // dd($user->featured_post_count);
                            $new_post_count = (int) $user->featured_post_count - 1;
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            BlogPost::where('id', $lastInsertedId)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 728,
                                'type' => 'Blog_post',
                                'rel_id' => $lastInsertedId->id,
                                'message' => "A featured listing \"{$request->title}\" is created by {$user->username}.",
                                'url' => route('blogPostSingle', ['slug' => $blog_post->slug]),
                                ];
                            Notification::create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{
                        // $notice = [
                        //     'from_id' => UserAuth::getLoginId(),
                        //     'to_id' => 7,
                        //     'rel_id' => $lastInsertedId,
                        //     'type' => 'Blog_post',
                        //     'message' => 'A new featured blog ' . $request->title . ' is created by ' . $user->username . '.',
                        // ];
                        // Notification::create($notice);
                        return redirect()->route('paypal.featured_post.blogs', ['post_id' => General::encrypt($lastInsertedId)]);
                        }
            } elseif ($request->post_type == "Bump Post") {
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 728,
                    'rel_id' => $lastInsertedId,
                    'type' => 'Blog_post',
                    'message' => "A new bump post \"{$request->title}\" is created by {$user->username}.",
                    'url' => route('blogPostSingle', ['slug' => $blog_post->slug]),
                ];
                Notification::create($notice);
                return redirect()->route('stripe.createstripe.blog', ['post_id' => General::encrypt($lastInsertedId)]);
            } else {
                BlogPost::where('id', $lastInsertedId)->update(['draft' =>1]);
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 728,
                    'rel_id' => $lastInsertedId,
                    'type' => 'Blog_post',
                    'message' => "A new post \"{$request->title}\" is created by {$user->username}.",
                    'url' => route('blogPostSingle', ['slug' => $blog_post->slug]),
                ];
                Notification::create($notice);

                $codes = [
                    '{name}' => $user->first_name,
                    '{title}' => $blog_post->title,
                    '{posted_date}' => $blog_post->created_at,
                    '{post_url}' => route('blogPostSingle', ['slug' => $blog_post->slug]),
                    '{post_description}' =>  $user->description,

                ];

                General::sendTemplateEmail(
                    $user->email,
                    'feature-post',
                    $codes
                );

                // General::sendTemplateEmail(
                //     $followerDetails->email,
                //     'post-notification-member',
                //     $codes
                // );
            }

            $request->session()->flash('success', 'Thanks for your blog. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            return redirect()->route('blog.list');
        }
    }



    public function blogList(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog_post =  BlogPost::where("user_id", UserAuth::getLoginId())->get();
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =728",
                "blog_categories.status=0",
            ],
            'title asc',
        );

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.blogList', compact('categories', 'blog_post', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }

    public function blogedit($slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog_post =  BlogPost::where('slug' , $slug)->first();
        // dd($blog_post);
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =728",
                "blog_categories.status=0",
            ],
            'title asc',
        );
        return view('frontend.dashboard_pages.edit_blog', compact('categories', 'blog_post'));
    }

    public function blogupdate(Request $request, $slug)
    {
        
        
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        $blog_post =  BlogPost::where('slug' , $slug)->first();

        // if ($blog_post->featured_post == "on") {
        //         $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
        //         $response = $middleware->handle($request, function ($request) {
                   
        //         });

        //         if ($response) {
        //             return $response; // Return the response from the middleware
        //         }
        //     }
        
        // dd($request->all());
        $id = $blog_post->id;
        // dd($blog_post);
        $blog_post_1 = $blog_post->update_Blog_post($request);

        if (!empty($blog_post_1)) {
            $request->session()->flash('error', 'Blog could not be updated. Please try again.');
            return redirect()->back();
        } else {

           
            $user = UserAuth::getLoginUser();
            if ($blog_post->featured_post == "on") {

                if(!empty($user->featured_post_count ) && $user->featured_post_count > 0){
                    // dd($user->featured_post_count);
                    $new_post_count = (int) $user->featured_post_count - 1;
                    Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                    BlogPost::where('id', $id)->update(['draft'=> 1,'featured_post' => 'on']);
                    $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => 7,
                        'cate_id' => 728,
                        'type' => 'Blog_post',
                        'message' => "A featured listing \"{$request->title}\" is updated by {$user->username}.",
                        'url' => route('blogPostSingle', ['slug' => $slug]),
                        ];
                    Notification::create($notice); 
                   
                    $request->session()->flash('success', 'Blog updated successfully.');
                    return redirect()->route('blog.list');
                }else{
                    if ($blog_post->featured_post == "on") {

                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 728,
                            'type' => 'Blog_post',
                            'message' => "A featured listing \"{$request->title}\" is updated by {$user->username}.",
                            'url' => route('blogPostSingle', ['slug' => $slug]),
                        ];
                        Notification::create($notice);

                        $request->session()->flash('success', 'Blog updated successfully.');
                        return redirect()->route('blog.list');
                    } else {
                        return redirect()->route('paypal.featured_post.blogs', ['post_id' => General::encrypt($id)]);
                    }
                }
            } elseif ($blog_post->bumpPost == 1) {
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 728,
                    'type' => 'Blog_post',
                    'message' => "A bump post \"{$request->title}\" is updated by {$user->username}.",
                    'url' => route('blogPostSingle', ['slug' => $slug]),
                ];
                Notification::create($notice);
                return redirect()->route('stripe.createstripe.blog', ['post_id' => General::encrypt($id)]);
            } else {
                BlogPost::where('id', $id)->update(['draft' =>1]);
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 728,
                    'type' => 'Blog_post',
                    'message' => "A post \"{$request->title}\" is updated by {$user->username}.",
                    'url' => route('blogPostSingle', ['slug' => $slug]),
                ];
                Notification::create($notice);

                $codes = [
                    '{name}' => $user->first_name,
                    '{post_url}' => route('blogPostSingle', ['slug' => $slug]),
                    '{post_description}' =>  $blog_post->title,
                ];

                General::sendTemplateEmail(
                    $user->email,
                    'feature-post',
                    $codes
                );
            }
            if ($blog_post->status == 1) {
                $request->session()->flash('success', 'Blog updated successfully.');
                return redirect()->route('blog.list');
            } else {
                $request->session()->flash('success', 'Blog updated successfully.');
                return redirect()->route('blog.list');
            }
        }
    }

    public function blogdelete($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog_post =  BlogPost::find($id);
        $blog_post->delete();
        if (!empty($blog_post)) {
            return redirect()->back();
        } else {
            return redirect()->route('blog.list');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pin_to_profile(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd($request->blog_id);
        $blog_post =  BlogPost::where('id', $request->blog_id)->update([
            'pin_to_profile' => '1',
            // Add other columns you want to update here.
        ]);
        if ($blog_post) {
            return response()->json(['success', 'Pin to profile successfully..!']);
        } else {
            return response()->json(['error', 'Somthing went wrong..!']);
        }
    }



    public function Blog_data_request(Request $request)
    {
        // dd($request->all());
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');
        $BlogsView = collect();
    
        if ($categoryId == 728) {
            $BlogsView = BlogPost::where('status', 1)
                ->where('posted_by', 'admin')
                ->orderBy('created_at', 'desc')
                ->get();
        } 
    
        if (!empty($service_types) && !empty($location_search)) {
            $BlogsView = BlogPost::where('status', 1)
                ->where('posted_by', 'admin')
                ->where('subcategory', $service_types)
                ->where('location', 'like', '%' . $location_search . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        } 
    
        if (!empty($service_types) && empty($location_search)) {
            $BlogsView = BlogPost::where('status', 1)
                ->where('posted_by', 'admin')
                ->where('subcategory', $service_types)
                ->orderBy('created_at', 'desc')
                ->get();
        } 
    
        if (empty($service_types) && !empty($location_search)) {
            $BlogsView = BlogPost::where('status', 1)
                ->where('posted_by', 'admin')
                ->where('location', 'like', '%' . $location_search . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $filterData = '';
            foreach ($BlogsView as $post) {
                $img = explode(',', $post->image);
                $imageSrc = isset($img[0]) && !empty($img[0]) ? asset('images_blog_img/' . $img[0]) : asset('images_blog_img/1688636936.jpg');

                $filterData .= '<div class="col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="feature-box">
                        <a href="' . route('blogPostSingle', $post->slug) . '">
                            <div class="img-area">
                                <img src="' . $imageSrc . '" alt="' . $post->title . '" class="d-block w-100">
                            </div>
                            <div class="job-post-content">
                                <h4>' . $post->title . '</h4>
                                <div class="main-days-frame">
                                    <span class="days-box">';
                                        $givenTime = strtotime($post->created_at);
                                        $currentTimestamp = time();
                                        $timeDifference = $currentTimestamp - $givenTime;

                                        $days = floor($timeDifference / (60 * 60 * 24));
                                        $timeAgo = ($days > 0) ? (($days == 1) ? "$days day ago." : "$days days ago.") : "Posted today.";

                                        $filterData .= $timeAgo . '
                                    </span>
                                </div>
                                <a href="' . route('blogPostSingle', $post->slug) . '" class="btn blog-read-button px-2">Read More</a>
                            </div>
                        </a>
                    </div>
                </div>';
            }

        if (empty($filterData)) {
            $noDataHtml = '<div class="col-12" style="text-align: center;">
                    <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">We couldn\'t find any data, Please adjust your filter settings.</h3>
                    <a href="' . url('/') . '">
                        <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
                    </a>
                </div>';
            return response()->json(['html' => $noDataHtml]);
        }

        return response()->json(['html' => $filterData]);
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
    public function destroy($id)
    {
        //
    }
    public function userNotification()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // $notify = Notification::join('users', 'notifications.from_id', '=', 'users.id')->where('to_id', UserAuth::getLoginId())->orderBy('id', 'DESC')->get(['notifications.*', 'users.first_name']);

        // $get_admin_notification_for_user = Notification::join('admins', 'notifications.from_id', '=', 'admins.id')->where('to_id', UserAuth::getLoginId())->orderBy('id', 'DESC')->get(['notifications.*', 'admins.first_name']);

        $notification = new Notification();
        $getNotification_all = $notification->getAllNoticeForUser(UserAuth::getLoginId());
        $get_admin_Notification_all = $notification->getadminnotificationforuser(UserAuth::getLoginId());

        $m_Notifications = $getNotification_all->merge($get_admin_Notification_all);
        $sortedNotificationsAll = $m_Notifications->sortBy('created');

        // dd($sortedNotificationsAll);
        $get_connected_user = Follow::where('follower_id', UserAuth::getLoginId())->whereNull('deleted_at')->get(); 
       
        return view("frontend.dashboard_pages.notification", compact('sortedNotificationsAll','get_connected_user'));
    }
    


    public function create_slug_for_blog(){

        $blog_post =  BlogPost::where('status', 1)->get();

        foreach ($blog_post as $blog) {
            $title = $blog->title;

            // Convert title to lowercase
            $slug = strtolower($title);

            // Replace spaces with hyphens or underscores
            $slug = str_replace(' ', '-', $slug);

            // Remove special characters or non-alphanumeric characters
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

         
            $update = BlogPost::where('id', $blog->id)->update(['slug' => $slug]);
        }

        return response()->json(['success' =>'Blog updated successfully.']);
    }
    
    
    public function new_blog_layouts(){ 
        
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id =728",
            ],
            'title asc',
        );
        return view('frontend.dashboard_pages.BlogPost.Blogform',compact('categories'));
    }
}
