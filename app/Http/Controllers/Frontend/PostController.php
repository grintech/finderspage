<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libraries\FileSystem;
use App\Libraries\General;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\Admin\Notification;
use App\Models\BlogCategories;
use App\Models\Blogs;
use App\Models\Business;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\Admin\Follow;
use DB;
use Illuminate\Support\Str;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PostView;
use App\Models\Setting;
use App\Models\BlogPost;
use App\Models\Entertainment;
use App\Models\Admin\SubPlan;
use App\Models\Video;
use App\Models\JobApply;
use App\Models\ServiceHour;
use Carbon\Carbon;
use App\Models\Latest_post;

class PostController extends Controller
{
    public function create(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        if ($request->isMethod('post')) {
            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ],
                [
                    'post_type.required' => 'field is required',
                ]
            );
            if (!$validator->fails()) {
                
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    //dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    $subCategories = $categories->id;
                }


                if ($categories && $subCategories) {
                }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
                unset($data['sub_category_oth']);



                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['choices'] =  $data['choices'];
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::create($data);

                if ($blog) {

                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();
                    // dd($data['post_type']);
                    if ($request->post_type == "Feature Post") {
                        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_coun == 'Unlimited'){
                            // dd($user->featured_post_count);
                            $new_post_count = (int) $user->featured_post_count - 1;
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);

                            // $notice = [
                            //     'from_id' => UserAuth::getLoginId(),
                            //     'to_id' => 7,
                            //     'cate_id' => 2,
                            //     'type' => 'post',
                            //     'rel_id' => $blog->id,
                            //     'message' => "A featured job listing \"{$data['title']}\" is created by {$user->username}.",
                            //     'url' => route('jobpost', $blog->slug),
                            //     ];
                            // Notification::create($notice); 

                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 2,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 

                            $codes = [
                                '{name}' => $user->username,
                                '{post_url}' => route('jobpost',$blog->slug),
                                '{post_description}' =>  $user->description,
    
                            ];
    
                            General::sendTemplateEmail(
                                $user->email,
                                'feature-post',
                                $codes
                            );
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{
                            return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }

                        
                    }elseif ($request->post_type == "Normal Post") {
                        if(!empty($user->paid_post_count ) && $user->paid_post_count > 0 || $user->paid_post_count == 'Unlimited'){
                            if($user->paid_post_count == 'Unlimited'){
                                $new_post_count = "Unlimited";
                                Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Featured Post','featured_post' =>'on']);
                            }else{
                                $new_post_count = (int) $user->paid_post_count - 1;
                                Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Paid Post']);
                            }
                        
                        
                         $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 2,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                            ];
                        Notification::create_post($notice); 

                         $codes = [
                            '{name}' => $user->username,
                            '{post_url}' => route('jobpost',$blog->slug),
                            '{post_description}' =>  $user->description,

                        ];

                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                         $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
 
                         return redirect()->route('job_post_list');
                        }else{
                            return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'jobs']);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                        }
                    } 
                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                    return redirect()->route('job_post_list');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 2",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        $countries = Country::where('id', '233')->get();

        return view(
            "frontend.dashboard_pages.jobs",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
    }

    public function job_edit(Request $request, $slug)
    {
     

        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {

            $data = $request->toArray();
            // echo"<pre>"; print_r($request->all());  die;


            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    //dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    $subCategories = $categories->id;
                }


                if ($categories && $subCategories) {
                }

                unset($data['state_name_']);
                //unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
                unset($data['sub_category_oth']);

                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = UserAuth::getLoginId();

                $blog = Blogs::jobEdit($slug, $data);

                if ($blog) {
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        
                        // Decode the existing image JSON string into an array
                        $existingImages = json_decode($blog->image1, true) ?: [];
                        
                        // Ensure $existingImages is an array
                        if (!is_array($existingImages)) {
                            $existingImages = [];
                        }
                    
                        foreach ($images as $image) {
                            // Generate a unique name for the new image
                            $name = time() . '_' . $image->getClientOriginalName();
                            
                            // Define the destination path
                            $destinationPath = public_path('/images_blog_img');
                            
                            // Move the uploaded image to the destination path
                            $image->move($destinationPath, $name);
                            
                            // Add the new image name to the array
                            $existingImages[] = $name;
                        }
                    
                        // Encode the updated image array back into a JSON string
                        $blog->image1 = json_encode($existingImages);
                    }
                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    $user = UserAuth::getLoginUser();
                    // dd($blog->featured_post);

                    // if ($request->post_type == "Feature Post") {
                    //     if ($blog->featured_post == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 2,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::feature_update($notice);
                    //         return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } elseif ($request->post_type == "Bump Post") {
                    //     if ($blog->bumpPost == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 2,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::bump_update($notice);
                    //         return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // }elseif ($request->post_type == "Normal Post") {
                    //     // dd($blog->post_type);
                    //     if ($blog->post_type == 'Bump Post' || $blog->post_type == 'Feature Post') {
                    //         $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 2,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    //     return redirect()->route('paypal.paid', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    //     Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 2,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    // }

                    if ($blog->featured_post == "on") {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 2,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::feature_update($notice);
                    } elseif ($blog->bumpPost == 1 && $blog->featured_post != "on"){
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 2,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::bump_update($notice);
                    } else {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 2,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::update_post($notice);
                    }

                    // $request->session()->flash('success', 'Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('job_post_list');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 2",

            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();
        $blog = Blogs::where('slug',$slug)->first();
        return view(
            "frontend.dashboard_pages.edit_job",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' =>  $blog,
            ]
        );
    }
    
    
    public function new_blog_layouts(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
  

        if ($request->isMethod('post')) {

            $data = $request->toArray();
        // echo"<pre>"; print_r($data);  die;
            $validator = Validator::make(
                $request->toArray(),
                [
                    'subcategory' => 'required', 
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['subcategory'] != 'Other') {

                    if (isset($data['subcategory']) && $data['subcategory']) {
                        $subCategories = $data['subcategory'];
                    }
                } else {
                    //dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    $subCategories = $categories->id;
                }
                unset($data['sub_category_oth']);

                if ($categories && $subCategories) {
                }

                
                $data['user_id'] = UserAuth::getLoginId();
                $blog = Blogs::blog_create($data);

                if ($blog) {
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }

                    $user = UserAuth::getLoginUser();
                            if ($request->post_type == "Normal Post") {
                                    if($user->free_listing == 1){
                                       $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'cate_id' => 4,
                                        'type' => 'post',
                                        'rel_id' => $blog->id,
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                        ];
                                    Notification::create_post($notice); 

                                    Users::where('id', $user->id)->update(['free_listing' => 0]);
                                    Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Paid Post']);
                                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                                    return redirect()->route('realEstate_post_list');

                                    } elseif(!empty($user->paid_post_count) && $user->paid_post_count > 0){
                                        $notice = [
                                         'from_id' => UserAuth::getLoginId(),
                                         'to_id' => 7,
                                         'cate_id' => 4,
                                         'type' => 'post',
                                         'rel_id' => $blog->id,
                                         'slug' => $blog->slug,
                                         'title' => $data['title'],
                                         'username' => $user->username,
                                         ];
                                     Notification::feature_create($notice); 
             
                                     $new_post_count = (int) $user->paid_post_count - 1;
                                     Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                     $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
             
                                     return redirect()->route('shopping_post_list');

                                    } else{
                                        $notice = [
                                           'from_id' => UserAuth::getLoginId(),
                                           'to_id' => 7,
                                           'type' => 'post',
                                           'cate_id' => 4,
                                           'rel_id' => $blog->id,
                                           'slug' => $blog->slug,
                                           'title' => $data['title'],
                                           'username' => $user->username,
                                       ];
                                           Notification::bump_create($notice);
                                           return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'realestate']);    
                                        
                                }
                                
                                }elseif($user->paid_post_count == 'Unlimited'){
                                    Blogs::where('id', $blog->id)->update(['draft'=> 1 , 'featured_post' =>"on"]);
                                    $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'cate_id' => 4,
                                        'type' => 'post',
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                    ];
                                    Notification::feature_create($notice);
            
                                    $codes = [
                                        '{name}' => $user->username,
                                        '{post_url}' => route('real_esate_post', ['slug' => $blog->slug]),
                                        '{post_description}' =>  $user->description,
            
                                    ];
            
                                    General::sendTemplateEmail(
                                        $user->email,
                                        'feature-post',
                                        $codes
                                    );
                                }else{
                                    Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                                    $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'cate_id' => 4,
                                        'type' => 'post',
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                    ];
                                    Notification::create_post($notice);
            
                                    $codes = [
                                        '{name}' => $user->username,
                                        '{post_url}' => route('real_esate_post', ['slug' => $blog->slug]),
                                        '{post_description}' =>  $user->description,
            
                                    ];
            
                                    General::sendTemplateEmail(
                                        $user->email,
                                        'feature-post',
                                        $codes
                                    );
                                }
                                        
                        

                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('realEstate_post_list');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
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

    public function realestate(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {

            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');

            // echo"<pre>"; print_r($request->all());  die;
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ],
                [
                    'post_type.required' => 'field is required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    //dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    $subCategories = $categories->id;
                }
                unset($data['sub_category_oth']);

                if ($categories && $subCategories) {
                }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);

                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                $blog = Blogs::realEstate_create($data);

                // dd($data, $blog);

                if ($blog) {
                    // if ($request->hasFile('image')) {
                    //     $image = $request->file('image');
                    //     $name = time() . '.' . $image->getClientOriginalExtension();
                    //     $destinationPath = public_path('/images_blog_img');
                    //     $image->move($destinationPath, $name);
                    //     $blog->image1 = $name;
                    // }
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }
                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                    if ($request->post_type == "Feature Post") {
                        if(!empty($user->featured_post_count) && $user->featured_post_count > 0){
                            $new_post_count = (int) $user->featured_post_count - 1;
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 4,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{
                        // $notice = [
                        //     'from_id' => UserAuth::getLoginId(),
                        //     'to_id' => 7,
                        //     'type' => 'post',
                        //     'message' => 'A featured listing \"{$data['title']}\" is created by ' . $user->username,
                        // ];
                        // Notification::create($notice);
                        return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }
                    } elseif ($request->post_type == "Bump Post") {

                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 4,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::bump_create($notice);
                        return redirect()->route('paypal.featured_post', ['post_id' => General::encrypt($blog->id)]);
                    } elseif ($request->post_type == "Normal Post") {
                            if($request->sub_category =='528'){
                                if($user->free_listing == 1){
                                       $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'cate_id' => 4,
                                        'type' => 'post',
                                        'rel_id' => $blog->id,
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                        ];
                                    Notification::create_post($notice); 

                                    Users::where('id', $user->id)->update(['free_listing' => 0]);
                                    Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Paid Post']);
                                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                                    return redirect()->route('realEstate_post_list');

                                    } elseif(!empty($user->paid_post_count) && $user->paid_post_count > 0){
                                        $notice = [
                                         'from_id' => UserAuth::getLoginId(),
                                         'to_id' => 7,
                                         'cate_id' => 6,
                                         'type' => 'post',
                                         'rel_id' => $blog->id,
                                         'slug' => $blog->slug,
                                         'title' => $data['title'],
                                         'username' => $user->username,
                                         ];
                                     Notification::create_post($notice); 
             
                                     $new_post_count = (int) $user->paid_post_count - 1;
                                     Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                     $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
             
                                     return redirect()->route('shopping_post_list');

                                    } else{
                                        $notice = [
                                           'from_id' => UserAuth::getLoginId(),
                                           'to_id' => 7,
                                           'type' => 'post',
                                           'cate_id' => 4,
                                           'rel_id' => $blog->id,
                                           'slug' => $blog->slug,
                                           'title' => $data['title'],
                                           'username' => $user->username,
                                       ];
                                           Notification::create_post($notice);
                                           return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'realestate']);
                                       } 
                                        
                            }elseif($user->paid_post_count == 'Unlimited'){
                                Blogs::where('id', $blog->id)->update(['draft'=> 1 , 'featured_post' =>"on"]);
                                $notice = [
                                    'from_id' => UserAuth::getLoginId(),
                                    'to_id' => 7,
                                    'cate_id' => 4,
                                    'type' => 'post',
                                    'rel_id' => $blog->id,
                                    'slug' => $blog->slug,
                                    'title' => $data['title'],
                                    'username' => $user->username,
                                ];
                                Notification::feature_create($notice);
        
                                $codes = [
                                    '{name}' => $user->username,
                                    '{post_url}' => route('real_esate_post', ['slug' => $blog->slug]),
                                    '{post_description}' =>  $user->description,
        
                                ];
        
                                General::sendTemplateEmail(
                                    $user->email,
                                    'feature-post',
                                    $codes
                                );
                            }else{
                                Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                                $notice = [
                                    'from_id' => UserAuth::getLoginId(),
                                    'to_id' => 7,
                                    'cate_id' => 4,
                                    'type' => 'post',
                                    'rel_id' => $blog->id,
                                    'slug' => $blog->slug,
                                    'title' => $data['title'],
                                    'username' => $user->username,
                                ];
                                // dd($notice);
                                Notification::create_post($notice);
        
                                // $codes = [
                                //     '{name}' => $user->username,
                                //     '{post_url}' => route('real_esate_post', ['slug' => $blog->slug]),
                                //     '{post_description}' =>  $user->description,
        
                                // ];
        
                                // General::sendTemplateEmail(
                                //     $user->email,
                                //     'feature-post',
                                //     $codes
                                // );
                            }
                                    
                    }

                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('realEstate_post_list');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 4"
            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();



        return view(
            "frontend.dashboard_pages.realestate",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
    }



    public function edit_realestate(Request $request, $slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {

            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    //dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    $subCategories = $categories->id;
                }
                unset($data['sub_category_oth']);

                if ($categories && $subCategories) {
                }

                $feature = $request->feature;
                unset($data['sub_category']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::realEstate_edit($slug, $data);

                if ($blog) {
                    // if ($request->hasFile('image')) {
                    //     $image = $request->file('image');
                    //     $name = time() . '.' . $image->getClientOriginalExtension();
                    //     $destinationPath = public_path('/images_blog_img');
                    //     $image->move($destinationPath, $name);
                    //     $blog->image1 = $name;
                    // }
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        
                        // Decode the existing image JSON string into an array
                        $existingImages = json_decode($blog->image1, true) ?: [];
                        
                        // Ensure $existingImages is an array
                        if (!is_array($existingImages)) {
                            $existingImages = [];
                        }
                    
                        foreach ($images as $image) {
                            // Generate a unique name for the new image
                            $name = time() . '_' . $image->getClientOriginalName();
                            
                            // Define the destination path
                            $destinationPath = public_path('/images_blog_img');
                            
                            // Move the uploaded image to the destination path
                            $image->move($destinationPath, $name);
                            
                            // Add the new image name to the array
                            $existingImages[] = $name;
                        }
                    
                        // Encode the updated image array back into a JSON string
                        $blog->image1 = json_encode($existingImages);
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                        // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();



                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                    // if ($blog->post_type == "Feature Post") {
                    //     if ($blog->featured_post == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 4,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::feature_update($notice);
                    //         return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } elseif ($blog->post_type == "Bump Post") {
                    //     if ($blog->bumpPost == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 4,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::bump_update($notice);
                    //         return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } elseif ($blog->post_type == "Normal Post") {
                    //     if ($blog->bumpPost != 'Normal Post') {
                    //             if($request->sub_category =='528'){
                    //                 $notice = [
                    //                     'from_id' => UserAuth::getLoginId(),
                    //                     'to_id' => 7,
                    //                     'cate_id' => 4,
                    //                     'type' => 'post',
                    //                     'rel_id' => $blog->id,
                    //                     'slug' => $blog->slug,
                    //                     'title' => $data['title'],
                    //                     'username' => $user->username,
                    //                 ];
                    //                 Notification::update_post($notice);
                    //                 return redirect()->route('stripe.normal.realestate', ['post_id' => General::encrypt($blog->id)]);

                    //                 // $notice = [
                    //                 //     'from_id' => UserAuth::getLoginId(),
                    //                 //     'to_id' => 7,
                    //                 //     'type' => 'post',
                    //                 //     'message' => 'A listing \"{$data['title']}\" is updated by ' . $user->username,
                    //                 // ];
                    //                 // Notification::create($notice);
                    //             }
                    //     }
                    //     Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                    //     // dd($blog);
                    // } else {
                         
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 4,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    // }
                    
                    if ($blog->featured_post == "on") {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 4,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::feature_update($notice);
                    } elseif ($blog->bumpPost == 1 && $blog->featured_post != "on"){
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 4,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::bump_update($notice);
                    } else {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 4,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::update_post($notice);
                    }
                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('realEstate_post_list');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 4"
            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();
        $blog = Blogs::where('slug',$slug)->first();
        //echo"<pre>"; print_r($countries); echo "</pre>";

        return view(
            "frontend.dashboard_pages.edit_realestate",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' => $blog,
            ]
        );
        // return view('frontend.dashboard_pages.realestate');
    }


    public function our_community(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            // echo"<pre>"; print_r($request->all());die;
            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();




            // echo"<pre>"; print_r($request->all());  die;
            // $values = array('id' => 1,'name' => 'Dayle');
            // DB::table('users')->insert($values);

            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ],
                [
                    'post_type.required' => 'field is required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    $cate = BlogCategories::where("title", $data['sub_category_oth'])->first();
                    // dd($cate);
                    $subCategories = $cate->id;
                }
                unset($data['sub_category_oth']);



                unset($data['categories']);

                $feature = $request->feature;

                unset($data['feature']);

                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::community_create($data);

                if ($blog) {
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }

                    if ($request->hasFile('document')) {
                        $document = $request->file('document');
                        $documentNames = [];

                        foreach ($document as $doc) {
                            $name = time() . '_' . $doc->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_doc');
                            $doc->move($destinationPath, $name);
                            $documentNames[] = $name;
                        }

                        $blog->document = $documentNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                        // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();

                    // $destination = str_replace('/tmp/', '/blogs/', $data['image']);
                    // if ($data['image'] && FileSystem::moveFile($data['image'], $destination)) {
                    //     $originalName = FileSystem::getFileNameFromPath($destination);
                    //     FileSystem::resizeImage($destination, $originalName, '800*800');
                    //     FileSystem::resizeImage($destination, 'M-' . $originalName, '375*375');
                    //     FileSystem::resizeImage($destination, 'S-' . $originalName, '100*100');
                    //     $blog->image = $destination;
                    //     $blog->save();
                    // }

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }



                    $user = UserAuth::getLoginUser();

                    if ($request->post_type == "Feature Post") {
                        if(!empty($user->featured_post_count) && $user->featured_post_count > 0){
                            $new_post_count = (int) $user->featured_post_count - 1;
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{
                        if ($blog->featured_post == null) {
                            // $notice = [
                            //     'from_id' => UserAuth::getLoginId(),
                            //     'to_id' => 7,
                            //     'type' => 'post',
                            //     'message' => 'A featured listing \"{$data['title']}\" is created by ' . $user->username,
                            // ];
                            // Notification::create($notice);
                            return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }
                    }
                    } elseif ($request->post_type == "Bump Post") {
                        if ($blog->bumpPost == null) {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::bump_create($notice);
                            return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                        }
                         
                    } else {

                        if($user->featured_post_count=="Unlimited"){
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }
                        Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 5,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::create_post($notice);
                        $codes = [
                            '{name}' => $user->username,
                            '{post_url}' => route('community_single_post',$blog->slug),
                            '{post_description}' =>  $user->description,

                        ];

                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                       
                    }
                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('community_post_list');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 5",
            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();

        return view(
            "frontend.dashboard_pages.our_community",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
        // return view('frontend.dashboard_pages.our_community');
    }


    public function our_community_edit(Request $request, $slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            // echo"<pre>"; print_r($request->all());die;
            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();




            // echo"<pre>"; print_r($request->all());  die;
            // $values = array('id' => 1,'name' => 'Dayle');
            // DB::table('users')->insert($values);

            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }


                unset($data['categories']);

                $feature = $request->feature;

                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::community_Edit($data, $slug);

                if ($blog) {
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        
                        // Decode the existing image JSON string into an array
                        $existingImages = json_decode($blog->image1, true) ?: [];
                        
                        // Ensure $existingImages is an array
                        if (!is_array($existingImages)) {
                            $existingImages = [];
                        }
                    
                        foreach ($images as $image) {
                            // Generate a unique name for the new image
                            $name = time() . '_' . $image->getClientOriginalName();
                            
                            // Define the destination path
                            $destinationPath = public_path('/images_blog_img');
                            
                            // Move the uploaded image to the destination path
                            $image->move($destinationPath, $name);
                            
                            // Add the new image name to the array
                            $existingImages[] = $name;
                        }
                    
                        // Encode the updated image array back into a JSON string
                        $blog->image1 = json_encode($existingImages);
                    }

                    if ($request->hasFile('document')) {
                        $document = $request->file('document');
                        $documentNames = [];

                        foreach ($document as $doc) {
                            $name = time() . '_' . $doc->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_doc');
                            $doc->move($destinationPath, $name);
                            $documentNames[] = $name;
                        }

                        $blog->document = $documentNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                        // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();

                    // $destination = str_replace('/tmp/', '/blogs/', $data['image']);
                    // if ($data['image'] && FileSystem::moveFile($data['image'], $destination)) {
                    //     $originalName = FileSystem::getFileNameFromPath($destination);
                    //     FileSystem::resizeImage($destination, $originalName, '800*800');
                    //     FileSystem::resizeImage($destination, 'M-' . $originalName, '375*375');
                    //     FileSystem::resizeImage($destination, 'S-' . $originalName, '100*100');
                    //     $blog->image = $destination;
                    //     $blog->save();
                    // }

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }



                    $user = UserAuth::getLoginUser();

                    // if ($request->post_type == "Feature Post") {
                    //     if ($blog->featured_post == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 5,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::feature_update($notice);
                    //         return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } elseif ($request->post_type == "Bump Post") {
                    //     if ($blog->bumpPost == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 5,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::bump_update($notice);
                    //         return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } else {
                    //     Blogs::where('id', $blog->id)->update(['draft'=> 1]); 
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 5,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    // }

                    if ($blog->featured_post == "on") {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::feature_update($notice);
                    } elseif ($blog->bumpPost == 1 && $blog->featured_post != "on"){
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::bump_update($notice);
                    } else {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 5,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::update_post($notice);
                    }
                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('community_post_list');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 5",
            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();
        $blog = Blogs::where('slug',$slug)->first();
        return view(
            "frontend.dashboard_pages.edit_community",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' => $blog,
            ]
        );
        // return view('frontend.dashboard_pages.our_community');
    }


    public function shopping(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            // dd($request->all());
            $data = $request->toArray();
            // dd($data);
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();

            // echo"<pre>"; print_r($data);  die;
            // $values = array('id' => 1,'name' => 'Dayle');
            // DB::table('users')->insert($values);

            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            if($data['sub_category']==1318){
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'categories' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                    'image' => 'required',


                ],
                [
                    'post_type.required' => 'field is required',
                ]
            );
        }else{
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'categories' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',
                    
                ]
            );
        }
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }


                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    // dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();

                    $subCategories = $categories->id;
                }

                if ($categories && $subCategories) {
                }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
                unset($data['sub_category_oth']);
                $feature = $request->feature;
                // unset($data['sub_category']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::shopping_create($data, $subCategories);

                if ($blog) {
                    //     if ($request->hasFile('image')) {
                    //     $image = $request->file('image');
                    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
                    //     $image->move(public_path('images_blog_img'), $imageName);
                    //     $blog->image1 = $imageName;
                    //     // You can store the image path in the database or perform any other necessary actions here.
                    // }
                    $blog->sub_category = $subCategories;

                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }


                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                        // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();



                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                    if ($request->post_type == "Feature Post") {

                        if(!empty($user->featured_post_count) && $user->featured_post_count > 0){
                            $new_post_count = (int) $user->featured_post_count - 1;
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'type' => 'post',
                                'cate_id' => 6,
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{
                        // $notice = [
                        //     'from_id' => UserAuth::getLoginId(),
                        //     'to_id' => 7,
                        //     'type' => 'post',
                        //     'message' => 'A featured listing \"{$data['title']}\" is created by ' . $user->username,
                        // ];
                        // Notification::create($notice);
                        return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }
                    } elseif ($request->post_type == "Bump Post") {

                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'type' => 'post',
                            'cate_id' => 6,
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::bump_create($notice);
                        return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    }elseif ($request->post_type == "Normal Post") {

                        if($request->sub_category =='1280' || $request->sub_category =='1282' || $request->sub_category =='1283'){
                         if($user->free_listing==1){
                                       $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'type' => 'post',
                                        'cate_id' => 6,
                                        'rel_id' => $blog->id,
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                        ];
                                    Notification::create_post($notice); 

                                    Users::where('id', $user->id)->update(['free_listing' => 0]);
                                    Blogs::where('id', $blog->id)->update(['draft'=> 1, 'post_type' => 'Paid Post']);
                                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                                    return redirect()->route('shopping_post_list');
                                    }elseif(!empty($user->paid_post_count) && $user->paid_post_count > 0 || $user->paid_post_count =="Unlimited"){
                                        $notice = [
                                         'from_id' => UserAuth::getLoginId(),
                                         'to_id' => 7,
                                         'cate_id' => 6,
                                         'type' => 'post',
                                         'rel_id' => $blog->id,
                                         'slug' => $blog->slug,
                                         'title' => $data['title'],
                                         'username' => $user->username,
                                         ];
                                     Notification::create_post($notice); 
                                    if($user->paid_post_count =="Unlimited"){
                                        $new_post_count = (int) $user->paid_post_count - 1;
                                        Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                        Blogs::where('id', $blog->id)->update(['draft'=> 1, 'post_type' => 'Featured Post' ,'featured_post' => 'on']);
                                    }else{
                                        $new_post_count = (int) $user->paid_post_count - 1;
                                        Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                                        Blogs::where('id', $blog->id)->update(['draft'=> 1, 'post_type' => 'Normal Post']);
                                    }
                                     
                                     $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
             
                                     return redirect()->route('shopping_post_list');
                                    }else{
                                     $notice = [
                                        'from_id' => UserAuth::getLoginId(),
                                        'to_id' => 7,
                                        'type' => 'post',
                                        'cate_id' => 6,
                                        'rel_id' => $blog->id,
                                        'slug' => $blog->slug,
                                        'title' => $data['title'],
                                        'username' => $user->username,
                                    ];
                                        Notification::create_post($notice);
                                        return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'shopping']);
                                    }
                        }else{
                            Blogs::where('id', $blog->id)->update(['draft'=> 1]); 
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'type' => 'post',
                                'cate_id' => 6,
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::create_post($notice); 
                            $codes = [
                                '{name}' => $user->username,
                                '{post_url}' => route('shopping_post_single',$blog->slug),
                                '{post_description}' =>  $user->description,
    
                            ];
    
                            General::sendTemplateEmail(
                                $user->email,
                                'feature-post',
                                $codes
                            );
                        }
                       
                    } 

                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('shopping_post_list');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $sub_blog_categories = BlogCategories::where('parent_id', '>', 0)->orderBy('title', 'asc')->get();
        foreach ($sub_blog_categories as $list => $listValue) {
            $parent_id = $listValue->parent_id;
            $singlelisting = BlogCategories::where('id', '=', $parent_id)->pluck('parent_id')->first();
            $listValue->main_parent_id = $singlelisting;
        }

        // echo "<pre>";
        // print_r($categories);
        // die('jkdfhskdf');

        $countries = Country::where('id', '236')->get();

        return view(
            "frontend.dashboard_pages.shopping",
            [
                'sub_blog_categories' =>  $sub_blog_categories,
                'countries' => $countries,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');
    }



    public function shopping_edit(Request $request, $slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            // dd($request->all());
            $data = $request->toArray();
            // dd($data);
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();

            
            // echo"<pre>"; print_r($request->all());  die;
            // $values = array('id' => 1,'name' => 'Dayle');
            // DB::table('users')->insert($values);

            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'categories' => 'required',
                    'sub_category' => 'required',

                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }

                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    // dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();

                    $subCategories = $categories->id;
                }

                if ($categories && $subCategories) {
                }


                $feature = $request->feature;
                $data['sub_category'];
                unset($data['feature']);
                unset($data['sub_category_oth']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data['sub_category']);
                $blog = Blogs::shopping_edit($slug, $data);

                if ($blog) {

                    
                    // $firstImage = $request->input('featured_image');
                    // $imageOrder = $request->input('image1');

                    // $blog->image1 = $firstImage;
                    // $blog->featured_image = $imageOrder;

                    // $blog->save();

                    $blog->sub_category = $subCategories;
                    // dd($request->image);
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        
                        // Decode the existing image JSON string into an array
                        $existingImages = json_decode($blog->image1, true) ?: [];
                        
                        // Ensure $existingImages is an array
                        if (!is_array($existingImages)) {
                            $existingImages = [];
                        }
                    
                        foreach ($images as $image) {
                            // Generate a unique name for the new image
                            $name = time() . '_' . $image->getClientOriginalName();
                            
                            // Define the destination path
                            $destinationPath = public_path('/images_blog_img');
                            
                            // Move the uploaded image to the destination path
                            $image->move($destinationPath, $name);
                            
                            // Add the new image name to the array
                            $existingImages[] = $name;
                        }
                    
                        // Encode the updated image array back into a JSON string
                        $blog->image1 = json_encode($existingImages);
                        $blog->save();
                    }


                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                        // You can store the image path in the database or perform any other necessary actions here.
                        $blog->save();
                    }
                    

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                //     if ($request->post_type == "Feature Post") {
                //         if ($blog->featured_post == null) {
                //             $notice = [
                //                 'from_id' => UserAuth::getLoginId(),
                //                 'to_id' => 7,
                //                 'type' => 'post',
                //                 'cate_id' => 6,
                //                 'rel_id' => $blog->id,
                //                 'slug' => $blog->slug,
                //                 'title' => $data['title'],
                //                 'username' => $user->username,
                //             ];
                //             Notification::feature_update($notice);
                //             return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                //         }
                //     } elseif ($request->post_type == "Bump Post") {
                //         if ($blog->bumpPost == null) {
                //             $notice = [
                //                 'from_id' => UserAuth::getLoginId(),
                //                 'to_id' => 7,
                //                 'type' => 'post',
                //                 'cate_id' => 6,
                //                 'rel_id' => $blog->id,
                //                 'slug' => $blog->slug,
                //                 'title' => $data['title'],
                //                 'username' => $user->username,
                //             ];
                //             Notification::bump_update($notice);
                //             return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                //         }
                //     }elseif ($request->post_type == "Normal Post") {
                //         if($blog->post_type!='Normal Post'){
                            
                //         if($request->sub_category =='1280' || $request->sub_category =='1282' || $request->sub_category =='1283'){

                //          $notice = [
                //             'from_id' => UserAuth::getLoginId(),
                //             'to_id' => 7,
                //             'type' => 'post',
                //             'cate_id' => 6,
                //             'rel_id' => $blog->id,
                //             'slug' => $blog->slug,
                //             'title' => $data['title'],
                //             'username' => $user->username,
                //         ];
                //         Notification::update_post($notice);
                //         return redirect()->route('stripe.normal.shopping', ['post_id' => General::encrypt($blog->id)]);
                //         }
                //     Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                //     }else {
                         
                //         $notice = [
                //             'from_id' => UserAuth::getLoginId(),
                //             'to_id' => 7,
                //             'type' => 'post',
                //             'cate_id' => 6,
                //             'rel_id' => $blog->id,
                //             'slug' => $blog->slug,
                //             'title' => $data['title'],
                //             'username' => $user->username,
                //         ];
                //         Notification::update_post($notice);
                //     }
                // }

                if ($blog->featured_post == "on") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 6,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::feature_update($notice);
                } elseif ($blog->bumpPost == 1 && $blog->featured_post != "on"){
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 6,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::bump_update($notice);
                } else {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 6,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::update_post($notice);
                }
                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('shopping_post_list');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        $sub_blog_categories = BlogCategories::where('parent_id', '>', 0)->orderBy('title', 'asc')->get();
        foreach ($sub_blog_categories as $list => $listValue) {
            $parent_id = $listValue->parent_id;
            $singlelisting = BlogCategories::where('id', '=', $parent_id)->pluck('parent_id')->first();
            $listValue->main_parent_id = $singlelisting;
        }
        $countries = Country::where('id', '236')->get();
        $blog = Blogs::where('slug',$slug)->first();
        return view(
            "frontend.dashboard_pages.edit_shopping",
            [
                'sub_blog_categories' => $sub_blog_categories,
                'countries' => $countries,
                'blog' => $blog,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');

        // $deleteId = $request->input('delete_id');
        // if ($deleteId) {
            
        //     $image = Image::find($deleteId);
        //     if ($image) {
        //         $image->delete();
        //         return response()->json(['success' => 'Image deleted successfully']);
        //     }
        //     return response()->json(['error' => 'Image not found'], 404);
        // }
    }


    public function services(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            
            $data = $request->toArray();
            // echo"<pre>"; print_r($request->all());  die;


            unset($data['_token']);
            unset($data['poll_question']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'post_type' => 'required',
                    'sub_category' => 'required',
                    //   'rate' => 'required|numeric',
                    //   'country' => 'required',
                    //   'state' => 'required',
                    //   'city' => 'required',
                    //   'zipcode' => 'required',
                    // 'image' => 'required|image|mimes:jpeg,png,jpg', // Example validation for image upload
                    // 'post_video' => 'required|file|mimes:mp4', // Example validation for video upload
                    // 'description' => 'required',
                    // 'phone' => 'required_if:personal_detail,true',
                    // 'email' => 'required_if:personal_detail,true|email',
                    // 'website' => 'required_if:personal_detail,true|url',
                    // 'post_type' => 'required|in:Bump Post,Feature Post,Normal Post',

                ],
                [
                    'post_type.required' => 'field is required',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if ($data['sub_category'] != 'Other') {

                    if (isset($data['sub_category']) && $data['sub_category']) {
                        $subCategories = $data['sub_category'];
                    }
                } else {
                    // dd('gegegegegege');
                    $categories = BlogCategories::where("title", $data['sub_category_oth'])->first();

                    $subCategories = $categories->id;
                }

                if ($categories && $subCategories) {

                    $data['city_name'] = isset($data['city_name_']) ? $data['city_name_'] : '';
                    $data['state_name'] = isset($data['state_name_']) ? $data['state_name_'] : '';
                    // $data['country'] = isset($data['event_country']) ? $data['event_country'] : '';
                    // $data['zipcode'] = isset($data['event_zipcode']) ? $data['event_zipcode'] : '';


                }

                $data['fees'] = isset($data['fees']) ? $data['fees'] : null;

                
                $data['vehicle_vin'] = isset($data['vehicle_vin']) ? $data['vehicle_vin'] : null;
                $data['vehicle_model'] = isset($data['vehicle_model']) ? $data['vehicle_model'] : null;
                $data['vehicle_odometer'] = isset($data['vehicle_odometer']) ? $data['vehicle_odometer'] : null;
                $data['odometer_break'] = isset($data['odometer_break']) ? $data['odometer_break'] : null;
                $data['odometer_rolled_over'] = isset($data['odometer_rolled_over']) ? $data['odometer_rolled_over'] : null;
                $data['vehicle_condition'] = isset($data['vehicle_condition']) ? $data['vehicle_condition'] : null;
                $data['vehicle_cylinders'] = isset($data['vehicle_cylinders']) ? $data['vehicle_cylinders'] : null;
                $data['vehicle_drive'] = isset($data['vehicle_drive']) ? $data['vehicle_drive'] : null;
                $data['vehicle_fuel'] = isset($data['vehicle_fuel']) ? $data['vehicle_fuel'] : null;
                $data['language_of_posting'] = isset($data['language_of_posting']) ? $data['language_of_posting'] : null;
                $data['vehicle_paint_color'] = isset($data['vehicle_paint_color']) ? $data['vehicle_paint_color'] : null;
                $data['vehicle_title_status'] = isset($data['vehicle_title_status']) ? $data['vehicle_title_status'] : null;
                $data['vehicle_transmission'] = isset($data['vehicle_transmission']) ? $data['vehicle_transmission'] : null;
                $data['vehicle_type'] = isset($data['vehicle_type']) ? $data['vehicle_type'] : null;
                $data['vehicle_model_year'] = isset($data['vehicle_model_year']) ? $data['vehicle_model_year'] : null;
                $data['crypto_currency'] = isset($data['crypto_currency']) ? $data['crypto_currency'] : null;
                $data['delivery_available'] = isset($data['delivery_available']) ? $data['delivery_available'] : null;
                $data['more_links'] = isset($data['more_links']) ? $data['more_links'] : null;

                unset($data['state_name_']);
                // unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);

                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::Service_create($data);

                if ($blog) {
                    //  if ($request->hasFile('image')) {
                    //     $image = $request->file('image');
                    //     $name = time() . '.' . $image->getClientOriginalExtension();
                    //     $destinationPath = public_path('/images_blog_img');
                    //     $image->move($destinationPath, $name);
                    //     $blog->image1 = $name;
                    // }

                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    $user = UserAuth::getLoginUser();

                    if ($request->post_type == "Feature Post") {
                         if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
                            if($user->featured_post_count == 'Unlimited'){
                                $new_post_count ='Unlimited';
                            }else{
                                $new_post_count = (int) $user->featured_post_count - 1;
                            }
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 705,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                                ];
                            Notification::feature_create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }else{

                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 705,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::feature_create($notice);
                        return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }
                    } elseif ($request->post_type == "Bump Post") {

                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 705,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::bump_create($notice);
                        return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    }elseif ($request->post_type == "Normal Post") {
                     if(!empty($user->paid_post_count) && $user->paid_post_count > 0 || $user->paid_post_count == "Unlimited"){
                            $notice = [
                             'from_id' => UserAuth::getLoginId(),
                             'to_id' => 7,
                             'cate_id' => 705,
                             'type' => 'post',
                             'rel_id' => $blog->id,
                             'slug' => $blog->slug,
                             'title' => $data['title'],
                             'username' => $user->username,
                             ];
                         Notification::create_post($notice); 
                        if($user->paid_post_count == "Unlimited"){
                            $new_post_count = "Unlimited";
                            Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                            Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Featured Post','featured_post' =>'on']);
                        }else{
                            $new_post_count = (int) $user->paid_post_count - 1;
                            Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                        }
                         
                         
                         $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
 
                         return redirect()->route('my_post');
                        }else{
                            
                        // $notice = [
                        //     'from_id' => UserAuth::getLoginId(),
                        //     'to_id' => 7,
                        //     'type' => 'post',
                        //     'message' => 'A service listing \"{$data['title']}\" is created by ' . $user->username,
                        // ];
                        // Notification::create($notice);
                        return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'services']);
                    }
                    }else {
                        Blogs::where('id', $blog->id)->update(['draft'=> 1]);
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 705,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'slug' => $blog->slug,
                            'title' => $data['title'],
                            'username' => $user->username,
                        ];
                        Notification::create_post($notice);
                        $codes = [
                            '{name}' => $user->username,
                            '{post_url}' => route('service_single', $blog->slug),
                            '{post_description}' =>  $user->description,

                        ];

                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                    }

                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('my_post');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 705",

            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();

        $hours = ServiceHour::where('user_id',UserAuth::getLoginId())->first();

        if ($hours === null) {
            // Set default values if $hours is null
            $days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
            $status = json_decode('{"monday":"on","tuesday":"on","wednesday":"on","thursday":"on","friday":"on","saturday":"on"}', true);
            $open_time = json_decode('{"monday":"09:00","tuesday":"09:00","wednesday":"09:00","thursday":"09:00","friday":"09:00","saturday":"09:00","sunday":"09:00"}', true);
            $close_time = json_decode('{"monday":"18:00","tuesday":"18:00","wednesday":"18:00","thursday":"18:00","friday":"18:00","saturday":"18:00","sunday":"19:00"}', true);
        } else {
            // Proceed if $hours is not null
            $days = json_decode($hours['day'], true);
            $status = json_decode($hours['status'], true);
            $open_time = json_decode($hours['open_time'], true);
            $close_time = json_decode($hours['close_time'], true);
        }
        // dd($hours);
        return view(
            "frontend.dashboard_pages.add_services",
            [
                'categories' => $categories,
                'countries' => $countries,
                // 'hours' => $hours,
                'days' => $days,
                'status' => $status,
                'open_time' => $open_time,
                'close_time' => $close_time,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');
    }


    public function Service_edit(Request $request, $slug)
    {

        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {

            $data = $request->toArray();
            // echo"<pre>"; dd($request->all());  die;


            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                    'post_type' => 'required',

                    // 'rate' => 'required|numeric',
                    // 'country' => 'required',
                    // 'state' => 'required',
                    // 'city' => 'required',
                    // 'zipcode' => 'required',

                    // 'description' => 'required',
                    // 'phone' => 'required_if:personal_detail,true',
                    // 'email' => 'required_if:personal_detail,true|email',
                    // 'website' => 'required_if:personal_detail,true|url',
                    // 'post_type' => 'required|in:Bump Post,Feature Post,Normal Post',
                ]
            );
            if (!$validator->fails()) {

                // if ($request->post_type == "Feature Post") {
                //     $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                //     $response = $middleware->handle($request, function ($request) {
                       
                //     });

                //     if ($response) {
                //         return $response; // Return the response from the middleware
                //     }
                // }


                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

                if ($categories && $subCategories) {

                    $data['city_name'] = isset($data['city_name_']) ? $data['city_name_'] : '';
                    $data['state_name'] = isset($data['state_name_']) ? $data['state_name_'] : '';
                }


                $data['fees'] = isset($data['fees']) ? $data['fees'] : null;

                unset($data['state_name_']);
                // unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);

                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = UserAuth::getLoginId();

                $blog = Blogs::Service_update($slug, $data);
                if ($blog) {
                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        
                        // Decode the existing image JSON string into an array
                        $existingImages = json_decode($blog->image1, true) ?: [];
                        
                        // Ensure $existingImages is an array
                        if (!is_array($existingImages)) {
                            $existingImages = [];
                        }
                    
                        foreach ($images as $image) {
                            // Generate a unique name for the new image
                            $name = time() . '_' . $image->getClientOriginalName();
                            
                            // Define the destination path
                            $destinationPath = public_path('/images_blog_img');
                            
                            // Move the uploaded image to the destination path
                            $image->move($destinationPath, $name);
                            
                            // Add the new image name to the array
                            $existingImages[] = $name;
                        }
                    
                        // Encode the updated image array back into a JSON string
                        $blog->image1 = json_encode($existingImages);
                    }
                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    $user = UserAuth::getLoginUser();

                    // if ($request->post_type == "Feature Post") {
                    //     if ($blog->featured_post == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 705,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::feature_update($notice);
                    //         return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } elseif ($request->post_type == "Bump Post") {
                    //     if ($blog->bumpPost == null) {
                    //         $notice = [
                    //             'from_id' => UserAuth::getLoginId(),
                    //             'to_id' => 7,
                    //             'cate_id' => 705,
                    //             'type' => 'post',
                    //             'rel_id' => $blog->id,
                    //             'slug' => $blog->slug,
                    //             'title' => $data['title'],
                    //             'username' => $user->username,
                    //         ];
                    //         Notification::bump_update($notice);
                    //         return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // }elseif ($request->post_type == "Normal Post") {
                    //     // dd($blog->post_type);
                    //     if ($blog->post_type == 'Bump Post' || $blog->post_type == 'Feature Post') {
                    //         $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 705,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    //     return redirect()->route('paypal.paid_service_post', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'cate_id' => 705,
                    //         'type' => 'post',
                    //         'rel_id' => $blog->id,
                    //         'slug' => $blog->slug,
                    //         'title' => $data['title'],
                    //         'username' => $user->username,
                    //     ];
                    //     Notification::update_post($notice);
                    // }

                    if ($blog->featured_post == "on") {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 705,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::feature_update($notice);
                    } elseif ($blog->bumpPost == 1 && $blog->featured_post != "on"){
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 705,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::bump_update($notice);
                    } else {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 705,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'slug' => $blog->slug,
                                'title' => $data['title'],
                                'username' => $user->username,
                            ];
                            Notification::update_post($notice);
                    }

                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('my_post');
                } else {
                    $request->session()->flash('error', 'Ad could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id = 705",

            ],
            'title asc',

        );
        $countries = Country::where('id', '233')->get();
        $blog = Blogs::where('slug',$slug)->first();

        $hours = ServiceHour::where('user_id',UserAuth::getLoginId())->first();

        if ($hours === null) {
            // Set default values if $hours is null
            $days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
            $status = json_decode('{"monday":"on","tuesday":"on","wednesday":"on","thursday":"on","friday":"on","saturday":"on"}', true);
            $open_time = json_decode('{"monday":"09:00","tuesday":"09:00","wednesday":"09:00","thursday":"09:00","friday":"09:00","saturday":"09:00","sunday":"09:00"}', true);
            $close_time = json_decode('{"monday":"18:00","tuesday":"18:00","wednesday":"18:00","thursday":"18:00","friday":"18:00","saturday":"18:00","sunday":"19:00"}', true);
        } else {
            // Proceed if $hours is not null
            $days = json_decode($hours['day'], true);
            $status = json_decode($hours['status'], true);
            $open_time = json_decode($hours['open_time'], true);
            $close_time = json_decode($hours['close_time'], true);
        }
        return view(
            "frontend.dashboard_pages.edit_services",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' =>  $blog,
                'days' => $days,
                'status' => $status,
                'open_time' => $open_time,
                'close_time' => $close_time,
            ]
        );
    }

    public function fundraisers()
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
                "parent_id = 7",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        // dd($categories);
        return view('frontend.dashboard_pages.add_fundraisers',compact('categories') );
    }

    public function edit_fundraisers($slug)
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
                "parent_id = 7",
                "blog_categories.status = 0",
            ],
            'title asc',
        );

        $blogs = Blogs::where('slug',$slug)->first();
    //   dd();
        return view('frontend.dashboard_pages.edit_fundraisers',compact('categories','blogs') );
    }
    
    public function add_fundraisers(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
    
        $validator = Validator::make(
            $request->toArray(),
            [
                'title' => 'required',
                'sub_category' => 'required',
                'post_type' => 'required',
            ],
            [
                'post_type.required' => 'field is required',
            ]
        );
    
        if (!$validator->fails()) {
            //   dd($request->all());
            $subCategories = $categories = [];
            if (isset($request['categories']) && $request['categories']) {
                $categories = $request['categories'];
            }
            if ($request['sub_category'] != 'Other') {
                if (isset($request['sub_category']) && $request['sub_category']) {
                    $subCategories = $request['sub_category'];
                }
            } else {
                $categories = BlogCategories::where("title", $request['sub_category_oth'])->first();
                $subCategories = $categories->id;
            }
    $user = UserAuth::getloginuser();
    $blog = new Blogs();
            // Image upload logic
            $imageNames = [];
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    $name = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('/images_blog_img');
                    $image->move($destinationPath, $name);
                    $imageNames[] = $name;
                }
            }

            if ($request->hasFile('business_video')) {
                $video = $request->file('business_video');
                $videoName = time() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('images_blog_video'), $videoName);
                $blog->post_video = $videoName;
            }

            $mergedArray = [];

            foreach ($request->payment_links as $index => $link) {
                $mergedArray[] = [
                    'name' => $request->payment_name[$index],
                    'url' => $link
                ];
            }
            
    
            // Instantiate the Blogs model and set properties
            
            $blog->title = $request->title;
            $blog->sub_category = $subCategories;
            $blog->image1 = json_encode($imageNames);
            $blog->price = $request->raise_amount;
            $blog->payment_links = json_encode($mergedArray);
            $blog->description = $request->description;
            $blog->personal_detail = $request->personal_detail;
            $blog->email = $request->email;
            $blog->phone = $request->phone;
            $blog->website = $request->website;
            $blog->whatsapp = $request->whatsapp;
            $blog->user_id = $user->id;
            $blog->created = carbon::Now();
    
            // Save the fundraiser data
            $blog->save();
            $blog->slug = Str::slug($blog->title) . '-' . General::encode($blog->id);
            $blog->save(); 
            if (!empty($categories)) {
                Blogs::handleCategories($blog->id, $categories);
            }

            if (!empty($subCategories)) {
                Blogs::handleSubCategories($blog->id, $subCategories);
            }
    
            // Additional logic for post types
            if ($request->post_type == "Normal Post") {
                $user = UserAuth::getLoginUser();
                if ($user->free_listing == 1) {
                    Users::where('id', $user->id)->update(['free_listing' => 0]);
                    $blog->draft = 1;
                    $blog->post_type = 'Paid Post';
                    $blog->save(); // Save changes to the blog
    
                    $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => 7,
                        'cate_id' => 7,
                        'type' => 'post',
                        'rel_id' => $blog->id,
                        'slug' => $blog->slug,
                        'title' => $blog->title,
                        'username' => $user->username,
                    ];
                    Notification::create_post($notice);
    
                    $codes = [
                        '{name}' => $user->username,
                        '{post_url}' => route('single.fundraisers', $blog->slug),
                        '{post_description}' => $user->description,
                    ];
    
                    General::sendTemplateEmail(
                        $user->email,
                        'feature-post',
                        $codes
                    );
    
                    $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. We will let you know once it\'s approved. Thank you for understanding.');
                    return redirect()->route('list.fundraisers');
                }elseif(!empty($user->paid_post_count) && $user->paid_post_count > 0 || $user->paid_post_count == "Unlimited"){
                    $notice = [
                     'from_id' => UserAuth::getLoginId(),
                     'to_id' => 7,
                     'cate_id' => 7,
                     'type' => 'post',
                     'rel_id' => $blog->id,
                     'slug' => $blog->slug,
                     'title' => $blog->title,
                     'username' => $user->username,
                    ];
                 Notification::create_post($notice); 
                if($user->paid_post_count == "Unlimited"){
                    $new_post_count = "Unlimited";
                    Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                    Blogs::where('id', $blog->id)->update(['draft'=> 1,'post_type' => 'Featured Post','featured_post' =>'on']);
                }else{
                    $new_post_count = (int) $user->paid_post_count - 1;
                    Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
                }
                 
                 
                 $request->session()->flash('success', 'Thanks for your Ad. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                 return redirect()->route('list.fundraisers');
                }else{
                    return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'fundraiser']);
                }
            }
        } else {
            $request->session()->flash('error', 'Please provide valid inputs.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function update_fundraisers(Request $request,$slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
    
        $validator = Validator::make(
            $request->toArray(),
            [
                'title' => 'required',
                'sub_category' => 'required',
                'post_type' => 'required',
            ],
            [
                'post_type.required' => 'field is required',
            ]
        );
    
        if (!$validator->fails()) {
            //  dd($request->all());
            $subCategories = $categories = [];
            if (isset($request['categories']) && $request['categories']) {
                $categories = $request['categories'];
            }
            if ($request['sub_category'] != 'Other') {
                if (isset($request['sub_category']) && $request['sub_category']) {
                    $subCategories = $request['sub_category'];
                }
            } else {
                $categories = BlogCategories::where("title", $request['sub_category_oth'])->first();
                $subCategories = $categories->id;
            }
            $user = UserAuth::getloginuser();
            $blog = Blogs::where('slug',$slug)->first();
            
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                
                // Decode the existing image JSON string into an array
                $existingImages = explode(',',$blog->image1) ?: [];
                
                // Ensure $existingImages is an array
                if (!is_array($existingImages)) {
                    $existingImages = [];
                }
            
                foreach ($images as $image) {
                    // Generate a unique name for the new image
                    $name = time() . '_' . $image->getClientOriginalName();
                    
                    // Define the destination path
                    $destinationPath = public_path('/images_blog_img');
                    
                    // Move the uploaded image to the destination path
                    $image->move($destinationPath, $name);
                    
                    // Add the new image name to the array
                    $existingImages[] = $name;
                }
            
                // Encode the updated image array back into a JSON string
                $blog->image1 = json_encode($existingImages);
            }

            if ($request->hasFile('business_video')) {
                $video = $request->file('business_video');
                $videoName = time() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('images_blog_video'), $videoName);
                $blog->post_video = $videoName;

            }
                $mergedArray = [];

                foreach ($request->payment_links as $index => $link) {
                    $mergedArray[] = [
                        'name' => $request->payment_name[$index],
                        'url' => $link
                    ];
                }
                
           
            // echo '<pre>'; print_r($slug); echo '</pre>'; die('developer');
            $blog->title = $request->title;
            $blog->sub_category = $subCategories;
            // $blog->image1 = implode(",", $imageNames);
            $blog->price = $request->raise_amount;
            $blog->payment_links = json_encode($mergedArray);
            $blog->description = $request->description;
            $blog->personal_detail = $request->personal_detail;
            $blog->email = $request->email;
            $blog->phone = $request->phone;
            $blog->website = $request->website;
            $blog->whatsapp = $request->whatsapp;
            $blog->user_id = $user->id;
            $blog->created = carbon::Now();
    
            // Save the fundraiser data
            $blog->save();


            if (!empty($categories)) {
                Blogs::handleCategories($blog->id, $categories);
            }

            if (!empty($subCategories)) {
                Blogs::handleSubCategories($blog->id, $subCategories);
            }
    
            // Additional logic for post types
            if ($request->post_type == "Normal Post") {
                $user = UserAuth::getLoginUser();
                if ($user->free_listing == 1) {
                    Users::where('id', $user->id)->update(['free_listing' => 0]);
                    $blog->draft = 1;
                    $blog->post_type = 'Paid Post';
                    $blog->save(); // Save changes to the blog
    
                    $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => 7,
                        'cate_id' => 7,
                        'type' => 'post',
                        'rel_id' => $blog->id,
                        'slug' => $blog->slug,
                        'title' => $blog->title,
                        'username' => $user->username,
                    ];
                    Notification::update_post($notice);
    
                    $codes = [
                        '{name}' => $user->username,
                        '{post_url}' => route('single.fundraisers', $blog->slug),
                        '{post_description}' => $user->description,
                    ];
    
                    General::sendTemplateEmail(
                        $user->email,
                        'feature-post',
                        $codes
                    );
    
                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('list.fundraisers');
                }elseif($blog->post_type == 'Normal Post'){
                    $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => 7,
                        'cate_id' => 7,
                        'type' => 'post',
                        'rel_id' => $blog->id,
                        'slug' => $blog->slug,
                        'title' => $blog->title,
                        'username' => $user->username,
                    ];
                    Notification::update_post($notice);
    
                    $codes = [
                        '{name}' => $user->username,
                        '{post_url}' => route('single.fundraisers', $blog->slug),
                        '{post_description}' => $user->description,
                    ];
    
                    General::sendTemplateEmail(
                        $user->email,
                        'feature-post',
                        $codes
                    );
                }else{
                    return redirect()->route('pay.auth.paid_Post', ['post_id' => General::encrypt($blog->id) , 'type' => 'fundraiser']);
                }
            }
        } else {
            $request->session()->flash('error', 'Please provide valid inputs.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
    

    public function event_add(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
        //  echo "<pre>"; print_r($request->all());die();
            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required'
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                //  if (isset($data['sub_category']) && $data['sub_category']) {
                //     $subCategories = $data['sub_category'];
                // }

                // if ($categories && $subCategories) { 
                // }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);



                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::event($data);

                if ($blog) {

                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    // if (!empty($subCategories)) {
                    //     Blogs::handleSubCategories($blog->id, $subCategories);
                    // }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();
                    // dd($data['post_type']);
                    if ($request->post_type == "Feature Post") {

                         if($user->free_listing==1){
                           $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 725,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'message' => "A fundraiser listing \"{$request->title}\" is created by {$user->username}.",
                            'url' => route('single.fundraisers', $blog->slug),
                            ];
                        Notification::create($notice); 
                        Users::where('id', $user->id)->update(['free_listing' => 0]);
                        Blogs::where('id', $blog->id)->update(['draft'=> 1 ,'featured_post' => 'on']);
                        $request->session()->flash('success', 'Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

                        return redirect()->route('event_post_list');
                        }else{
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 725,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'message' => "A fundraiser listing \"{$request->title}\" is created by {$user->username}.",
                            'url' => route('single.fundraisers', $blog->slug),
                        ];
                        Notification::create($notice);
                        return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                    }
                    } elseif ($request->post_type == "Bump Post") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 725,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'message' => "A new bump listing \"{$request->title}\" is created by {$user->username}.",
                            'url' => route('single.fundraisers', $blog->slug),
                        ];
                        Notification::create($notice);
                        return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    } else {
                        Blogs::where('id', $blog->id)->update(['draft'=> 1]); 
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 725,
                            'type' => 'post',
                            'rel_id' => $blog->id,
                            'message' => "A new listing \"{$request->title}\" is created by {$user->username}.",
                            'url' => route('single.fundraisers', $blog->slug),
                        ];
                        Notification::create($notice);
                    }

                    $request->session()->flash('success', 'Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('event_post_list');
                } else {
                    $request->session()->flash('error', 'Listing could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $countries = Country::where('id', '233')->get();

        return view(
            "frontend.dashboard_pages.event",
            [
                'countries' => $countries,
            ]
        );
    }



    public function edit_event_post(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {
            // echo "<pre>"; print_r($request->all());die();
            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required'
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                //  if (isset($data['sub_category']) && $data['sub_category']) {
                //     $subCategories = $data['sub_category'];
                // }

                // if ($categories && $subCategories) { 
                // }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);



                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::editevent($data, $id);

                if ($blog) {

                    if ($request->hasFile('image')) {
                        $images = $request->file('image');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $blog->image1 = $imageNames;
                    }

                    if ($request->hasFile('post_video')) {
                        $video = $request->file('post_video');
                        $videoName = time() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('images_blog_video'), $videoName);
                        $blog->post_video = $videoName;
                    }
                    $blog->save();

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    // if (!empty($subCategories)) {
                    //     Blogs::handleSubCategories($blog->id, $subCategories);
                    // }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                    if ($request->post_type == "Feature Post") {
                        if ($blog->featured_post == null) {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 725,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'message' => "A featured listing \"{$request->title}\" is created by {$user->username}.",
                                'url' => route('single.fundraisers', $blog->slug),
                            ];
                            Notification::create($notice);
                            return redirect()->route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blog->id)]);
                        }
                    } elseif ($request->post_type == "Bump Post") {
                        if ($blog->bumpPost == null) {
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 725,
                                'type' => 'post',
                                'rel_id' => $blog->id,
                                'message' => "A new bump listing \"{$request->title}\" is created by {$user->username}.",
                                'url' => route('single.fundraisers', $blog->slug),
                            ];
                        Notification::create($notice);
                        $codes = [
                            '{name}' => $user->username,
                            '{post_url}' => route('single.fundraisers', $blog->slug),
                            '{post_description}' =>  $user->description,

                        ];

                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                    }

                    $request->session()->flash('success', 'Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('event_post_list');
                } else {
                    $request->session()->flash('error', 'Listing could not be update. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $countries = Country::where('id', '233')->get();
        $blog = Blogs::find($id);
        return view(
            "frontend.dashboard_pages.edit_event",
            [
                'countries' => $countries,
                'blog' => $blog
            ]
        );
    }

    }

    public function my_post()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 705) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();
        
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.mypost', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }


    public function event_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 725) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();
        return view('frontend.dashboard_pages.eventList', compact('blog'));
    }

    public function job_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 2)// Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();
        
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.jobPostList', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }


    public function Fundraiser_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 7)// Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.fundraiserlist', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }

    public function realEstate_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 4) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.realEstatePostList', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }


    public function community_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $blog  = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 5) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->get();

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.communityPostList', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }


    public function shopping_post_list()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

    $blog  = Blogs::whereIn('blogs.id', function ($query) {
        $query->select('blogs.id')
            ->from('blogs')
            ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
            ->where('blogs.user_id', '=', UserAuth::getLoginId())
            ->where('blog_category_relation.category_id', '=', 6) // Add this condition
            ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->get();

    $plan_week = SubPlan::where('plan', 'Weekly')->first();
    $plan_month = SubPlan::where('plan', 'Monthly')->first();
    $plan_3month = SubPlan::where('plan', "Three Month's")->first();
    $plan_6month = SubPlan::where('plan', "Six Month's")->first();
    $plan_year = SubPlan::where('plan', "Yearly")->first();

    return view('frontend.dashboard_pages.shoppingPostList', compact('blog', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }



    public function create_old(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        if ($request->isMethod('post')) {

            $data = $request->toArray();
            $question = isset($data['poll_question']) ? $data['poll_question'] : '';
            $poll_option = array('Yes', 'No', 'May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();




            // echo"<pre>"; print_r($request->all());  die;
            // $values = array('id' => 1,'name' => 'Dayle');
            // DB::table('users')->insert($values);

            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'categories' => 'required',
                    'description' => 'required',
                    'sub_categories' => 'required',
                    'image' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if (isset($data['sub_categories']) && $data['sub_categories']) {
                    $subCategories = $data['sub_categories'];
                }

                if (in_array('5', $categories) && in_array('170', $subCategories)) {

                    $data['city_name'] = isset($data['city_name_']) ? $data['city_name_'] : '';
                    $data['state_name'] = isset($data['state_name_']) ? $data['state_name_'] : '';
                    $data['country'] = isset($data['event_country']) ? $data['event_country'] : '';
                    $data['zipcode'] = isset($data['event_zipcode']) ? $data['event_zipcode'] : '';

                    $data['event_start_date'] = date('Y-m-d', strtotime($data['event_start_date']));
                    $data['event_end_date'] = date('Y-m-d', strtotime($data['event_end_date']));
                }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);

                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::create($data);

                if ($blog) {
                    $destination = str_replace('/tmp/', '/blogs/', $data['image']);
                    if ($data['image'] && FileSystem::moveFile($data['image'], $destination)) {
                        $originalName = FileSystem::getFileNameFromPath($destination);
                        FileSystem::resizeImage($destination, $originalName, '800*800');
                        FileSystem::resizeImage($destination, 'M-' . $originalName, '375*375');
                        FileSystem::resizeImage($destination, 'S-' . $originalName, '100*100');
                        $blog->image = $destination;
                        $blog->save();
                    }

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    if ($question != '' && count($poll_option) > 0) {
                        $ques = array('title' => $question, 'post_id' => $blog->id);
                        $quesid = DB::table('poll_questions')->insertGetId($ques);
                        if ($quesid) {
                            $options = array();
                            foreach ($poll_option as $k => $o) {
                                $options[$k]['title'] = $o;
                                $options[$k]['question_id'] = $quesid;
                                $options[$k]['post_id'] = $blog->id;
                            }
                            DB::table('poll_options')->insert($options);
                        }
                    }

                    $user = UserAuth::getLoginUser();

                    if ($feature == "feature_post") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'message' => "A new featured post \"{$data['title']}\" is created by {$user->username}.",
                        ];
                        Notification::create($notice);

                        return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    } else {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'message' => "A new post \"{$data['title']}\" is created by {$user->username}.",
                        ];
                        Notification::create($notice);
                    }

                    $request->session()->flash('success', 'Thanks for your post. We still need to review the changes before they go live. Please allow up to one business day for us to review and approve it. Thank you for understanding.');
                    return redirect()->route('post.create');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id is null",
                "blog_categories.status = 1",
            ],
            'blog_categories.id asc',
            6
        );
        $countries = Country::where('id', '236')->get();

        return view(
            "frontend.posts.createPost",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
    }

    public function searchSubCategories(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $categories = BlogCategories::getAll(
            [
                'id',
                'parent_id',
                'title',
                'slug',
            ],
            [
                "parent_id is not null",
                "blog_categories.status = 1",
                'blog_categories.parent_id IN (' . implode(',', $request->get('ids') ? $request->get('ids') : [0]) . ')',
            ],
            'blog_categories.id asc'
        );

        $subHtml = [];
        foreach ($categories as $key => $value) {
            $subHtml[$value->parent_id][] = '<option value="' . $value->id . '" ' . ($request->has('selected') && in_array($value->id, $request->get('selected')) ? 'selected' : '') . '>' . $value->title . '</option>';
        }
        $html = "";
        foreach ($subHtml as $key => $value) {
            $category = BlogCategories::where('id', $key)->pluck('title')->first();
            $html .= '<optgroup label="' . $category . '">' . implode('', $value) . '</optgroup>';
        }
        return Response()->json([
            'status' => true,
            'categories' => $html,
        ]);
    }

    public function getCategories($id)
    {

        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // die($id);
        $category = 'Category';
        if ($id) {
            $mapped = [];
            $post_ids = BlogCategoryRelation::where('category_id', $id)->pluck('blog_id')->toArray();


            $category = BlogCategories::where('id', $id)->pluck('title')->first();
            //$post_ids = DB::table('blog_category_relation')->select('blog_id')->where('category_id', $id)->distinct()->get();
            // $data = collect($post_ids->toArray());
            // $mapped = $data->map(function ($value) {

            //     //print_r($value->blog_id); die;

            //     return \App\Models\Admin\Blogs::with('user')->where('status', 1)->where('id', $value->blog_id)->orderBy('id', 'desc')->get();
            // });
            // $posts = $mapped;
            $posts = \App\Models\Admin\Blogs::with('user')->where('status', 1)->orderBy('id', 'desc')->whereIn('id', $post_ids)->get();
            //print_r($posts); die;
        } else {
            $posts = \App\Models\Admin\Blogs::with('user')->where('status', 1)->orderBy('id', 'desc')->get();
        }
        return view("frontend.posts.category", ['posts' => $posts, 'category_name' => $category]);
    }


    public function getPosts(Request $request, $id = null)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        if ($id) {
            $mapped = [];
            $da = DB::table('blog_category_relation')->select('blog_id')->distinct()->get();
            $data = collect($da->toArray());
            $mapped = $data->map(function ($value) {
                return \App\Models\Admin\Blogs::with('user')->where('status', 1)->where('id', $value->blog_id)->orderBy('id', 'desc')->get();
                // return DB::table('blogs')->join('users', 'blogs.user_id', '=', 'users.id')->where('blogs.id',$value->blog_id)->where('blogs.status',1)->orderBy('blogs.id', 'desc')->get();
            });
            $posts = $mapped;
        } else {

            $sub_cate = '';
            $main_cat = '';
            $blog_categories = array();
            $blog_cat_ids = Blogs::where('status', 1)->pluck('id');
            $bcr_ids = BlogCategoryRelation::whereIn('blog_id', $blog_cat_ids)->pluck('sub_category_id');
            // $blog_categories = BlogCategories::where('parent_id', '>', 0)->whereIn('id', $bcr_ids)->get();
            // $blog_categories = BlogCategories::where('parent_id', '>', 0)->get();
            $da = DB::table('blog_category_relation')->select('blog_id')->distinct()->get();
            $data = collect($da->toArray());

            $categories = BlogCategories::getAll(
                [
                    'id',
                    'title',
                    'slug',
                    'image',
                ],
                [
                    "parent_id is null",
                    "blog_categories.status = 1",
                ],
                'blog_categories.id asc',
                6
            );

            if ($request->main_cat != '') {
                $main_cat = $request->main_cat;
                $blog_categories = BlogCategories::where('parent_id', $request->main_cat)->get();
            }

            if ($request->sub_cat != '') {
                $sub_cate = $request->sub_cat;
                $mapped = [];
                $da = DB::table('blog_category_relation')->where('sub_category_id', $request->sub_cat)->select('blog_id')->distinct()->get();
                $dataa = collect($da->toArray());
                $ids = array();
                foreach ($dataa as $key => $value) {
                    $ids[] = $value->blog_id;
                }

                $posts = \App\Models\Admin\Blogs::with('user')->whereIn('id', $ids)->where('status', 1)->orderBy('id', 'desc')->get();
            } else {
                $posts = \App\Models\Admin\Blogs::with('user')->where('status', 1)->orderBy('id', 'desc')->get();
            }
            // dd($posts);
        }
        return view(
            "frontend.posts.posts",
            [
                'posts' => $posts,
                'blog_categories' => $blog_categories,
                'sub_cate' => $sub_cate,
                'main_cat' => $main_cat,
                'categories' => $categories
            ]
        );
    }

    public function myPosts(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd(UserAuth::getLoginId());

        $sub_cate = '';
        $main_cat = '';
        $blog_categories = array();
        $blog_cat_ids = Blogs::where('user_id', UserAuth::getLoginId())->pluck('id');
        $bcr_ids = BlogCategoryRelation::whereIn('blog_id', $blog_cat_ids)->pluck('sub_category_id');

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id is null",
                "blog_categories.status = 1",
            ],
            'blog_categories.id asc',
            6
        );
        $da = DB::table('blog_category_relation')->select('blog_id')->distinct()->get();
        $data = collect($da->toArray());

        if ($request->main_cat != '') {
            $blog_categories = BlogCategories::where('parent_id', $request->main_cat)->get();
        }
        if ($request->sub_cat != '') {
            $sub_cate = $request->sub_cat;
            $main_cat = $request->main_cat;
            $mapped = [];
            $da = DB::table('blog_category_relation')->where('sub_category_id', $request->sub_cat)->select('blog_id')->distinct()->get();
            $dataa = collect($da->toArray());
            $ids = array();
            foreach ($dataa as $key => $value) {
                $ids[] = $value->blog_id;
            }

            $posts = \App\Models\Admin\Blogs::with('user')->whereIn('id', $ids)->where('user_id', UserAuth::getLoginId())->orderBy('id', 'desc')->get();
        } else {
            $posts = \App\Models\Admin\Blogs::with('user')->orderBy('id', 'desc')->where('user_id', UserAuth::getLoginId())->get();
        }
        return view(
            "frontend.posts.my_posts",
            [
                'posts' => $posts,
                'blog_categories' => $blog_categories,
                'sub_cate' => $sub_cate,
                'main_cat' => $main_cat,
                'categories' => $categories
            ]
        );
    }

    public function search_listing(Request $request)
{
    $userName = $request->input('user_name', '');
    // $location = $request->input('location', '');

    $users = Users::where('first_name', 'like', '%' . $userName . '%')
        ->where('username', 'like', '%' . $userName . '%')
        ->whereNull('deleted_at')
        ->get();
    $blogPosts = BlogPost::where('title', 'like', '%' . $userName . '%')
        ->orWhere('location', 'like', '%' . $userName . '%')
        ->whereNull('deleted_at')
        ->where('status', 1)
        ->get();
    $videos = Video::where('title', 'like', '%' . $userName . '%')
        ->orWhere('location', 'like', '%' . $userName . '%')
        ->where('status', 1)
        ->get();
    $entertainments = Entertainment::where('Title', 'like', '%' . $userName . '%')
        ->orWhere('location', 'like', '%' . $userName . '%')
        ->whereNull('deleted_at')
        ->where('status', 1)
        ->get();
    $blogs = Blogs::where('title', 'like', "%{$userName}%")
        ->orWhere('location', 'like', '%' . $userName . '%')
        ->whereNull('deleted_at')
        ->where('status', 1)
        ->get();

    $business = Business::where('business_name', 'like', "%{$userName}%")
        ->orWhere('location', 'like', '%' . $userName . '%')
        ->whereNull('deleted_at')
        ->where('status', 1)
        ->get();

    $results = [
        'users' => $users,
        'blogPosts' => $blogPosts,
        'videos' => $videos,
        'entertainments' => $entertainments,
        'blogs' => $blogs,
        'business' => $business
    ];

    $results = view('frontend.userSearchDashboard', [
        'results' => $results
    ])->render();

    return response()->json(['suggestions' => $results]);
}


    
    public function search_members(Request $request)
    {
        $member_name = $request->input('query');
    
        $results = Users::where('first_name', 'like', "%$member_name%")->get();
    
        $suggestions = [];
        if ($results->isNotEmpty()) {
            $suggestions = $results->map(function ($member) {
                $route = route('UserProfileFrontend', $member->slug);

                $dob = ($member->dob === '0000-00-00' || $member->dob === null) ? '' : $member->dob;
    
                return [
                    'first_name' => $member->first_name,
                    'image' => $member->image ?? '',
                    'dob' => $dob,
                    'route' => $route
                ];
            });
        }
    
        return response()->json(['suggestions' => $suggestions]);
    }
    
    public function view(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $id = (is_numeric($id)) ? $id : base64_decode($id);
        $blog = Blogs::get($id);
        $sc = Arr::pluck($blog->categories, 'id');
        $other_post = array();
        if ($sc) {
            $cate_gories = BlogCategoryRelation::where('category_id', $sc[0])->get()->pluck('blog_id');
            if ($cate_gories) {
                $other_post = \App\Models\Admin\Blogs::where('status', 1)->where('id', '!=', $id)->whereIn('id', $cate_gories)->take(3)->get();
            }
        }

        if ($blog && $blog->status == 1) {
            // if ($blog) {
            if ($blog->event_location != '') {
                return view("frontend.posts.view_community", [
                    'post' => $blog,
                    'other_post' => $other_post,
                ]);
            } else {
                return view("frontend.posts.view", [
                    'post' => $blog,
                    'other_post' => $other_post,
                ]);
            }
        } else {
            $request->session()->flash('error', 'This post under review when admin approve then it will show in details page.');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        $id = base64_decode($id);
        $blog = Blogs::get($id);
        if ($blog) {
            if ($request->isMethod('post')) {

                // echo"<pre>"; print_r($request->all());  die;
                $data = $request->toArray();
                $validator = Validator::make(
                    $request->toArray(),
                    [
                        'title' => [
                            'required',
                            Rule::unique('blogs')->ignore($blog->id),
                        ],
                        'description' => 'required',
                    ]
                );

                if (!$validator->fails()) {
                    unset($data['_token']);

                    /** ONLY IN CASE OF MULTIPLE IMAGE USE THIS **/
                    /*if(isset($data['image']) && $data['image'])
                    {
                    $data['image'] = json_decode($data['image'], true);
                    $blog->image = $blog->image ? json_decode($blog->image) : [];
                    $data['image'] = array_merge($blog->image, $data['image']);
                    $data['image'] = json_encode($data['image']);
                    }
                    else
                    {
                    unset($data['image']);
                    }*/
                    /** ONLY IN CASE OF MULTIPLE IMAGE USE THIS **/

                    /** IN CASE OF SINGLE UPLOAD **/
                    if (isset($data['image']) && $data['image']) {
                        $oldImage = $blog->image;
                    } else {
                        unset($data['image']);
                    }
                    /** IN CASE OF SINGLE UPLOAD **/

                    //   $categories = [];
                    // if(isset($data['category']) && $data['category']) {
                    //   $categories = $data['category'];
                    // }
                    // unset($data['category']);

                    $subCategories = $categories = [];
                    if (isset($data['categories']) && $data['categories']) {
                        $categories = $data['categories'];
                    }
                    unset($data['categories']);
                    if (isset($data['sub_categories']) && $data['sub_categories']) {
                        $subCategories = $data['sub_categories'];
                    }

                    unset($data['sub_categories']);
                    $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                    if (Blogs::modify($id, $data)) {
                        /** IN CASE OF SINGLE UPLOAD **/
                        if (isset($oldImage) && $oldImage) {
                            FileSystem::deleteFile($oldImage);
                        }
                        /** IN CASE OF SINGLE UPLOAD **/

                        if (!empty($categories)) {
                            Blogs::handleCategories($blog->id, $categories);
                        }

                        if (!empty($subCategories)) {
                            Blogs::handleSubCategories($blog->id, $subCategories);
                        }

                        $request->session()->flash('success', 'Blog updated successfully.');
                        return redirect()->route('post.my_posts');
                    } else {
                        $request->session()->flash('error', 'Blog could not be save. Please try again.');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                } else {
                    $request->session()->flash('error', 'Please provide valid inputs.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            $categories = BlogCategories::getAll(
                [
                    'id',
                    'title',
                    'slug',
                    'image',
                ],
                [
                    "parent_id is null",
                    "blog_categories.status = 1",

                ],
                'blog_categories.id asc',
                6
            );

            $categories_sub = BlogCategories::getAllCategorySubCategory();
            $countries = Country::where('id', '236')->get();

            if ($blog->event_location != '') {

                return view("frontend/posts/edit_event", [
                    'blog' => $blog,
                    'categories' => $categories,
                    'categories_sub' => $categories_sub,
                    'countries' => $countries,

                ]);
            } else {

                return view("frontend/posts/edit", [
                    'blog' => $blog,
                    'categories' => $categories,
                    'categories_sub' => $categories_sub,
                    'countries' => $countries,

                ]);
            }
        } else {
            abort(404);
        }
    }

    public function getState($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd(Auth::id());
        $states = State::where('country_id', $id)->get();

        $html = "";
        foreach ($states as $key => $value) {
            $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return Response()->json([
            'status' => true,
            'states' => $html,
        ]);
    }

    public function getCity($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd(Auth::id());
        $states = City::where('state_id', $id)->get();

        $html = "";
        foreach ($states as $key => $value) {
            $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return Response()->json([
            'status' => true,
            'cities' => $html,
        ]);
    }

    public function createTest(Request $request)
    {
        
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        if ($request->isMethod('post')) {
            $data = $request->toArray();
            unset($data['_token']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'categories' => 'required',
                    'description' => 'required',
                    'sub_categories' => 'required',
                    'image' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }
                unset($data['categories']);
                if (isset($data['sub_categories']) && $data['sub_categories']) {
                    $subCategories = $data['sub_categories'];
                }
                unset($data['sub_categories']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['user_id'] = UserAuth::getLoginId();
                $blog = Blogs::create($data);

                if ($blog) {
                    $destination = str_replace('/tmp/', '/blogs/', $data['image']);
                    if ($data['image'] && FileSystem::moveFile($data['image'], $destination)) {
                        $originalName = FileSystem::getFileNameFromPath($destination);
                        FileSystem::resizeImage($destination, $originalName, '800*800');
                        FileSystem::resizeImage($destination, 'M-' . $originalName, '375*375');
                        FileSystem::resizeImage($destination, 'S-' . $originalName, '100*100');
                        $blog->image = $destination;
                        $blog->save();
                    }

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($subCategories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }

                    $request->session()->flash('success', 'Post created successfully.');
                    return redirect()->route('post.create');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $categories = BlogCategories::getAll(
            [
                'id',
                'title',
                'slug',
                'image',
            ],
            [
                "parent_id is null",
                "blog_categories.status = 1",
            ],
            'blog_categories.id asc',
            6
        );
        $countries = Country::get();

        return view(
            "frontend.posts.createPostTest",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
    }


    public  function about_brenda()
    {
        $metaData = [
            'title' => 'Brenda Pond | Founder and CEO of Finderspage',
            'description' => 'Brenda Pond | About me - The world knows me to be the Founder/CEO of FindersPage. I\'m just a small-town girl from the country, surviving just like everyone else.'
        ];

        return view('frontend.pages.about-brenda', compact('metaData'));
    }


    public function fetch_state_job(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $state = State::where('country_id', $request->id)->get();
        $stateHtml = "";
        foreach ($state as $states) {
            $stateHtml .= "<option value='" . $states["id"] . "'>" . $states["name"] . "</option>";
        }
        return response()->json(
            [
                'success' => 'Profile image updated.',
                "option_html" => $stateHtml
            ]
        );
    }

    public function fetch_city_job(Request $request)
    {

        $city = City::where('state_id', $request->id)->get();
        $cityHtml = "";
        foreach ($city as $eachCity) {
            $cityHtml .= "<option value='" . $eachCity["id"] . "'>" . $eachCity["name"] . "</option>";
        }
        return response()->json(
            [
                'success' => '',
                "option_html" => $cityHtml
            ]
        );
    }

    public function fetch_state(Request $request)
    {
        // dd($request->all()); 
        $blogs = Blogs::find($request->userid);
        // dd($blogs);
        $state = State::where('country_id', $request->id)->get();
        $stateHtml = "";

        foreach ($state as $states) {
            $stateHtml .= "<option " . ($blogs->state == $states["id"] ? 'selected' : '') . " value='" . $states["id"] . "'>" . $states["name"] . "</option>";
        }
        return response()->json(
            [
                'success' => 'Profile image updated.',
                "option_html" => $stateHtml
            ]
        );
    }

    public function fetch_city(Request $request)
    {
        // dd($request->all()); 
        $blogs = Blogs::find($request->userid);
        // dd($blogs);
        $city = City::where('state_id', $request->id)->get();
        $cityHtml = "";
        foreach ($city as $eachCity) {
            $cityHtml .= "<option " . ($blogs->city == $eachCity["id"] ? 'selected' : '') . " value='" . $eachCity["id"] . "'>" . $eachCity["name"] . "</option>";
            // $cityHtml .= "<option value='".$eachCity["id"]."'>".$eachCity["name"]."</option>";
        }
        return response()->json(
            [
                'success' => '',
                "option_html" => $cityHtml
            ]
        );
    }



    function delete(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        


        $blog = Blogs::find($id);

        if ($blog->delete()) {

            $request->session()->flash('success', 'Ad deleted successfully.');

            return redirect()->back();
        } else {

            $request->session()->flash('error', 'Ad could not be delete.');

            return redirect()->back();
        }
    }
    public function Savedpost(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd($request->all());
        // Get the user_id and post_id from the request
        $user_id = $request->userid;
        $post_id = $request->post_id;
        $post_type = $request->post_type;

        // Check if the record already exists
        $existingRecord = DB::table('saved_post')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->where('post_type', $post_type)
            ->first();

        if ($existingRecord) {
            // Record already exists, return a message
            return response()->json(['error' => 'You already saved this post.'], 400);
        }

        // If the record doesn't exist, perform the insert
        $data = [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'post_type' => $post_type
        ];
        $inst = DB::table('saved_post')->insert($data);

        if ($inst) {
            return response()->json(['success' => 'Post saved.', 'saved' => 'true'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong.'], 400);
        }
    }




    public function unSavedpost(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // Get the user_id and post_id from the request
        // dd($request->all());
        $user_id = $request->userid;
        $post_id = $request->post_id;
        $post_type = $request->post_type;

        // Check if the record already exists
        $deleteResult = DB::table('saved_post')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->where('post_type', $post_type)
            ->delete();

        if ($deleteResult) {
            return response()->json(['success' => 'Post unsaved.'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong.'], 400);
        }
    }

    public function UserProfileforntend($slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $user = Users::where('slug',$slug)->first();
        //  dd($slug);
        $loginid = UserAuth::getLoginId();

        $setting = Setting::where('user_id', UserAuth::getLoginId())->get();
        $resume = Resume::where('user_id', $user->id)->where('user_id', $loginid)->first();
        // dd($resume);
        $profile_view = PostView::where('user_id', $user->id)->sum('count');
        $profile_connected = Follow::where('follower_id',$user->id)->where('deleted_at',null)->where('status',1)->count();
        
        // dd($profile_connected);
        $get_connected_user = Follow::where('follower_id', $user->id)->where('deleted_at',null)->get(); 

        $followers = Follow::where('follower_id', $user->id)->where('status',1)->get();
        // dd($followers);
        $followerDetailsArray = [];

        foreach ($followers as $follower) {
            $followerDetails = Users::where('id', $follower->following_id)->select('id', 'first_name', 'image', 'slug')->first();
            
            if ($followerDetails) {

                $hasStatusOne = Latest_post::where('user_id', $followerDetails->id)
                                            ->where('to_id', UserAuth::getLoginId())
                                           ->where('status', '1')
                                           ->exists();
        
                $followerDetailsArray[] = [
                    'id' => $followerDetails->id,
                    'first_name' => $followerDetails->first_name,
                    'image' => $followerDetails->image,
                    'slug' => $followerDetails->slug,
                    'status' => $hasStatusOne ? '1' : '0',
                ];
            }
        }
        // dd($followerDetails);
        //  dd($followerDetailsArray);
        $jobCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 2)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $realestateCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 4)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $communityCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 5)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $shoppingCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $fundraisersCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 7)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $servicesCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 705)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        // $Blogs = BlogPost::where('user_id', '=', $user->id)->where('status', 1)->get();
        $Blogs = BlogPost::where('user_id', $user->id)->where('status', 1)->latest()->take(3)->get();
        $totalBlogCount = BlogPost::where('user_id', $user->id)->where('status', 1)->count();

        $Entertainment_count = Entertainment::where('user_id', '=', $user->id)
                    ->where('status', 1)
                    ->get();
        $Business_count = Business::where('user_id', '=', $user->id)
                    ->whereNull('deleted_at')
                    ->where('status', 1)
                    ->get();
        $video = Video::where('view_as','public')->where('status' , 1)->where('user_id',$user->id)->get();
        // dd($Entertainment_count);
        $pin_blog = BlogPost::where('pin_to_profile', 1)->where('user_id', $user->id)->limit(3)->orderBy('updated_at', 'desc')->get();

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

        $shareComponent = \Share::page(
                'https://www.finderspage.com/user/'.$user->id,
                'Your share text comes here',
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()        
            ->reddit();

        // dd($pin_blog);
        return view('frontend.savedPost.userprofileLayout', compact('user', 'realestateCount','totalBlogCount', 'shoppingCount', 'fundraisersCount', 'servicesCount', 'jobCount', 'profile_view', 'setting', 'profile_connected', 'resume', 'pin_blog', 'Blogs', 'get_connected_user', 'Entertainment_count', 'Business_count', 'followerDetailsArray','video','shareComponent','communityCount','categories','followers'));
    }



    public function UserProfileforntend_admin($slug)
    {
        
        $user = Users::where('slug',$slug)->first();
        //  dd($slug);
        $loginid = UserAuth::getLoginId();

        $setting = Setting::where('user_id', UserAuth::getLoginId())->get();
        $resume = Resume::where('user_id', $user->id)->where('user_id', $loginid)->first();
        // dd($resume);
        $profile_view = PostView::where('user_id', $user->id)->sum('count');
        $profile_connected = Follow::where('follower_id',$user->id)->where('deleted_at',null)->where('status',1)->count();
        
        // dd($profile_connected);
        $get_connected_user = Follow::where('follower_id', $user->id)->where('deleted_at',null)->get(); 
        //  dd($get_connected_user);
        $followers = Follow::where('follower_id', $user->id)->where('status',1)->pluck('following_id')->toArray();
        $followerDetailsArray = [];
        foreach ($followers as $followerId) {
            $followerDetails = Users::where('id', $followerId)->select('id', 'first_name', 'image','slug')->first();
            // Check if the user details were found
            if ($followerDetails) {
                // Add follower details to the array
                $followerDetailsArray[] = [
                    'id' => $followerDetails->id,
                    'first_name' => $followerDetails->first_name,
                    'image' => $followerDetails->image,
                    'slug' => $followerDetails->slug,
                ];
            }
        }

         // dd($followerDetailsArray);
        $jobCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 2)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $realestateCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 4)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $communityCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 5)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $shoppingCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $fundraisersCount = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->join('users', 'users.id', '=', 'blogs.user_id')
                    ->where('blogs.status', '=', '1')
                    ->where('blog_category_relation.category_id', '=', 7)
                    ->groupBy('blogs.id');
            })
                ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
                ->orderBy('blogs.id', 'desc')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->get();


        $servicesCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 705)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        // $Blogs = BlogPost::where('user_id', '=', $user->id)->where('status', 1)->get();
        $Blogs = BlogPost::where('user_id', $user->id)->where('status', 1)->latest()->take(3)->get();
        $totalBlogCount = BlogPost::where('user_id', $user->id)->where('status', 1)->count();

        $Business_count = Business::where('user_id', '=', $user->id)
                    ->whereNull('deleted_at')
                    ->where('status', 1)
                    ->get();
        $Entertainment_count = Entertainment::where('user_id', '=', $user->id)
                    ->where('status', 1)
                    ->get();
        $video = Video::where('view_as','public')->where('status' , 1)->where('user_id',$user->id)->get();
        // dd($Entertainment_count);
        $pin_blog = BlogPost::where('pin_to_profile', 1)->where('user_id', $user->id)->limit(3)->orderBy('updated_at', 'desc')->get();

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

        $shareComponent = \Share::page(
                'https://www.finderspage.com/user/'.$user->id,
                'Your share text comes here',
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()        
            ->reddit();

        // dd($pin_blog);
        return view('frontend.savedPost.userprofileLayout', compact('user', 'realestateCount','totalBlogCount', 'shoppingCount', 'fundraisersCount', 'servicesCount', 'jobCount', 'profile_view', 'setting', 'profile_connected', 'resume', 'pin_blog', 'Blogs', 'get_connected_user', 'Entertainment_count', 'Business_count', 'followerDetailsArray','video','shareComponent','communityCount','categories'));
    }

    public function show_current_user_blogs(Request $request)
    {
        $currentUserId = $request->input('current_user_id');
        $currentCalledSection = $request->input('current_called_section');
    
        // Initialize variables
        $Blogs = collect();
        $Business_count = collect();
        $jobCount = collect();
        $realestateCount = collect(); 
        $communityCount = collect();  
        $shoppingCount = collect();  
        $fundraisersCount = collect();
        $servicesCount = collect();
        $Entertainment_count = collect();
    
        if ($currentCalledSection == 'blogs') {
            $Blogs = BlogPost::where('user_id', $currentUserId)
                             ->where('status', 1)
                             ->get();

        } elseif ($currentCalledSection == 'Business') {
            $Business_count = Business::where('user_id', '=', $currentUserId)
                            ->whereNull('deleted_at')
                            ->where('status', 1)
                            ->get();
        
        } elseif ($currentCalledSection == 'Find-a-Job') {
            $jobCount = Blogs::whereIn('id', function ($query) {
                            $query->select('blogs.id')
                                  ->from('blogs')
                                  ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                                  ->where('blogs.status', 1)
                                  ->where('blog_category_relation.category_id', 2)
                                  ->groupBy('blogs.id');
                        })
                        ->where('user_id', $currentUserId)
                        ->orderBy('id', 'desc')
                        ->get();
                        
        } elseif ($currentCalledSection =='real-estate'){
                $realestateCount = Blogs::whereIn('id', function ($query) {
                    $query->select('blogs.id')
                          ->from('blogs')
                          ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                          ->where('blogs.status', 1)
                          ->where('blog_category_relation.category_id', 4)
                          ->groupBy('blogs.id');
                })
                ->where('user_id', $currentUserId)
                ->orderBy('id', 'desc')
                ->get();

        } elseif ($currentCalledSection =='our-community'){
            $communityCount = Blogs::whereIn('id', function ($query) {
                $query->select('blogs.id')
                      ->from('blogs')
                      ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                      ->where('blogs.status', 1)
                      ->where('blog_category_relation.category_id', 5)
                      ->groupBy('blogs.id');
            })
            ->where('user_id', $currentUserId)
            ->orderBy('id', 'desc')
            ->get();

        } elseif ($currentCalledSection =='shopping'){ 
            $shoppingCount = Blogs::whereIn('id', function ($query) {
                $query->select('blogs.id')
                      ->from('blogs')
                      ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                      ->where('blogs.status', 1)
                      ->where('blog_category_relation.category_id', 6)
                      ->groupBy('blogs.id');
            })
            ->where('user_id', $currentUserId)
            ->orderBy('id', 'desc')
            ->get();

        } elseif ($currentCalledSection =='fundraisers'){ 
            $fundraisersCount = Blogs::whereIn('id', function ($query) {
                $query->select('blogs.id')
                      ->from('blogs')
                      ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                      ->where('blogs.status', 1)
                      ->where('blog_category_relation.category_id', 7)
                      ->groupBy('blogs.id');
            })
            ->where('user_id', $currentUserId)
            ->orderBy('id', 'desc')
            ->get();
    
        } elseif ($currentCalledSection =='services'){
            $servicesCount = Blogs::whereIn('id', function ($query) {
                $query->select('blogs.id')
                      ->from('blogs')
                      ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                      ->where('blogs.status', 1)
                      ->where('blog_category_relation.category_id', 705)
                      ->groupBy('blogs.id');
            })
            ->where('user_id', $currentUserId)
            ->orderBy('id', 'desc')
            ->get();

        } elseif ($currentCalledSection =='entertainment-industry'){
            $Entertainment_count = Entertainment::where('user_id', $currentUserId)
                                ->where('status', 1)
                                ->get();
        }

        if ($Blogs->isNotEmpty() || $Business_count->isNotEmpty() || $jobCount->isNotEmpty()
        || $realestateCount->isNotEmpty() || $communityCount->isNotEmpty()
        || $shoppingCount->isNotEmpty() || $fundraisersCount->isNotEmpty()
        || $servicesCount->isNotEmpty() || $Entertainment_count->isNotEmpty()) {
            $html = view('frontend.savedPost.userprofileContentData', [
                'Blogs' => $Blogs,
                'Business_count' => $Business_count,
                'jobCount' => $jobCount,
                'realestateCount' => $realestateCount,
                'communityCount' => $communityCount,
                'shoppingCount' => $shoppingCount,
                'fundraisersCount' => $fundraisersCount,
                'servicesCount' => $servicesCount,
                'Entertainment_count' => $Entertainment_count
            ])->render();
            
            return response()->json(['html' => $html]);
        } else {
            return response()->json(['message' => 'No content found.'], 404);
        }
    }


    // public function show_current_user_blogs($user_id){

    //     if (!UserAuth::isLogin()) {
    //         return redirect('/signup');
    //     }
    //     $current_called_section = $_GET['current_called_section'];

    //     $user = Users::find($user_id);

    //     if($current_called_section =='blogs'){
    //        $Blogs = BlogPost::where('user_id', '=', $user->id)->where('status', 1)->get();
    //         $video = collect(); 
    //         $realestateCount = collect(); 
    //         $jobCount = collect(); 
    //         $servicesCount = collect(); 
    //         $Entertainment_count = collect(); 
    //         $communityCount = collect();  
    //         $shoppingCount = collect();  

    //     // }elseif($current_called_section =='video'){
    //     //     // $Blogs = collect(); 
    //     //     $video = Video::where('view_as','public')->where('status' , 1)->where('user_id',$user->id)->get();
    //     //     // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'video'))->render();
    //     //     $Blogs = collect(); 
    //     //     $realestateCount = collect(); 
    //     //     $jobCount = collect(); 
    //     //     $servicesCount = collect(); 
    //     //     $Entertainment_count = collect(); 
    //     //     $communityCount = collect();  
    //     //     $shoppingCount = collect();  
            
    //     }elseif($current_called_section =='real-estate'){
            
    //         $realestateCount = Blogs::whereIn('blogs.id', function ($query) {
    //             $query->select('blogs.id')
    //                 ->from('blogs')
    //                 ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    //                 ->join('users', 'users.id', '=', 'blogs.user_id')
    //                 ->where('blogs.status', '=', '1')
    //                 ->where('blog_category_relation.category_id', '=', 4)
    //                 ->groupBy('blogs.id');
    //         })
    //             ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
    //             ->orderBy('blogs.id', 'desc')
    //             ->join('users', 'users.id', '=', 'blogs.user_id')
    //             ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
    //             ->get();

    //             // $video = collect(); 
    //             $Blogs = collect(); 
    //             $jobCount = collect(); 
    //             $servicesCount = collect(); 
    //             $Entertainment_count = collect(); 
    //             $communityCount = collect();  
    //             $shoppingCount = collect();  
    //         // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'realestateCount'))->render();


    //     }elseif($current_called_section =='shopping'){
                
    //         $shoppingCount = Blogs::whereIn('blogs.id', function ($query) {
    //             $query->select('blogs.id')
    //                 ->from('blogs')
    //                 ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    //                 ->join('users', 'users.id', '=', 'blogs.user_id')
    //                 ->where('blogs.status', '=', '1')
    //                 ->where('blog_category_relation.category_id', '=', 6)
    //                 ->groupBy('blogs.id');
    //         })
    //             ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
    //             ->orderBy('blogs.id', 'desc')
    //             ->join('users', 'users.id', '=', 'blogs.user_id')
    //             ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
    //             ->get();
                

    //             // $video = collect(); 
    //             $Blogs = collect(); 
    //             $realestateCount = collect(); 
    //             $jobCount = collect(); 
    //             $servicesCount = collect(); 
    //             $Entertainment_count = collect(); 
    //             $communityCount = collect();  
               
    //         // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'shoppingCount'))->render();

    //     }elseif($current_called_section =='Find-a-Job'){
                
    //         $jobCount = Blogs::whereIn('blogs.id', function ($query) {
    //             $query->select('blogs.id')
    //                 ->from('blogs')
    //                 ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    //                 ->join('users', 'users.id', '=', 'blogs.user_id')
    //                 ->where('blogs.status', '=', '1')
    //                 ->where('blog_category_relation.category_id', '=', 2)
    //                 ->groupBy('blogs.id');
    //         })
    //             ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
    //             ->orderBy('blogs.id', 'desc')
    //             ->join('users', 'users.id', '=', 'blogs.user_id')
    //             ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
    //             ->get();

    //             $Blogs = collect(); 
    //             $realestateCount = collect(); 
    //             // $video = collect(); 
    //             $servicesCount = collect(); 
    //             $Entertainment_count = collect(); 
    //             $communityCount = collect();  
    //             $shoppingCount = collect();  

    //         // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'jobCount'))->render();


    //     }elseif($current_called_section =='entertainment-industry'){
                
    //             $Entertainment_count = Entertainment::where('user_id', '=', $user->id)->where('status', 1)->get();

    //             $Blogs = collect(); 
    //             $realestateCount = collect(); 
    //             $jobCount = collect(); 
    //             $servicesCount = collect(); 
    //             // $video = collect(); 
    //             $communityCount = collect();  
    //             $shoppingCount = collect();  

    //             // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'Entertainment_count'))->render();

    //     }elseif($current_called_section =='our-community'){
                
    //         $communityCount = Blogs::whereIn('blogs.id', function ($query) {
    //             $query->select('blogs.id')
    //                 ->from('blogs')
    //                 ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    //                 ->join('users', 'users.id', '=', 'blogs.user_id')
    //                 ->where('blogs.status', '=', '1')
    //                 ->where('blog_category_relation.category_id', '=', 5)
    //                 ->groupBy('blogs.id');
    //         })
    //             ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
    //             ->orderBy('blogs.id', 'desc')
    //             ->join('users', 'users.id', '=', 'blogs.user_id')
    //             ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
    //             ->get();

    //             $Blogs = collect(); 
    //             $realestateCount = collect(); 
    //             $jobCount = collect(); 
    //             $servicesCount = collect(); 
    //             $Entertainment_count = collect(); 
    //             // $video = collect();  
    //             $shoppingCount = collect();  
    //         // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'communityCount'))->render();



    //     }elseif($current_called_section =='services'){
            
    //             $servicesCount = Blogs::whereIn('blogs.id', function ($query) {
    //                 $query->select('blogs.id')
    //                     ->from('blogs')
    //                     ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    //                     ->join('users', 'users.id', '=', 'blogs.user_id')
    //                     ->where('blogs.status', '=', '1')
    //                     ->where('blog_category_relation.category_id', '=', 705)
    //                     ->groupBy('blogs.id');
    //             })
    //                 ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
    //                 ->orderBy('blogs.id', 'desc')
    //                 ->join('users', 'users.id', '=', 'blogs.user_id')
    //                 ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
    //                 ->get();

    //                 // $html = view('frontend.savedPost.userprofileContentData', compact('user', 'servicesCount'))->render();

    //                 $Blogs = collect(); 
    //                 $realestateCount = collect(); 
    //                 $jobCount = collect(); 
    //                 // $video = collect(); 
    //                 $Entertainment_count = collect(); 
    //                 $communityCount = collect();  
    //                 $shoppingCount = collect();  

    //     }else{

    //         $Blogs = collect(); 
    //         // $video = collect(); 
    //         $realestateCount = collect(); 
    //         $jobCount = collect(); 
    //         $servicesCount = collect(); 
    //         $Entertainment_count = collect(); 
    //         $communityCount = collect();  
    //         $shoppingCount = collect();  
    //     }

    //     dd($jobCount);
    //     $html = view('frontend.savedPost.userprofileContentData', compact(
    //         'user', 'Blogs', 'realestateCount', 'jobCount', 'servicesCount', 'Entertainment_count', 'communityCount', 'shoppingCount'
    //     ))->render();
    //     return response()->json(['html' => $html]);

    //     // return view('frontend.savedPost.userprofileContentData', compact('user','Blogs', 'video'));

    // }




    public function testUserProfile($user_id){
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $user = Users::find($user_id);
        $loginid = UserAuth::getLoginId();
        $city = City::all();
        $state = State::all();
        $country = Country::all();
        $setting = Setting::where('user_id', UserAuth::getLoginId())->get();
        $resume = Resume::where('user_id', $user_id)->where('user_id', $loginid)->first();
        // dd($resume);
        $profile_view = PostView::where('user_id', $user_id)->sum('count');
        $profile_connected = Follow::where('follower_id', $user_id)->count();
        
        $get_connected_user = Follow::where('follower_id', $user_id)->where('status',1)->get();

        $followers = Follow::where('follower_id', $user_id)->pluck('following_id')->toArray();
        $followerDetailsArray = [];
        foreach ($followers as $followerId) {
            $followerDetails = Users::where('id', $followerId)->select('id', 'first_name', 'image','slug')->first();
            // Check if the user details were found
            if ($followerDetails) {
                // Add follower details to the array
                $followerDetailsArray[] = [
                    'id' => $followerDetails->id,
                    'first_name' => $followerDetails->first_name,
                    'image' => $followerDetails->image,
                    'slug' => $followerDetails->slug,
                ];
            }
        }

         // dd($followerDetailsArray);
        $jobCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 2)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $realestateCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 4)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $communityCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 5)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $shoppingCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $servicesCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 705)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $user->id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();

        $Blogs = BlogPost::where('user_id', '=', $user->id)->where('status', 1)->get();
        $Entertainment_count = Entertainment::where('user_id', '=', $user->id)->where('status', 1)->get();
        $video = Video::where('view_as','public')->where('status' , 1)->where('user_id',$user->id)->get();
        // dd($Entertainment_count);
        $pin_blog = BlogPost::where('pin_to_profile', 1)->where('user_id', $user_id)->limit(3)->orderBy('updated_at', 'desc')->get();

        $shareComponent = \Share::page(
                'https://www.finderspage.com/user/'.$user_id,
                'Your share text comes here',
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()        
            ->reddit();

        // dd($pin_blog);
        return view('frontend.savedPost.userprofileLayout', compact('user', 'city', 'state', 'country', 'realestateCount', 'shoppingCount', 'servicesCount', 'jobCount', 'profile_view', 'setting', 'profile_connected', 'resume', 'pin_blog', 'Blogs', 'get_connected_user', 'Entertainment_count','followerDetailsArray','video','shareComponent','communityCount'));

    }




    public function create_slug_for_Posts(){

        $blog_post =  Users::where('status', 1)->get();
        // dd($blog_post);
        foreach ($blog_post as $blog) {
            $title = $blog->username;

            // Convert title to lowercase
            $slug = strtolower($title);

            // Replace spaces with hyphens or underscores
            $slug = str_replace(' ', '-', $slug);

            // Remove special characters or non-alphanumeric characters
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

         
            $update = Users::where('id', $blog->id)->update(['slug' => $slug]);
            // dd($update);


        }

        return response()->json(['success' =>'User updated successfully.']);
    }



    
}
