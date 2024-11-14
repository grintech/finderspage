<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Libraries\General;
use App\Models\UserAuth;
use App\Models\Admin\Slider;
use App\Models\Admin\Testimonials;
use App\Models\Admin\Products;
use App\Models\Admin\Pages;
use App\Models\Admin\ProductCategories;
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Settings;
use App\Models\Admin\OurServices;
use App\Models\Admin\Admins;
use App\Models\Blogs;
use App\Models\Admin\Users;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\BlogCategories;
use App\Models\Admin\NewsLetter;
use App\Models\Admin\BlogPost;
use App\Models\Business;
use App\Models\ProductReview;
use App\Models\Video;
use App\Models\Latest_post;
use App\Models\Entertainment;
use DB;
use App\Models\reviewModel;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Log;

class HomeController extends AppController
{
    function index()
    {
        // dd('code-check');
        // $to_name = "RECEIVER_NAME";
        // $to_email = "finderspage11@gmail.com";
        // $message = 'test';
        // $data = array("name"=>"Cloudways (sender_name)", "body" => "A test mail");

        // Mail::send([], $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject("Laravel Test Mail");
        // $message->from("wasim.grintech@gmail.com","Test Mail");
        // });

        $currency = AppController::CURRENCY_USD;
        $Latest_posts = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->orderBy('blogs.id', 'desc')
            ->limit(12)
            ->groupBy('blogs.id') // Add groupBy() method
            ->get();

        // $blog_post =  BlogPost::where('status', 1)->where('featured_post', 'on')->get();
        $blog_post = DB::table('blog_post')
                    ->where('status', 1)
                    ->where('posted_by', 'user')
                    ->where('draft', 1)
                    ->where('featured_post', 'on')
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $blog_cat_ids = Blogs::where('status', 1)->pluck('id');
        $bcr_ids = BlogCategoryRelation::whereIn('blog_id', $blog_cat_ids)->pluck('sub_category_id');
        $bcr_idss = BlogCategoryRelation::whereIn('blog_id', $blog_cat_ids)->pluck('category_id');
        $blog_categories = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();
        $sub_blog_categories = BlogCategories::where('parent_id', '>', 0)->orderBy('title', 'asc')->get();
        $existingRecord = DB::table('saved_post')->get();
        foreach ($sub_blog_categories as $list => $listValue) {
            $parent_id = $listValue->parent_id;
            $singlelisting = BlogCategories::where('id', '=', $parent_id)->pluck('parent_id')->first();
            $listValue->main_parent_id = $singlelisting;
        }

         $reviews = reviewModel::join('users', 'review.user_id', '=', 'users.id')->where('review.status',1)
        ->select('users.id as user_id','users.email', 'users.first_name','users.image','review.*')
        ->get();
        

        $metaData = [
            'title' => 'FindersPage - Your Safe Space for Networking, Inspiration, and Brand Promotion',
             'description' => 'FindersPage: Your sanctuary for drama-free networking, inspiration, and brand promotion in a positive, equal, and politics-free community',
            'keywords' => 'finderspage, real estate listing, entertainment industry, services listing, business listing website, real estate listing website, community directory, jobs listing'
        ];

        return view(
            "frontend.index",
            [
                'blog_categories' => $blog_categories,
                'sub_blog_categories' => $sub_blog_categories,
                'currency' => $currency,
                'existingRecord' => $existingRecord,
                'blog_post' => $blog_post,
                'metaData' => $metaData,
                'reviews' => $reviews,
            ]
        );
    }

    public function bump_post_data_request()
{
    // Fetching blog posts
    $blogs = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->on('blogs.sub_category', '=', 'blog_category_relation.sub_category_id');
        })
        ->where('blogs.status', 1)
        ->where('blogs.featured_post', 'on')
        ->whereNull('blogs.deleted_at')
        ->where('blogs.draft', 1)
        ->select('blogs.*', 'blog_category_relation.category_id') // Select category_id
        ->get();

        // Fetch products from the specific category
        $shopping = Blogs::whereIn('id', function ($query) {
            $query->select('blog_id')
                ->from('blog_category_relation')
                ->where('category_id', 6); // Filter for category_id == 6
        })
            ->where('status', 1)
            ->where('featured_post', 'on')
            ->whereNull('deleted_at')
            ->where('draft', 1)
            ->get();

        // Now, get the product IDs
        $productIds = $shopping->pluck('id');

        // Fetch reviews for those product IDs
        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();

    // Fetching blog_post posts
    // $blogPosts = BlogCategoryRelation::join('blog_post', function($join) {
    //         $join->on('blog_post.id', '=', 'blog_category_relation.blog_id')
    //              ->on('blog_post.subcategory', '=', 'blog_category_relation.sub_category_id');
    //     })
    //     ->where('blog_post.status', 1)
    //     ->where('blog_post.featured_post', 'on')
    //     ->whereNull('blog_post.deleted_at')
    //     ->where('blog_post.draft', 1)
    //     ->select('blog_post.*', 'blog_category_relation.category_id') // Select category_id
    //     ->get();

    // Fetching entertainment posts
    $entertainments = BlogCategoryRelation::join('Entertainment', function($join) {
            $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                 ->on('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id');
        })
        ->where('Entertainment.status', 1)
        ->where('Entertainment.featured_post', 'on')
        ->whereNull('Entertainment.deleted_at')
        ->where('Entertainment.draft', 1)
        ->select('Entertainment.*', 'blog_category_relation.category_id') // Select category_id
        ->get();

    // Fetching business posts
    $business = BlogCategoryRelation::join('businesses', function($join) {
            $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                 ->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id');
        })
        ->where('businesses.status', 1)
        ->where('businesses.type', 'Featured')
        ->where('businesses.draft', '1')
        ->whereNull('businesses.deleted_at')
        ->select('businesses.*', 'blog_category_relation.category_id') // Select category_id
        ->get();
        
    // dd($business);

    // Merging all the posts
    $combinedPosts = $blogs->merge($entertainments)
                           ->merge($business)
                           ->sortByDesc(function($post) {
                                // Sort by created_at for all tables
                                return $post->created_at ?? $post->created; // Assuming 'created_at' is used across tables or 'created' for blogs
                            })
                           ->take(50); // Limit to 50 posts

    // Fetch existing records
    $existingRecord = DB::table('saved_post')->get();

    // Render view
    $view = view('frontend.bumpPostAjax', [
        'blogs' => $combinedPosts, 
        'existingRecord' => $existingRecord,
        'allreview' => $allreview
    ])->render();

    // Return JSON response
    return response()->json(['html' => $view]);
}

    
    



    public function video_homepage()
    {


        $video = Video::where('featured_post', 'on')->latest()->take(10)->get();
        // dd($video);
        $view = view('frontend.videoAjax', ['video' => $video])->render();

        return response()->json(['html' => $view]);
    }


    public function AllFeaturedpost()
    {
        $featuredPostsFromBlogs = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', 1)
            ->where('blogs.featured_post', 'on')
            ->groupBy('blogs.id')
            ->orderByRaw("CASE 
                            WHEN blogs.featured_post = 'on' THEN 1 
                            WHEN blogs.bumpPost = 1 THEN 2 
                            ELSE 3 
                        END, blogs.id DESC")
            ->get();

        $blogPosts = BlogPost::where('status', 1)->orderBy('id', 'desc')->get();

        $entertainments = Entertainment::where('status', 1)
            ->where('featured_post', 'on')
            ->orderByRaw("CASE 
                            WHEN featured_post = 'on' THEN 1 
                            WHEN bumpPost = 1 THEN 2 
                            ELSE 3 
                        END, id DESC")
            ->get();

        $combinedPosts = $featuredPostsFromBlogs->merge($blogPosts)->merge($entertainments)->sortByDesc(function ($post) {
            return $post->created_at ?? $post->created;
        });
    
        $allreview = collect();
    
        if ($combinedPosts->isNotEmpty()) {
            $shopping = Blogs::whereIn('id', function ($query) {
                $query->select('blog_id')
                    ->from('blog_category_relation')
                    ->where('category_id', 6);
            })
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->where('draft', 1)
            ->get();

            $productIds = $combinedPosts->pluck('id')->merge($shopping->pluck('id'))->unique();

            $allreview = ProductReview::whereIn('product_id', $productIds)
                ->where('type', 'shopping')
                ->get();
        }
    
        return view('frontend.allFeaturedPost', ['featuredPost' => $combinedPosts, 'allreview' => $allreview]);
    }


    public function All_latest_post($slug)
    {
        $user_id = UserAuth::get_user_id_from_slug($slug);
    
        $category_id = null; 

        $business = Business::where('status', '1')
            ->where('user_id', $user_id->id)
            ->whereNull('deleted_at')
            ->where('draft', '1')
            ->whereDate('created_at', '>', Carbon::now()->subDays(38)->toDateString())
            ->get();

        if ($business->isNotEmpty()) {
            foreach ($business as $post) {
                $post->category_id = 1;
            }
        }

        $blogs = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', 1)
            ->whereNull('blogs.deleted_at')
            ->where('blogs.user_id', $user_id->id)
            ->where('blogs.draft', 1)
            ->whereDate('blogs.created', '>', Carbon::now()->subDays(38)->toDateString())
            ->get();

        if ($blogs->isNotEmpty()) {
            foreach ($blogs as $post) {
                $post->category_id = $post->category_id; 
            }
        }

        $entertainments = Entertainment::where('status', 1)
            ->where('user_id', $user_id->id)
            ->whereNull('deleted_at')
            ->where('draft', 1)
            ->whereDate('created_at', '>', Carbon::now()->subDays(38)->toDateString())
            ->get();

        if ($entertainments->isNotEmpty()) {
            foreach ($entertainments as $post) {
                $post->category_id = 741;
            }
        }

        $combinedPosts = $blogs->merge($entertainments)->merge($business);

        $combinedPosts = $combinedPosts->sortByDesc(function ($post) {
            return $post->created_at ?? $post->created;
        });
    
        // dd($combinedPosts);
        // $allreview = collect();
    
        // if ($combinedPosts->isNotEmpty()) {
        //     $shopping = Blogs::whereIn('id', function ($query) {
        //         $query->select('blog_id')
        //             ->from('blog_category_relation')
        //             ->where('category_id', 6);
        //     })
        //     ->where('status', 1)
        //     ->whereNull('deleted_at')
        //     ->where('draft', 1)
        //     ->get();

        //     $productIds = $combinedPosts->pluck('id')->merge($shopping->pluck('id'))->unique();

        //     $allreview = ProductReview::whereIn('product_id', $productIds)
        //         ->where('type', 'shopping')
        //         ->get();
        // }

        //     $existingRecord = DB::table('saved_post')->get();
        return view('frontend.latest_post.latest_post', [
            'posts' => $combinedPosts
        ]);
    }
    

    public function latestStatusClick(Request $request)
    {
        $userId = $request->input('id');

        $updateStatus = Latest_post::where('user_id', $userId)->where('to_id', UserAuth::getLoginId())->update(['status' => '0']);

        if ($updateStatus) {
            return response()->json(['success' => true, 'message' => 'Status updated to 0.']);
        } else {
            return response()->json(['success' => false, 'message' => 'No status update occurred.']);
        }
    }
    

    public function business_Featured_post()
    {
        $businessFeaturedPost = BlogCategoryRelation::join('businesses', function($join) {
                $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                    ->on('businesses.sub_category', '=', 'blog_category_relation.sub_category_id');
            })
            ->where('businesses.status', 1)
            ->where('businesses.featured', 'on')
            ->whereNull('businesses.deleted_at')
            ->where('businesses.draft', '1')
            ->groupBy('businesses.id') 
            ->orderByRaw("CASE 
                WHEN businesses.featured = 'on' THEN 1 
                WHEN businesses.bumpPost = 1 THEN 2 
                ELSE 3 
            END, businesses.id DESC")
            ->get();
    
        $view = view('frontend.businessFeaturedPost', ['businessFeaturedPost' => $businessFeaturedPost])->render();
    
        return response()->json(['html' => $view]);
    }
    


    public function job_Featured_post()
    {
        $jobfeaturedPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', 'on')
            ->where('blogs.deleted_at', null)
            ->where('blogs.draft', 1)
            ->where('blog_category_relation.category_id', '=', 2) // Add this condition
            ->groupBy('blogs.id') // Add groupBy() method
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        // dd($jobfeaturedPost);
        $view = view('frontend.jobFeaturedPost', ['jobfeaturedPost' => $jobfeaturedPost])->render();

        return response()->json(['html' => $view]);
    }

    public function realEstate_Featured_post()
    {
        $realfeaturedPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', 'on')
            ->where('blogs.deleted_at', null)
            ->where('blog_category_relation.category_id', '=', 4) // Add this condition
            ->groupBy('blogs.id') // Add groupBy() method
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        // dd($realfeaturedPost);
        $view = view('frontend.realestateFeaturedPost', ['realfeaturedPost' => $realfeaturedPost])->render();

        return response()->json(['html' => $view]);
    }

    public function community_Featured_post()
    {
        $communityfeaturedPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', 'on')
            ->where('blogs.deleted_at', null)
            ->where('blog_category_relation.category_id', '=', 5) // Add this condition
            ->groupBy('blogs.id') // Add groupBy() method
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        // dd($realfeaturedPost);
        $view = view('frontend.communityFeaturedPost', ['communityfeaturedPost' => $communityfeaturedPost])->render();

        return response()->json(['html' => $view]);
    }


    public function Service_Featured_post()
    {
        $servicefeaturedPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', 'on')
            ->where('blogs.deleted_at', null)
            ->where('blogs.draft', 1)
            ->where('blog_category_relation.category_id', '=', 705) // Add this condition
            ->groupBy('blogs.id')
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();    
         // dd($realfeaturedPost);
        $view = view('frontend.serviceFeaturedPost', ['servicefeaturedPost' => $servicefeaturedPost])->render();

        return response()->json(['html' => $view]);
    }

    public function fundraiser_Featured_post()
    {
        $fundraiserFeaturedPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', 'on')
            ->where('blogs.deleted_at', null)
            ->where('blogs.draft', 1)
            ->where('blog_category_relation.category_id', '=', 7)
            ->groupBy('blogs.id')
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        $view = view('frontend.fundraiserFeaturedPost', ['fundraiserFeaturedPost' => $fundraiserFeaturedPost])->render();

        return response()->json(['html' => $view]);
    }

    public function Entertainment_Featured_post()
    {
       $EntertainmentfeaturedPost = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                     ->on('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id');
            })
            ->where('Entertainment.status', 1)
            ->where('Entertainment.featured_post', 'on')
            ->whereNull('Entertainment.deleted_at')
            ->where('Entertainment.draft', 1)
            ->orderByRaw("CASE 
                WHEN Entertainment.featured_post = 'on' THEN 1 
                WHEN Entertainment.bumpPost = 1 THEN 2 
                ELSE 3 
            END, Entertainment.id DESC")
            ->get();

        // dd($EntertainmentfeaturedPost);
        $view = view('frontend.entertainmentFeaturedPost', ['EntertainmentfeaturedPost' => $EntertainmentfeaturedPost])->render();

        return response()->json(['html' => $view]);
    }

    public function shop_post_data_request()
    {
        $shopping = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.featured_post', '=', 'on')
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('b2.id', 'b2.title', 'b2.slug', 'b2.image1', 'b2.product_price', 'b2.product_sale_price')
            ->orderBy('blogs.id', 'desc')
            ->limit(23)
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
    
        $existingRecord = DB::table('saved_post')->get();
    
        // Fetch reviews for all products
        $productIds = $shopping->pluck('id'); // Collect all product IDs from the shopping data
        $allreview = ProductReview::whereIn('product_id', $productIds)->where('type', 'shopping')->get();
    
        // Load the view and pass the data to it
        $view = view('frontend.shopPostAjax', ['shopping' => $shopping, 'existingRecord' => $existingRecord, 'allreview' => $allreview])->render();
    
        return response()->json(['html' => $view]);
    }    

    public function latest_post_data_request()
    {


        $Latest_posts = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->orderBy('blogs.id', 'desc')
            ->limit(12)
            ->groupBy('blogs.id') // Add groupBy() method
            ->get();
        $existingRecord = DB::table('saved_post')->get();

        // Load the view and pass the data to it
        $view = view('frontend.latestPostAjax', ['Latest_posts' => $Latest_posts, 'existingRecord' => $existingRecord])->render();

        return response()->json(['html' => $view]);
    }




public function search(Request $request)
{
    $blog_categories_search = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();

    $main_category_id = $request->input('searcjobParent');
    $sub_category_id = $request->input('searcjobChild');
    $location_search = $request->input('location');


    $locations = null;
    $allreview = null;
    $category_name = '';

    // Fetch main category and sub category details
    $main_category = BlogCategories::find($main_category_id);

    // Set category name
    if ($main_category) {
        $category_name = $main_category->title;
    }

    // If only main category is selected
    if ($main_category_id && !$sub_category_id && !$location_search) {

        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')->orderByRaw("CASE 
                    WHEN featured = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::whereIn('blogs.id', function ($query) use ($main_category_id) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', $main_category_id)
                ->groupBy('blogs.id');
        })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost','b2.available_now')
            ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
            ->get();
                
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)->whereNull('deleted_at')->orderByRaw("CASE 
                    WHEN blog_post.featured_post = 'on' THEN 1 
                    WHEN blog_post.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blog_post.id DESC")->get();

        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)->orderByRaw("CASE 
                        WHEN Entertainment.featured_post = 'on' THEN 1 
                        WHEN Entertainment.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, Entertainment.id DESC")->get();
        }
    }

    // If both main and sub category are selected
    if ($main_category_id && $sub_category_id && !$location_search) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blogs.sub_category', $sub_category_id)
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->where('sub_category', $sub_category_id)
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    }

    // If main category is selected & filter by location
    if ($main_category_id && $location_search && !$sub_category_id) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', $main_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")
                ->get();
        }
    }

    // If both main and sub category are selected & filter by location
    if ($main_category_id && $sub_category_id && $location_search) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blogs.sub_category', $sub_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('sub_category', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    }

    // If no category is selected, filter only by location
    if (!$main_category_id && !$sub_category_id && $location_search) {
        $business = Business::where('status', 1)->whereNull('deleted_at')
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
            END, id DESC")
            ->get();

        $blogs = Blogs::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->groupBy('id')
            ->get();

        $blogPosts = BlogPost::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured_post = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
                END, id DESC")
            ->get();

        $entertainmentPosts = Entertainment::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured_post = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
                END, id DESC")
            ->get();

        // Merge results
        $locations = $business->merge($blogs)->merge($blogPosts)->merge($entertainmentPosts);
    }

    if ($locations) {
    
        $shopping = Blogs::whereIn('id', function ($query) {
            $query->select('blog_id')
                ->from('blog_category_relation')
                ->where('category_id', 6);
        })
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->where('draft', 1)
            ->get();

        $productIds = $locations->pluck('id')->merge($shopping->pluck('id'))->unique(); 

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();
    }

    // dd($locations);
    // Render the view with the filtered posts
    return view("frontend.searchPosts", compact('blog_categories_search', 'locations', 'category_name', 'main_category_id', 'sub_category_id', 'allreview'));
}

public function search_posts(Request $request)
{
    $blog_categories_search = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();

    $main_category_id = $request->input('searcjobParent');
    $sub_category_id = $request->input('searcjobChild');
    $location_search = $request->input('location');

    $locations = null;
    $allreview = null;
    $category_name = '';

    // Fetch main category and sub category details
    $main_category = BlogCategories::find($main_category_id);

    // Set category name
    if ($main_category) {
        $category_name = $main_category->title;
    }

    // If only main category is selected
    if ($main_category_id && !$sub_category_id && !$location_search) {

        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')->orderByRaw("CASE 
                    WHEN featured = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::whereIn('blogs.id', function ($query) use ($main_category_id) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', $main_category_id)
                ->groupBy('blogs.id');
        })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost','b2.available_now')
            ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
            ->get();
                
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)->whereNull('deleted_at')->orderByRaw("CASE 
                    WHEN blog_post.featured_post = 'on' THEN 1 
                    WHEN blog_post.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blog_post.id DESC")->get();

        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)->orderByRaw("CASE 
                        WHEN Entertainment.featured_post = 'on' THEN 1 
                        WHEN Entertainment.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, Entertainment.id DESC")->get();
        }
    }

    // If both main and sub category are selected
    if ($main_category_id && $sub_category_id && !$location_search) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blogs.sub_category', $sub_category_id)
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('sub_category', $sub_category_id)
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    }

    // If main category is selected & filter by location
    if ($main_category_id && $location_search && !$sub_category_id) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', $main_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")
                ->get();
        }
    }

    // If both main and sub category are selected & filter by location
    if ($main_category_id && $sub_category_id && $location_search) {
        if ($main_category_id == 1) {
            $locations = Business::where('status', 1)->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                // ->where('blogs.draft', 1)
                ->where('blogs.sub_category', $sub_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->get();
        } elseif ($main_category_id == 728) {
            $locations = BlogPost::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $locations = Entertainment::where('status', 1)
                // ->where('draft', 1)
                ->whereNull('deleted_at')
                ->where('sub_category', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    }

    // If no category is selected, filter only by location
    if (!$main_category_id && !$sub_category_id && $location_search) {
        $business = Business::where('status', 1)->whereNull('deleted_at')
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
            END, id DESC")
            ->get();

        $blogs = Blogs::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->groupBy('id')
            ->get();

        $blogPosts = BlogPost::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured_post = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
                END, id DESC")
            ->get();

        $entertainmentPosts = Entertainment::where('status', 1)
            ->whereNull('deleted_at')
            // ->where('draft', 1)
            ->where('location', 'like', '%' . $location_search . '%')
            ->distinct()
            ->orderByRaw("CASE 
                WHEN featured_post = 'on' THEN 1 
                WHEN bumpPost = 1 THEN 2 
                ELSE 3 
                END, id DESC")
            ->get();

        // Merge results
        $locations = $business->merge($blogs)->merge($blogPosts)->merge($entertainmentPosts);
    }
    if ($locations->isNotEmpty()) {
    
        $shopping = Blogs::whereIn('id', function ($query) {
            $query->select('blog_id')
                ->from('blog_category_relation')
                ->where('category_id', 6);
        })
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->where('draft', 1)
            ->get();

        $productIds = $locations->pluck('id')->merge($shopping->pluck('id'))->unique(); 

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();
    }

        $viewContent = view('frontend.allSearches', [
        'blog_categories_search' => $blog_categories_search,
        'locations' => $locations,
        'category_name' => $category_name,
        'allreview' => $allreview,
    ])->render();
    
    return response()->json(['html' => $viewContent]);

}

    // public function search_popular(Request $request)

    //      $blog_categories_search = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();


    //     dd($blog_categories_search);
    //     return back();
    // }


    public function search_popular(Request $request)
    {
        // dd($request->all());
        $blog_categories_search = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();

        if ($request->isMethod('post')) {
            $searchCategoryId = $request->input('searcjobParent');
            $searchSubCategoryId = $request->input('searcjobChild');
            $location = $request->input('location');

            $getCategoryLabel = BlogCategories::where('id', '=', $searchCategoryId)->pluck('title')->first();
            $getCategoryChildLabel = BlogCategories::where('id', '=', $searchSubCategoryId)->pluck('title')->first();

            if ($request->input('searcjobChild') == 'Sub Category') {
                $matchingRecords = BlogCategoryRelation::where('category_id', $searchCategoryId)
                    ->join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
                    ->join('users', 'users.id', '=', 'blogs.user_id')
                    ->leftJoin('post_payments', 'post_payments.post_id', '=', 'blogs.id')
                    ->where('blogs.status', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.location', $location)
                    ->groupBy('blog_category_relation.blog_id')
                    ->distinct()
                    ->orderByRaw("CASE 
                                WHEN blogs.featured_post = 'on' THEN 0 
                                WHEN blogs.bumpPost = 1 THEN 1 
                                ELSE 2 
                            END, blogs.id DESC")
                    ->select('blogs.*', 'users.first_name', 'users.image', 'post_payments.payment_id', 'post_payments.duration', 'post_payments.start_date', 'post_payments.end_date')
                    ->get();
            } else {
                $matchingRecords = BlogCategoryRelation::where('sub_category_id', $searchSubCategoryId)
                    ->join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
                    ->join('users', 'users.id', '=', 'blogs.user_id')
                    ->leftJoin('post_payments', 'post_payments.post_id', '=', 'blogs.id')
                    ->where('blogs.status', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.location', $location)
                    ->groupBy('blog_category_relation.blog_id', 'blog_category_relation.category_id')
                    ->distinct()
                    ->orderByRaw("CASE 
                                WHEN blogs.featured_post = 'on' THEN 0 
                                WHEN blogs.bumpPost = 1 THEN 1 
                                ELSE 2 
                            END, blogs.id DESC")
                    ->select('blogs.*', 'users.first_name', 'users.image', 'post_payments.payment_id', 'post_payments.duration', 'post_payments.start_date', 'post_payments.end_date', 'blog_category_relation.category_id', 'users.bumpPost_end_date', 'users.feature_end_date')
                    ->get();
            }

            // foreach ($matchingRecords as $record) {
            //     $currentDayTime = now(); // Use Laravel's now() helper function
            //     if ($currentDayTime >= $record->bumpPost_end_date) {
            //         DB::table('blogs')
            //             ->where('id', $record->id)
            //             ->limit(1)
            //             ->update(['bumpPost' => null]);
            //     }
            // }

            $existingRecord = DB::table('saved_post')->get();

            $view = view("frontend.userSearchPopular", compact('blog_categories_search','matchingRecords', 'existingRecord','getCategoryLabel','getCategoryChildLabel'))->render();

            return response()->json(['html_content' => $view]);
        } else {
            return response()->json(['error' => 'No data found.']);
        }
    }


    public function getLocationSearch(Request $request)
    {
        // dd($request->all());
        $main_category_id = $request->input('searcjobParent');
        $sub_category_id = $request->input('searcjobChild');
        $location_search = $request->input('location');
        $locations = null;
        $category_name = '';
    
        // dd($main_category_id, $sub_category_id, $location_search);
        // Fetch main category and sub category details
        $main_category = BlogCategories::find($main_category_id);
    
        // Set category name
        if ($main_category) {
            $category_name = $main_category->title;
        }
    
        // If only main category is selected
        if ($main_category_id && !$sub_category_id && !$location_search) {
    
            if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
                $locations = Blogs::whereIn('blogs.id', function ($query) use ($main_category_id) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', '=', $main_category_id)
                    ->groupBy('blogs.id');
            })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost','b2.available_now')
                ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
                ->get();
                    
            } elseif ($main_category_id == 728) {
                $locations = BlogPost::where('status', 1)->where('posted_by', 'user')->orderByRaw("CASE 
                        WHEN blog_post.featured_post = 'on' THEN 1 
                        WHEN blog_post.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blog_post.id DESC")->get();
    
            } elseif ($main_category_id == 741) {
                $locations = Entertainment::where('status', 1)->orderByRaw("CASE 
                            WHEN Entertainment.featured_post = 'on' THEN 1 
                            WHEN Entertainment.bumpPost = 1 THEN 2 
                            ELSE 3 
                        END, Entertainment.id DESC")->get();
            }
        }
    
        // If both main and sub category are selected
        if ($main_category_id && $sub_category_id && !$location_search) {
            if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
                $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    // ->where('blogs.draft', 1)
                    ->where('blogs.sub_category', $sub_category_id)
                    ->distinct()
                    ->groupBy('blogs.id')
                    ->get();
            } elseif ($main_category_id == 728) {
                $locations = BlogPost::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('subcategory', $sub_category_id)
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                        END, id DESC")
                    ->get();
            } elseif ($main_category_id == 741) {
                $locations = Entertainment::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                        END, id DESC")
                    ->get();
            }
        }
    
        // If main category is selected & filter by location
        if ($main_category_id && $location_search && !$sub_category_id) {
            if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
                $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    // ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $main_category_id)
                    ->where('blogs.location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->groupBy('blogs.id')
                    ->get();
            } elseif ($main_category_id == 728) {
                $locations = BlogPost::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                        END, id DESC")
                    ->get();
            } elseif ($main_category_id == 741) {
                $locations = Entertainment::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, id DESC")
                    ->get();
            }
        }
    
        // If both main and sub category are selected & filter by location
        if ($main_category_id && $sub_category_id && $location_search) {
            if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
                $locations = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    // ->where('blogs.draft', 1)
                    ->where('blogs.sub_category', $sub_category_id)
                    ->where('blogs.location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->groupBy('blogs.id')
                    ->get();
            } elseif ($main_category_id == 728) {
                $locations = BlogPost::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('subcategory', $sub_category_id)
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                        END, id DESC")
                    ->get();
            } elseif ($main_category_id == 741) {
                $locations = Entertainment::where('status', 1)
                    // ->where('draft', 1)
                    ->whereNull('deleted_at')
                    ->where('sub_category', $sub_category_id)
                    ->where('location', 'like', '%' . $location_search . '%')
                    ->distinct()
                    ->orderByRaw("CASE 
                        WHEN featured_post = 'on' THEN 1 
                        WHEN bumpPost = 1 THEN 2 
                        ELSE 3 
                        END, id DESC")
                    ->get();
            }
        }
    
        // If no category is selected, filter only by location
        if (!$main_category_id && !$sub_category_id && $location_search) {
            $blogs = Blogs::where('status', 1)
                ->whereNull('deleted_at')
                // ->where('draft', 1)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('id')
                ->get();
    
            $blogPosts = BlogPost::where('status', 1)
                ->whereNull('deleted_at')
                // ->where('draft', 1)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
    
            $entertainmentPosts = Entertainment::where('status', 1)
                ->whereNull('deleted_at')
                // ->where('draft', 1)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
    
            // Merge results
            $locations = $blogs->merge($blogPosts)->merge($entertainmentPosts);
        }
    
        // dd($locations);
        // Render the view with the filtered posts
        $html = view('frontend.featured_view.allFeatured', [
            'locations' => $locations,
            'category_name' => $category_name,
        ])->render();
    
        return response()->json(['html' => $html]);
    }

    // public  function getLocation(Request $request)
    // {
    //     $apiKey = 'AIzaSyDg_m6sDuOWlAi5u952Ct0gwFlqz6qF3Zg';
    //     $address = $request->address;
    //     $client = new Client();
    //     // dd($apiKey);
    //     $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey");
    //     $locationData = json_decode($response->getBody(), true);
    //     // dd( $locationData);
    //     if ($locationData['status'] === 'OK') {
    //         $location = $locationData['results'][0]['geometry']['location'];
    //         return response()->json(['location' => $location], 200);
    //     } else {
    //         return response()->json(['error' => 'Unable to fetch location.'], 400);
    //     }
    // }

    // public  function getPlaces(Request $request)
    // {
    //     $apiKey = 'AIzaSyDg_m6sDuOWlAi5u952Ct0gwFlqz6qF3Zg';
    //     $query = $request->address;
    //     $client = new Client();

    //     $response = $client->get("https://maps.googleapis.com/maps/api/place/textsearch/json?query=$query&key=$apiKey");
    //     $placesData = json_decode($response->getBody(), true);

    //     if ($placesData['status'] === 'OK') {
    //         $places = $placesData['results'];
    //         return response()->json(['places' => $places], 200);
    //     } else {
    //         return response()->json(['error' => 'Unable to fetch places.'], 400);
    //     }
    // }

    public function getCurrentLocation(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $apiKey = ''; // You can leave this empty for ip-api, as it's a free service

        $client = new Client();
        $response = $client->get("http://ip-api.com/json/{$ip}");

        $data = json_decode($response->getBody(), true);

        if ($data['status'] === 'success') {
            $latitude = $data['lat'];
            $longitude = $data['lon'];
            $client = new Client();
            $apiKey = 'AIzaSyDg_m6sDuOWlAi5u952Ct0gwFlqz6qF3Zg';


            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'latlng' => $latitude . ',' . $longitude,
                    'key' => $apiKey,
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200 && isset($data['results'][0]['formatted_address'])) {
                $fullAddress = $data['results'][0]['formatted_address'];
                return response()->json(['address' => $fullAddress]);
            } else {
                return response()->json(['error' => 'Unable to fetch address.'], 500);
            }
        } else {
            return response()->json(['error' => 'Unable to retrieve location.']);
        }
    }


    //  public function getCurrentLocation()
    // {
    //     $ip = $_SERVER['REMOTE_ADDR'];
    //     $apiKey = ''; // You can leave this empty for ip-api, as it's a free service

    //     $client = new Client();
    //     $response = $client->get("http://ip-api.com/json/{$ip}");

    //     $data = json_decode($response->getBody(), true);

    //     if ($data['status'] === 'success') {
    //         $latitude = $data['lat'];
    //         $longitude = $data['lon'];

    //         return response()->json([
    //             'latitude' => $latitude,
    //             'longitude' => $longitude
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Unable to retrieve location.'], 500);
    //     }
    // } 


    public function autocomplete(Request $request)
    {
        $apiKey = 'AIzaSyBsuev6wx4QxC726KaxIxHY7r75C-Qn08s';
        $query = $request->address;
        $client = new Client();

        $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json?query=$query&key=$apiKey', [
            'query' => [
                'input' => $query,
                'key' => $apiKey,
            ],
        ]);

        $places = json_decode($response->getBody(), true);

        return response()->json($places);
    }

    // function services(Request $request, $slug)
    // {
    //     $ids = HomeSettings::get('testimonial_ids');
    //     $ids = $ids ? explode(',', $ids) : [-1];
    //     $testimonials = Testimonials::where('status', 1)->whereIn('id', $ids)->orderBy('id', 'desc')->get();
    //     $page = OurServices::getRow([
    //         'our_services.slug LIKE ?' => [$slug]
    //     ]);
    //     return view(
    //         "frontend.services",
    //         [
    //             'testimonials' => $testimonials,
    //             'page' => $page
    //         ]
    //     );
    // }

    function contactUs(Request $request)
    {
        $data = $request->toArray();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
                'phone' => 'required',
                'message' => 'required',
                'g-recaptcha-response' => 'required|captcha',
                'email' => [
                    'required',
                    'email'
                ]
            ]
        );

        if (!$validator->fails()) {
            $codes = [
                '{name}' => $data['name'],
                '{email}' => $data['email'],
                '{mobile}' => $data['phone'],
                '{message}' => $data['message']
            ];

            General::sendTemplateEmail(
                // Settings::get('admin_notification_email'),
                'wasim.grintech@yopmail.com',
                'contact-request-admin',
                $codes
            );

            $request->session()->flash('success', 'Request submited. We will get right back to you.');
            return redirect()->route('homepage.index', ['#contact-us']);
        } else {
            $request->session()->flash('error', 'Please fill in all mandatory fields.');
            return redirect()->route('homepage.index', ['#contact-us'])->withErrors($validator)->withInput();
        }
    }

    function termsCondition(Request $request)
    {
        return view(
            "frontend.pages.termscondition",
            [
                'title' => 'Terms & Conditions',
                'description' => ''
            ]
        );
    }

    function aboutUs(Request $request)
    {
        $setting = Settings::all();
        $blog_post = DB::table('blog_post')->where('posted_by', 'admin')->where('status', 1)->limit(8)->get();
        $video = DB::table('videos')->where('video_by', 'admin')->where('status', 1)->limit(6)->orderBy('id', 'desc')->get();

        $metaData = [
            'title' => 'About FindersPage | A self service website by Brenda Pond',
            'description' => 'About FindersPage, founded by Brenda Pond. FindersPage is a world wide dynamic community platform where individuals and brands network and market their distinctiveness.',
            'keywords' => 'Best Shopping platform, Resume Listing, Top Models in USA, Entertainment job listing, Video streaming websites or platform, video streaming, property listing'
        ];

        return view(
            "frontend.pages.about",
            [
                'setting' => $setting,
                'blog_post' => $blog_post,
                'video' => $video,
                'metaData' => $metaData
            ]
        );
    }

    function privacyPolicy(Request $request)
    {
        return view('frontend.privacypolicy.privacypolicy');
        // return view(
        //     "frontend.page",
        //     [
        //         'title' => 'Privacy Policy',
        //         'page_title' => HomeSettings::get('privacy_title'),
        //         'description' => HomeSettings::get('privacy_description')
        //     ]
        // );
    }

    function HomeNewslatter(Request $request)

    {
        // dd($request->email);

        $data = $request->toArray();

        // echo"<pre>";print_r($data);die('wait');
        unset($data['_token']);
        // echo"<pre>";print_r($data);die('wait');
        $newsletter = Newsletter::home_create($data);

        if ($newsletter) {

            $codes = [
                '{email}' => $request->email,
            ];

            General::sendTemplateEmail(
                $request->email,
                'newsletter',
                $codes
            );

            $request->session()->flash('success', 'Successfully subscribed to the newsletter.');

            return redirect()->back()->with(['newslater_success' => 'Successfully succribed ...!']);
        } else {

            $request->session()->flash('error', 'Newsletter could not be save. Please try again.');

            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function select_rule()
    {
        return view('frontend.selectpage.selectpage');
    }



    public function scams()
    {
        return view('frontend.scams.scams');
    }

    public function cart()
    {
        if (isset($_COOKIE['cart_product_ids'])) {
            $cartCount = $_COOKIE['cart_product_ids'];
            $cartItems = explode('|', $cartCount);
            $count = count($cartItems);

            $blogIds = $cartItems; // An array of specific blog IDs you want to include

            $shopping = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->groupBy('blogs.id');
            })
                ->whereIn('blogs.id', $blogIds) // Add the condition to include specific blog IDs
                ->orderBy('blogs.id', 'desc')
                ->limit(8)
                ->get();
        } else {
            $shopping = array();
            $count = 0;
        }

        return view(
            "frontend.cart",
            [
                'shoppingItems' => $shopping,
                'count' => $count
            ]
        );
    }

    public function FAQ()
    {

        $metaData = [
            'title' => 'FindersPage FAQs: Quick Answers for Easy Navigation',
            'description' => 'Explore the FindersPage FAQ section for quick and helpful answers. Navigate effortlessly through commonly asked questions to enhance your user experience.',
            'keywords' => 'FindersPage FAQ'
        ];


        return view('frontend.faq.faq', compact('metaData'));
    }


    public function contact()
    {
        return view('frontend.pages.contactUS');
    }

    public function showCheckoutPage(Request $request ,$post_id)
    {
        $blog_id = General::decrypt($post_id);
        // dd($blog_id);

        return view('frontend.checkout', [
            'blog_id' => $blog_id,
        ]);
    }
    public function commingSoon_bussiness()
    {
        return view('frontend.dashboard_pages.commingsoon');
    }


    public function showThankYouPage()
    {

        return view('frontend.thankyou');
    }


    // public function edit_feature_post(Request $request , $id){
    //    $blog = Blogs::where('featured_post', 'on')->where('status', "1")->get();
    //     return view('frontend.jobpost.jobpost_single' compact('blog'));
    // }

    public function comingSoonPage()
    {
        return view('frontend.comingSoon');
    }

    public function hiring()
    {
        return view('frontend.pages.hiring');
    }

    public function privacyActivity()
    {
        return view('frontend.activity.privacyActivity');
    }

    public function paymentUpdateUser(Request $request)
    {


        $pay_update = DB::table('users')
            ->where('id', $request->id)
            ->limit(1)
            ->update(['payment_type' => $request->paymentType]);
        if ($pay_update) {
            return response()->json(['success' => 'payment type updated.']);
        } else {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }
    
}
