<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\BlogCategories;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\Blogs;
use App\Models\Like;
use App\Models\Admin\Users;
use App\Models\Admin\Admins;
use App\Models\UserAuth;
use App\Models\BlogComments;
use App\Models\shopQuestion;
use App\Models\ShopAnswer;
use App\Models\Video;
use App\Models\Entertainment;
use App\Models\BlogPost;
use App\Models\Business;
use App\Models\BlogsViews;
use App\Models\ListingViews;
use App\Models\ProductReview;
use App\Models\Admin\Follow;
use App\Jobs\TurnOffAvailableNow;
use App\Models\Admin\Notification;
use App\Libraries\General;
use DB;


class JobpostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
        if(empty($blog)){
            abort(404);
        }
         // dd($blog);
        $id = $blog->id;
        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 2);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('slug')
            ->first();
        // Get the next post ID
        $nextPostId = Blogs::where('id', '>', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 2);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('slug')
            ->first();
        $users = Users::all();
        $admins = Admins::all();
        $viewsCount = ListingViews::where('post_id' , $id)->count();
        $shareComponent = \Share::page(
            'https://www.finderspage.com/job-post/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];
        // dd($admins);
        $existingRecord = DB::table('saved_post')
            ->where('user_id', UserAuth::getLoginId())
            ->where('post_id', $id)
            ->where('post_type', 'Jobs')
            ->exists();
        $relatedjob = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();

        $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
        ->where('likes.blog_id',$id)
        ->select('likes.*')
        ->where('likes.type', 'Jobs')
        ->get();
        // dd($BlogLikes);
        return view('frontend.jobpost.jobpost_single', compact('blog', 'users', 'admins','relatedjob', 'existingRecord', 'previousPostId', 'nextPostId', 'shareComponent','viewsCount','ogmetaData', 'BlogLikes'));
    }


    public function userSearchPage()
    {
        return view('frontend.usersearch.usersearch');
    }


    public function user_Search_result(Request $request)
    {

        $user = users::where(function ($query) use ($request) {
            $query->where('username', 'like', '%' . $request->user_name . '%');
            // ->orWhere('first_name', 'like', '%' . $request->user_name . '%');
        })->get();
        // dd($user);
        $view = view('frontend.usersearchresult', ['user' => $user])->render();

        return response()->json(['html' => $view]);
        // dd($user);
    }


    public function user_Search_result_home(Request $request)
    {
        // $users = users::where('username', 'like', '%' . $request->user_name . '%')->get();
        // $blogPost = BlogPost::where('title', 'like', '%' . $request->user_name . '%')->orWhere('location', 'like', '%' . $request->location . '%')->get();
        // $video = Video::where('title', 'like', '%' . $request->user_name . '%')->orWhere('location', 'like', '%' . $request->location . '%')->get();
        // $entertainment = Entertainment::where('Title', 'like', '%' . $request->user_name . '%')->orWhere('location', 'like', '%' . $request->location . '%')->get();

        // $posts = Blogs::where('blogs.status', '=', '1')
        //     ->whereNull('blogs.deleted_at')
        //     ->where('blogs.title', 'like', '%' . $request->user_name . '%')
        //     ->orwhere('blogs.location', 'like', '%' . $request->location . '%')
        //     ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        //     ->groupBy('blogs.id')
        //     ->select('blogs.id', 'blogs.image1', 'blogs.slug', 'blogs.title', 'blog_category_relation.category_id')
        //     ->get();
            

        $userName = $request->input('user_name', '');
        // $location = $request->input('location', '');
    
        $users = Users::where('first_name', 'like', '%' . $userName . '%')
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

            
        $view = view('frontend.userSearchHome', [
            'users' => $users,
            'blogPost' => $blogPosts,
            'video' => $videos,
            'entertainment' => $entertainments,
            'blogs' => $blogs,
            'business' => $business,
        ])->render();

        return response()->json(['html' => $view]);
    }


    public function listingPage()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.featured_post', '=', 'on')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', 2) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();
        $existingRecord = DB::table('saved_post')->get();

        $metaData = [
            'title' => 'Latest Jobs in USA - Full-Time and Part-Time Jobs on FindersPage',
            'description' => 'Exciting Opportunities Await! Explore Full-Time and Part-Time Jobs on FindersPage. Discover your next career move with flexible employment options that fit your lifestyle.',
            'keywords' => 'jobs listing, Job opening, Entertainment job listing, job openings near me part time, job opening sites, job opening websites, job opening near me, variety job listings, entertainment job boards'
        ];

        return view('frontend.jobpost.joblisting', compact('matchingRecords','existingRecord', 'metaData'));
    }



    public function fundraiser_listing()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', 7) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();

        // dd($matchingRecords);

        
        $existingRecord = DB::table('saved_post')->get();

        $metaData = [
            'title' => 'Latest Jobs in USA - Full-Time and Part-Time Jobs on FindersPage',
            'description' => 'Exciting Opportunities Await! Explore Full-Time and Part-Time Jobs on FindersPage. Discover your next career move with flexible employment options that fit your lifestyle.',
            'keywords' => 'jobs listing, Job opening, Entertainment job listing, job openings near me part time, job opening sites, job opening websites, job opening near me, variety job listings, entertainment job boards'
        ];

        return view('frontend.fundraiser.fundraiser_listing', compact('matchingRecords','existingRecord', 'metaData'));
    }
    
    public function fundraiser_single_listing($slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
        if(empty($blog)){
            abort(404);
        }
         // dd($blog);
        $id = $blog->id;
        $currentUserId = UserAuth::getLoginId();
        // $roleArray = UserAuth::getUserRole($currentUserId); 
        // $role = $roleArray['role'];
        // dd($role);

        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 7);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('slug')
            ->first();
        // Get the next post ID
        $nextPostId = Blogs::where('id', '>', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 7);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('slug')
            ->first();
        $users = Users::all();
        $admins = Admins::all();
        $viewsCount = ListingViews::where('post_id' , $id)->count();
        $shareComponent = \Share::page(
            'https://www.finderspage.com/job-post/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];

        $hiddenComments = BlogComments::where('blog_id', $blog->id)->whereNull('deleted_at')->where('status', 0)->where('com_id',null)->where('type','fundraiser')->get();

        // $BlogComments = BlogComments::where('blog_id', $blog->id)->whereNull('deleted_at')->where('com_id',null)->where('type','fundraiser')->get();
        // $BlogCommentsReply = BlogComments::where('blog_id', $blog->id)->whereNull('deleted_at')->whereNotNull('com_id')->get();

        $BlogComments = BlogComments::where('blog_id', $blog->id)
            ->whereNull('deleted_at')
            ->where('com_id', null)
            ->where('type', 'fundraiser');
        
        // Check if the logged-in user is the blog owner
        if (UserAuth::getLoginId() == $blog->user_id) {
            // No additional status condition needed for blog owner
        } else {
            // Apply status condition for non-owners
            $BlogComments->where('status', 1);
        }
        
        // Sort by 'pin' status first, then by 'pin_created_at'
        $BlogComments = $BlogComments->orderBy('pin', 'desc') // Show pinned comments first
            ->orderBy('pin_created_at', 'asc') // Then show other comments by created date
            ->get();

        $BlogCommentsReply = BlogComments::where('blog_id', $blog->id)->whereNull('deleted_at')->where('status', 1)->whereNotNull('com_id')->get();

        
        $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
                ->where('likes.blog_id',$blog->id)
                ->select('likes.*')
                ->where('likes.type', 'Fundraisers')
                ->get();

            $existingRecord = DB::table('saved_post')
                ->where('user_id', $currentUserId)
                ->where('post_id', $id)
                ->where('post_type', 'Fundraisers')
                ->exists();

        $relatedjob = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();
        return view('frontend.fundraiser.single_listing', compact('blog', 'hiddenComments', 'BlogComments', 'BlogCommentsReply','users', 'admins','relatedjob', 'existingRecord', 'previousPostId', 'nextPostId', 'shareComponent', 'viewsCount', 'ogmetaData', 'BlogLikes'));
    }

    public function listing_realestate()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blog_category_relation.category_id', '=', 4) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->select('blogs.id','blogs.slug', 'blogs.title','blogs.available_now', 'blogs.image1','blogs.created', 'blogs.featured_post', 'blogs.bumpPost', 'users.bumpPost_end_date', 'users.feature_end_date')
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();

        foreach ($matchingRecords as $Records) {
            $currentDayTime = date('Y-m-d H:i:s');
            if ($currentDayTime >= $Records->bumpPost_end_date) {
                DB::table('blogs')
                    ->where('id', $Records->id)
                    ->limit(1)
                    ->update(['bumpPost' => 'null']);
            }
            if ($currentDayTime >= $Records->feature_end_date) {
                DB::table('blogs')
                    ->where('id', $Records->id)
                    ->limit(1)
                    ->update(['featured_post' => 'null']);
            }
        }
        $existingRecord = DB::table('saved_post')->get();
        // echo "<pre>"; print_r($matchingRecords);

        $metaData = [
            'title' => 'FindersPage USA Real Estate Listings - Apartments, Homes, Offices!',
            'description' => 'FindersPages real estate listings in the USA. Find your perfect space apartments spacious homes and commercial properties, and explore a variety of options for rent or sale. Your dream space is just a click away!',
            'keywords' => 'real estate listing, real estate listing website, real estate agents, property listing, real estate listing websites, real estate listing sites, best real estate listing websites'
        ];

        return view('frontend.realestate.realestate_listing', compact('matchingRecords', 'existingRecord', 'metaData'));
    }

    public function realestate_single($slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
        if(empty($blog) ){
            abort(404);
        }
        $id = $blog->id;
        $user = Users::where('id',$blog->user_id)->first();
        $existingRecord = DB::table('saved_post')
        ->where('user_id', UserAuth::getLoginId())
        ->where('post_id', $id)
        ->where('post_type', 'Real Estate')
        ->exists();

        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 4);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('slug')
            ->first();
            // Get the next post ID
            $nextPostId = Blogs::where('id', '>', $id)
                ->whereExists(function ($query) use ($id) {
                    $query->select('blog_category_relation.blog_id')
                        ->from('blog_category_relation')
                        ->whereRaw('blog_category_relation.blog_id = blogs.id')
                        ->where('blog_category_relation.category_id', '=', 4);
                })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('slug')
            ->first();
            $viewsCount = ListingViews::where('post_id' , $id)->count();

        $shareComponent = \Share::page(
            'https://www.finderspage.com/real_esate-post/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                 'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];
        $relatedPost = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();

        $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
        ->where('likes.blog_id',$blog->id)
        ->select('likes.*')
        ->where('likes.type', 'Real Estate')
        ->get();

        return view('frontend.realestate.realestate_single', compact('blog', 'user', 'relatedPost', 'existingRecord', 'previousPostId', 'nextPostId', 'shareComponent','viewsCount','ogmetaData' , 'BlogLikes'));
    }

    public function shopping_list()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.featured_post', '=', 'on')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1', 'b2.created', 'b2.featured_post','b2.product_price', 'b2.product_sale_price', 'b2.bumpPost','b2.available_now')
            ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
            ->get();
        $existingRecord = DB::table('saved_post')->get();

        $productIds = $matchingRecords->pluck('id');

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();

        $metaData = [
            'title' => 'FindersPage: List your Online shopping store!',
            'description' => 'Shop with FindersPage! From beauty to electronics, find everything you need in one place. Simplify your online shopping experience with our wide range of products!',
            'keywords' => 'shopping listing, Best Shopping platform, property listing, ecommerce best platforms, b2b ecommerce platform, best ecommerce website platform, commercial real estate listing'
        ];

        // dd($existingRecord);
        return view('frontend.shopping.shop_listing', compact('matchingRecords', 'existingRecord', 'metaData', 'allreview'));
    }

    public function shopping_single($slug)
    {

        $blog = Blogs::where('slug',$slug)->first();
        if(empty($blog)){
            abort(404);
        }
        $id = $blog->id;
        $users = Users::all();
        $admins = Admins::all();
        $relatedPro = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();
        $shopQuestion = shopQuestion::where('post_id', $id)->get();
        $ShopAnswer = ShopAnswer::where('post_id', $id)->get();
        $existingRecord = DB::table('saved_post')
            ->where('user_id', UserAuth::getLoginId())
            ->where('post_id', $id)
            ->where('post_type', 'Shopping')
            ->exists();
        $allreview = ProductReview::where('product_id',$id)->where('type', 'shopping')->get();
        // dd($relatedPro);
        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 6);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('slug')
            ->first();
        // Get the next post ID
        $nextPostId = Blogs::where('id', '>', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 6);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('slug')
            ->first();
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];
            $viewsCount = ListingViews::where('post_id' , $id)->count();
        //  dd($ogmetaData);

        $shareComponent = \Share::page(
            'https://www.finderspage.com/shopping-post-single/' . $slug,
            $blog->title,
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);

        $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
            ->where('likes.blog_id',$blog->id)
            ->select('likes.*')
            ->where('likes.type', 'Shopping')
            ->get();

        return view('frontend.shopping.shop_single', compact('blog', 'users', 'admins','relatedPro', 'shopQuestion', 'ShopAnswer', 'existingRecord', 'previousPostId', 'nextPostId', 'shareComponent','viewsCount','ogmetaData','allreview','BlogLikes'));
    }

    public function blogCategory($id)
    {

        $parentID = BlogCategories::where('id', '=', $id)->pluck('parent_id')->first();
        $getCategoryLabel = BlogCategories::where('id', '=', $parentID)->pluck('title')->first();
        $getCategoryChildLabel = BlogCategories::where('id', '=', $id)->pluck('title')->first();

        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) use ($id) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blog_category_relation.sub_category_id', '=', $id) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id') // Join with the 'users' table
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name') // Add the desired user fields
            ->get();

        return view(
            "frontend.blogCategoryListing",
            [
                'matchingRecords' => $matchingRecords,
                'getCategoryLabel' => $getCategoryLabel,
                'getCategoryChildLabel' => $getCategoryChildLabel,
            ]
        );
    }

    public function ourcommunity_listing()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blog_category_relation.category_id', '=', 5) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('users', 'users.id', '=', 'blogs.user_id') // Join with the 'users' table
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name') // Add the desired user fields
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();
        // dd($matchingRecords);
        $users = Users::all();
        $admins = Admins::all();
        $existingRecord = DB::table('saved_post')->get();


        $metaData = [
            'title' => 'Join the community with FindersPage',
            'description' => 'Community at Your Fingertips: Education, Relatives, Alerts, and More on FindersPage. Connect, Share, Stay Engaged',
            'keywords' => 'FindersPage FAQ'
        ];

        return view('frontend.ourcommunity.listing', compact('matchingRecords', 'users', 'admins', 'existingRecord', 'metaData'));
    }

    public function ourcommunity_single($slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
        $id = $blog->id;
        $users = Users::all();
        $admins = Admins::all();
        $related_estate = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();
        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 5);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('id')
            ->first();
        // Get the next post ID
        $nextPostId = Blogs::where('id', '>', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 5);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('id')
            ->first();
        $viewsCount = ListingViews::where('post_id' , $id)->count();
        $shareComponent = \Share::page(
            'https://www.finderspage.com/community-single-post/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                 'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];
            $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
                ->where('likes.blog_id',$blog->id)
                ->select('likes.*')
                ->where('likes.type', 'Community')
                ->get();

            $existingRecord = DB::table('saved_post')
                ->where('user_id', UserAuth::getLoginId())
                ->where('post_id', $id)
                ->where('post_type', 'Community')
                ->exists();

        return view('frontend.ourcommunity.single_listing', compact('blog', 'existingRecord', 'users', 'admins','related_estate', 'previousPostId', 'nextPostId', 'shareComponent','viewsCount','ogmetaData', 'BlogLikes'));
    }


    public function service_listing()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.featured_post', '=', 'on')
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', '=', 705) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('users', 'users.id', '=', 'blogs.user_id') // Join with the 'users' table
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name') // Add the desired user fields
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();

        $users = Users::all();
        $admins = Admins::all();
        $existingRecord = DB::table('saved_post')->get();
        $metaData = [
            'title' => 'FindersPage: Your Shortcut to USA Services Listing!',
            'description' => 'Find and connect with services listing across the USA on FindersPage. Your quick and easy way to discover the services you need',
            'keywords' => 'services listing, business listing website, business listing, listing website, jobs listing, shopping listing, Best Shopping platform, Resume Listing, real estate listing sites'
        ];

        return view('frontend.services.service_list', compact('matchingRecords', 'users', 'admins','existingRecord', 'metaData'));
    }

    public function service_single($slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
        if(empty($blog)){
            abort(404);
        }
        $id = $blog->id;
        // Get the previous post ID
        $previousPostId = Blogs::where('id', '<', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 705);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->pluck('slug')
            ->first();
        // Get the next post ID
        $nextPostId = Blogs::where('id', '>', $id)
            ->whereExists(function ($query) use ($id) {
                $query->select('blog_category_relation.blog_id')
                    ->from('blog_category_relation')
                    ->whereRaw('blog_category_relation.blog_id = blogs.id')
                    ->where('blog_category_relation.category_id', '=', 705);
            })
            ->where('status', '=', '1')
            ->where('deleted_at', null)
            ->orderBy('id', 'asc')
            ->pluck('slug')
            ->first();
        // dd($nextPostId);
        $userSlug = Users::where('id', $blog->user_id)->pluck('slug')->first();
        $users = Users::all();
        $admins = Admins::all();
        $relatedService = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();
        $viewsCount = ListingViews::where('Post_id' , $id)->where('type', 'blog')->count();
        $parentID = '705';

        $sub_cat_listing = BlogCategories::getAll(
            ['blog_categories.id', 'blog_categories.title'],
            ['blog_categories.parent_id' => $parentID],
            'blog_categories.title desc'
        );

        $shareComponent = \Share::page(
            'https://www.finderspage.com/service-single/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                 'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];

            $BlogLikes = Like::join('blogs', 'blogs.id', '=', 'likes.blog_id')
                ->where('likes.blog_id',$blog->id)
                ->select('likes.*')
                ->where('likes.type', 'Services')
                ->get();

        // dd($relatedService);
        $existingRecord = DB::table('saved_post')
            ->where('user_id', UserAuth::getLoginId())
            ->where('post_id', $id)
            ->where('post_type', 'Services')
            ->exists();
        return view('frontend.services.service_single', compact('blog','userSlug','users', 'admins','sub_cat_listing', 'relatedService', 'existingRecord', 'previousPostId', 'nextPostId', 'shareComponent','viewsCount','ogmetaData', 'BlogLikes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function businessForm()
    {
        return view('frontend.dashboard_pages.businessForm');
    }

    public function SavePostListing()
    {
        $loginUserId = UserAuth::getLoginId();
        $users = Users::all();
        $admin = Admins::all();
        $matchingRecords = DB::table('saved_post')
            ->select('saved_post.user_id', 'saved_post.post_id', 'blogs.*', 'blog_category_relation.category_id')
            ->join('blogs', 'saved_post.post_id', '=', 'blogs.id')
            ->join('blog_category_relation', 'saved_post.post_id', '=', 'blog_category_relation.blog_id')
            ->where('saved_post.user_id', $loginUserId)
            ->distinct()
            ->get();
        // dd($matchingRecords);
        return view('frontend.dashboard_pages.savePost', compact('matchingRecords', 'users', 'admin'));
    }




    public function filter(Request $request)
{
    $main_category_id = $request->input('searcjobParent');
    $sub_category_id = $request->input('searcjobChild');
    $location_search = $request->input('location');

    $matchingRecords = null;

    if ($main_category_id && !$sub_category_id && !$location_search) {

        if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) use ($main_category_id) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $main_category_id)
                    ->groupBy('blogs.id');
            })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost', 'b2.available_now')
                ->orderBy('b2.created', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
                ->get();
        } elseif ($main_category_id == 728) {
            $matchingRecords = BlogPost::where('status', 1)
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $matchingRecords = Entertainment::where('status', 1)
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")
                ->get();
        }
    } elseif ($main_category_id && $sub_category_id && !$location_search) {
        if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $matchingRecords = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                ->where('blogs.sub_category', $sub_category_id)
                ->distinct()
                ->groupBy('blogs.id')
                ->orderBy('blogs.created', 'desc') // Order by created date
                ->get();
        } elseif ($main_category_id == 728) {
            $matchingRecords = BlogPost::where('status', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->distinct()
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $matchingRecords = Entertainment::where('status', 1)
                ->whereNull('deleted_at')
                ->where('sub_category', $sub_category_id)
                ->distinct()
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    } elseif ($main_category_id && $location_search && !$sub_category_id) {
        if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $matchingRecords = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                ->where('blog_category_relation.category_id', $main_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->orderBy('blogs.created', 'desc') // Order by created date
                ->get();
        } elseif ($main_category_id == 728) {
            $matchingRecords = BlogPost::where('status', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $matchingRecords = Entertainment::where('status', 1)
                ->whereNull('deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                END, id DESC")
                ->get();
        }
    } elseif ($main_category_id && $sub_category_id && $location_search) {
        if (in_array($main_category_id, [2, 4, 5, 6, 705])) {
            $matchingRecords = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                ->where('blogs.sub_category', $sub_category_id)
                ->where('blogs.location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->groupBy('blogs.id')
                ->orderBy('blogs.created', 'desc') // Order by created date
                ->get();
        } elseif ($main_category_id == 728) {
            $matchingRecords = BlogPost::where('status', 1)
                ->whereNull('deleted_at')
                ->where('subcategory', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        } elseif ($main_category_id == 741) {
            $matchingRecords = Entertainment::where('status', 1)
                ->whereNull('deleted_at')
                ->where('sub_category', $sub_category_id)
                ->where('location', 'like', '%' . $location_search . '%')
                ->distinct()
                ->orderBy('created_at', 'desc') // Order by created date
                ->orderByRaw("CASE 
                    WHEN featured_post = 'on' THEN 1 
                    WHEN bumpPost = 1 THEN 2 
                    ELSE 3 
                    END, id DESC")
                ->get();
        }
    }

    if ($matchingRecords->isEmpty()) {
        $filterData = '<div class="col-12" style="text-align: center;">
            <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">We couldn\'t find any data, Please adjust your filter settings.</h3>
            <a href="' . url('/') . '">
                <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
            </a>
        </div>';
    } else {
        $filterData = '';
        $filterData .= view('frontend.filters.searchFilter', compact('matchingRecords'))->render();
    }

    return response()->json(['html' => $filterData]);
}



    public function fundraiser_filter(Request $request)
    {
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');
    
        $query = DB::table('blogs')
            ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->where('blogs.status', 1)
            ->whereNull('blogs.deleted_at');
    
        if ($categoryId == 7) {
            $query->whereIn('blogs.id', function ($query) {
                $query->select('blog_id')
                    ->from('blog_category_relation')
                    ->where('category_id', 7)
                    ->groupBy('blog_id');
            });
            $query->orderByRaw("CASE
                WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                ELSE 3
                END ASC, blogs.id DESC");
        } else {
            if (!empty($service_types)) {
                $query->where('sub_category', $service_types);
            }
            if (!empty($location_search)) {
                $query->where('blogs.location', 'like', '%' . $location_search . '%');
            }
        }
    
        $matchingRecords = $query->orderBy('blogs.created', 'desc')->get();
    
        if ($matchingRecords->isEmpty()) {
            $filterData = '<div class="col-12" style="text-align: center;">
                <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">We couldn\'t find any data, Please adjust your filter settings.</h3>
                <a href="' . url('/') . '">
                    <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
                </a>
            </div>';
        } else {
            $filterData = '';
            foreach ($matchingRecords as $Records) {
                $filterData .= '<div class="col-lg-3 col-md-4 col-sm-6 col-6 columnJoblistig">
                    <a href="' . route("jobpost", $Records->slug) . '">
                        <div class="feature-box">
                            <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">';
                $itemFeaturedImages = trim($Records->image1, '[""]');
                $itemFeaturedImage = explode('","', $itemFeaturedImages);
                if (is_array($itemFeaturedImage)) {
                    foreach ($itemFeaturedImage as $key => $value) {
                        $class = $key == 0 ? "active" : "in-active";
                        $filterData .= '<div class="carousel-item ' . $class . '">
                            <img src="' . asset("images_blog_img") . '/' . $value . '" alt="Image" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
                        </div>';
                    }
                }
                
                $filterData .= '</div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo-new" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo-new" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p class="job-title"><b>' . ucfirst($Records->title) . '</b></p><br>
                <div class="location-job-title">
                    <div class="job-type">
                        <ul>';
                
                $filterData .= '
                </div>
                <div class="job-type job-hp">
                    <img onerror="this.onerror=null; this.src=\'https://placehold.jp/3d4070/ffffff/150x150.png?css=%7B%22border-radius%22%3A%2250%25%22%2C%22background%22%3A%22%20-webkit-gradient(linear%2C%20left%20top%2C%20left%20bottom%2C%20from(%23666666)%2C%20to(%23cccccc))%22%7D\';" src="' . asset('images/profile/' . $Records->image) . '" alt="">
                    <p><br><small>By ' . $Records->first_name . '</small></p>                                    
                </div>
            </div>
        </a>
    </div>';
            }
        }
    
        return response()->json(['html' => $filterData]);
    }


    public function realEstate_filter(Request $request)
    {
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');

        $users = Users::all();

        if ($categoryId == 4) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.featured_post', 'on')
                    ->where('blog_category_relation.category_id', '=', 4)
                    ->groupBy('blogs.id');
            })
                ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.image1', 'b2.slug','b2.created', 'b2.featured_post', 'b2.bumpPost',)
                ->orderBy('blogs.created', 'desc')
                ->get();
        }

        if (!empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->groupBy('blogs.id')
                ->get();
        }

        if (!empty($service_types) && empty($location_search)) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->get();
        }


        if (empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->groupBy('blogs.id')
                ->get();
        }

        $admins = Admins::all();
        $existingRecord = DB::table('saved_post')->get();

        return view('frontend.realestate.searchlisting', compact('matchingRecords', 'users', 'admins', 'existingRecord'));
    }




    public function service_filter(Request $request)
    {
        
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');

        $users = Users::all();

        if ($categoryId == 705) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.draft', 1)
                    ->where('blogs.featured_post', 'on')
                    ->where('blog_category_relation.category_id', '=', 705)
                    ->groupBy('blogs.id');
            })
                ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
               ->orderByRaw("CASE
                             WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                    WHEN blogs.featured_post = 'on' THEN 2  
                        END ASC, blogs.id DESC")
                ->get();
        }

        if (!empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('created', 'desc')
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        if (!empty($service_types) && empty($location_search)) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('created', 'desc')
                ->get();
        }


        if (empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('created', 'desc')
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        // dd($matchingRecords);

        $filterData = '';
        foreach ($matchingRecords as $record) {
            $neimg = trim($record->image1, '[""]');
            $img = explode('","', $neimg);

            $imageSrc = isset($img[0]) && !empty($img[0]) ? asset('images_blog_img/' . $img[0]) : asset('images_blog_img/1688636936.jpg');
        
            $filterData .= '<div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="feature-box">
                <span class="onsale">Featured!</span>
                    <a href="' . route('service_single', $record->slug) . '">
                        <div class="img-area">
                            <img src="' . $imageSrc . '" alt="' . $record->title . '" class="d-block w-100">
                        </div>
                        <div class="job-post-content">
                            <h4>' . $record->title . '</h4>
                            <div class="main-days-frame">
                                <span class="days-box">';
            
            $givenTime = strtotime($record->created);
            $currentTimestamp = time();
            $timeDifference = $currentTimestamp - $givenTime;
            
            $days = floor($timeDifference / (60 * 60 * 24));
            $timeAgo = ($days > 0) ? (($days == 1) ? "$days day ago" : "$days days ago") : "Posted today";
            
            $filterData .= $timeAgo . '</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>';
        }
        
    
        if (empty($filterData)) {
            $filterData = '<div class="col-12" style="text-align: center;">
                <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">We couldn\'t find any data, Please adjust your filter settings.</h3>
                <a href="' . url('/') . '">
                    <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
                </a>
            </div>';
        }
        return response()->json(['html' => $filterData]);
    }




    public function shopping_filter(Request $request)
    {
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');
    
        $users = Users::all();
        $matchingRecords = collect(); // Initialize as an empty collection
    
        if ($categoryId == 6) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->where('blogs.featured_post', '=', 'on')
                    ->whereNull('blogs.deleted_at')
                    ->where('blog_category_relation.category_id', '=', 6)
                    ->groupBy('blogs.id');
            })
                ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost', 'b2.product_price', 'b2.product_sale_price', 'b2.user_id')
                ->orderByRaw("CASE
                                WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                                WHEN blogs.featured_post = 'on' THEN 2  
                              END ASC, blogs.id DESC")
                ->get();
        }
    
        if (!empty($service_types)) {
            $subCategories = BlogCategories::where('parent_id', $service_types)->pluck('id')->toArray();
            // dd($subCategories);
            $matchingRecords = Blogs::where('status', 1)
                ->whereIn('sub_category', $subCategories)
                ->where('featured_post', 'on')
                ->orderBy('created', 'desc')
                ->get();
        }
    
        if (!empty($service_types) && !empty($location_search)) {
            $subCategories = BlogCategories::where('parent_id', $service_types)->pluck('id')->toArray();
            $matchingRecords = Blogs::where('status', 1)
                ->where('location', 'like', '%' . $location_search . '%')
                ->whereIn('sub_category', $subCategories)
                ->where('featured_post', 'on')
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                                WHEN blogs.featured_post = 'on' THEN 1 
                                WHEN blogs.bumpPost = 1 THEN 2 
                                ELSE 3 
                              END, blogs.id DESC")
                ->groupBy('blogs.id')
                ->get();
        }
    
        if (empty($service_types) && !empty($location_search)) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) use ($categoryId) {
                $query->select('blog_id')
                    ->from('blog_category_relation')
                    ->where('category_id', '=', $categoryId)
                    ->groupBy('blog_id');
            })
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                ->where('location', 'like', '%' . $location_search . '%')
                ->where('featured_post', 'on')
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                                WHEN blogs.featured_post = 'on' THEN 1 
                                WHEN blogs.bumpPost = 1 THEN 2 
                                ELSE 3 
                              END, blogs.id DESC")
                ->groupBy('blogs.id')
                ->get();
        }

        $productIds = $matchingRecords->pluck('id');

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();
        
        $filterData = ''; 
    
        foreach ($matchingRecords as $records) {
            // Clean and explode image array
            $itemFeaturedImages = trim($records->image1, '[""]');
            $itemFeaturedImage = explode('","', $itemFeaturedImages);
            $class = 'active'; // Initialize the class to 'active' for the first carousel item
        
            $filterData .= '<div class="col-md-6 col-lg-3" id="' . $records->id . '">
                            <div class="feature-box afterBefor" style="position:relative;">
                                <span class="onsale">Featured!</span>
                                <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                                    <a href="' . route("shopping_post_single", $records->slug) . '">
                                        <div class="carousel-inner">';
        
            // Loop through images and create carousel items
            foreach ($itemFeaturedImage as $valueitemFeaturedImage) {
                $filterData .= '<div class="carousel-item ' . $class . '">
                                    <img src="' . asset("/images_blog_img") . '/' . $valueitemFeaturedImage . '" alt="image" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
                                </div>';
                $class = ''; // Set class to empty after the first item
            }
        
            $filterData .= '</div>
                            </a>
                        </div>
                        <h6 class="product-title">' . ucfirst($records->title) . '</h6>
                        <div class="price" style="font-size: 15px;padding: 0px 0px;">
                            <del>$' . $records->product_price . '</del> $' . $records->product_sale_price . '
                        </div>';
        
            // Calculate and display ratings
            $totalRating = 0;
            $reviewsForProduct = $allreview->where('product_id', $records->id);
            $totalReviews = count($reviewsForProduct);
        
            if ($totalReviews > 0) {
                foreach ($reviewsForProduct as $review) {
                    $totalRating += $review->rating;
                }
        
                $averageRating = $totalRating / $totalReviews;
                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;
        
                // Display star rating
                $filterData .= '<div class="average-rating">
                                    <ul class="review" style="display: flex; gap: 5px;">';
                for ($i = 0; $i < $fullStars; $i++) {
                    $filterData .= '<li><i class="bi bi-star-fill"></i></li>';
                }
        
                if ($halfStar) {
                    $filterData .= '<li><i class="bi bi-star-half"></i></li>';
                }
        
                for ($i = 0; $i < $emptyStars; $i++) {
                    $filterData .= '<li><i class="bi bi-star"></i></li>';
                }
        
                $filterData .= '</ul>
                                </div>';
            } else {
                // No reviews, show empty stars
                $filterData .= '<div class="average-rating">
                                    <ul class="review" style="display: flex; gap: 5px;">';
                for ($i = 0; $i < 5; $i++) {
                    $filterData .= '<li><i class="bi bi-star"></i></li>';
                }
                $filterData .= '</ul>
                                </div>';
            }
        
            // View Details Button
            $filterData .= '<div class="button-sell" style="margin-top: 40px;">
                                <span><a href="' . route('shopping_post_single', $records->slug) . '" class="btn create-post-button">View Details</a></span>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        
        if (!empty($filterData)) {
            echo $filterData;
        } else {
            echo '<div class="col-12" style="text-align: center;">
                  <h3 style="padding: 5% 0% 2% 0%;  font-size: 20px;">We couldn\'t find any data, Please adjust your filter settings.</h3>          
                  <a href="' . url('/') . '"> <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button></a>                
            </div>';
        }
    }
    


    public function event_filter(Request $request)
    {
        // dd($request->all());
        $users = Users::all();
        $admins = Admins::all();
        $categoryId = 725;
        $now = Carbon::now()->subDays($request->datePosted); // Convert to date string
        $formattedDate = $now->format('Y-m-d H:i:s');

        if (!empty($request->event_type) &&  !empty($request->datePosted) && $request->priceRange != 0) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', 1)
                ->where('blogs.deleted_at', null)
                ->whereBetween('blogs.rate', [0, $request->priceRange])
                ->where('blogs.event_type', $request->event_type)
                ->whereBetween('blogs.created', [$now->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        if (!empty($request->event_type) &&  empty($request->datePosted) && $request->priceRange == 0) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.event_type', $request->event_type)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        if (empty($request->event_type) &&  empty($request->datePosted) && $request->priceRange != 0) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', 1)
                ->where('blogs.deleted_at', null)
                ->whereBetween('blogs.rate', [0, $request->priceRange])
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }


        if (empty($request->event_type) &&  !empty($request->datePosted) && $request->priceRange == 0) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', 1)
                ->where('blogs.deleted_at', null)
                ->whereBetween('blogs.created', [$now->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }







        // echo "<pre>";print_r($matchingRecords);die('end query');

        $filterData = ''; // Initialize the variable outside the loop

        foreach ($matchingRecords as $record) {
            $filterData .= '<div class="col-lg-3 col-md-4 col-sm-6 col-6">
        <a href="' . route('event_single', $record->slug) . '">
            <div class="feature-box">
                <div class="carousel-inner">';

            $itemFeaturedImages = trim($record->image1, '[""]');
            $itemFeaturedImage = explode('","', $itemFeaturedImages);
            if (is_array($itemFeaturedImage)) {
                foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                    $class = ($keyitemFeaturedImage == 0) ? 'active' : 'in-active';
                    $filterData .= '<div class="carousel-item ' . $class . '">
                <img src="' . asset('images_blog_img') . '/' . $valueitemFeaturedImage . '" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
            </div>';
                }
            }

            $filterData .= '</div>
        

    <div class="Name">
        <span>' . $record->title . '</span>
    </div>
    <div class="location">
        <span><i class="bi bi-geo-alt"></i> ' . $record->address . '</span>';

            

            $filterData .= '</div>
    <div class="job-type job-hp ">';

            if ($record->post_by == 'admin') {
                foreach ($admins as $add) {
                    if ($record->user_id == $add->id) {
                        $filterData .= '<img src="' . asset($add->image) . '" alt="">';
                        $filterData .= '<p>' . $record->title . '<br><small>By ' . $add->first_name . '</small></p>';
                    }
                }
            } else {
                // Assuming $users is an array or collection
                foreach ($users as $user) {
                    if ($record->user_id == $user->id) {
                        $filterData .= '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="">';
                        $filterData .= '<p>' . $record->title . '<br><small>By ' . $user->first_name . '</small></p>';
                    }
                }
            }

            $filterData .= '</div>
    </div>
</a>
</div>';
        }

        if (!empty($filterData)) {
            echo $filterData; // Output the concatenated HTML after the loop
        } else {
            echo '<div class="col-12" style="text-align: center;">
              <h3 style="padding: 5% 0% 2% 0%;  font-size: 20px;">We couldn"t find any data, Please adjust your Filter settings.</h3>          
              <a href="' . url('/') . '"> <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button></a>                
        </div>';
        }
    }




    public function Coummunity_filter(Request $request)
    {
        $categoryId = $request->input('searcjobParent');
        $service_types = $request->input('searcjobChild');
        $location_search = $request->input('location');

        $users = Users::all();

        if ($categoryId == 5) {
            $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
                $query->select('blogs.id')
                    ->from('blogs')
                    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                    ->where('blogs.status', '=', '1')
                    ->where('blogs.deleted_at', null)
                    ->where('blogs.featured_post', 'on')
                    ->where('blog_category_relation.category_id', '=', 5)
                    ->groupBy('blogs.id');
            })
                ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
                ->select('blogs.id', 'b2.title', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
                ->orderBy('blogs.created', 'desc')
                ->get();
        }

        if (!empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        if (!empty($service_types) && empty($location_search)) {
            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('sub_category', $service_types)
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->get();
        }


        if (empty($service_types) && !empty($location_search)) {

            $matchingRecords = DB::table('blogs')
                ->whereIn('blogs.id', function ($query) use ($categoryId) {
                    $query->select('blog_id')
                        ->from('blog_category_relation')
                        ->where('category_id', '=', $categoryId)
                        ->groupBy('blog_id');
                })
                ->where('blogs.status', '=', 1)
                ->where('blogs.deleted_at', null)
                ->where('blogs.location',  'like', '%' . $location_search . '%')
                ->leftJoin('users', 'users.id', '=', 'blogs.user_id')
                ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
                ->where('blogs.featured_post', 'on')
                ->orderBy('blogs.created', 'desc')
                ->groupBy('blogs.id') // Add the groupBy here
                ->get();
        }

        $admins = Admins::all();
        $existingRecord = DB::table('saved_post')->get();

        return view('frontend.ourcommunity.searchlisting', compact('matchingRecords', 'users', 'admins', 'existingRecord'));
    }



    public function eventListing()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blog_category_relation.category_id', '=', 725) // Add this condition
                ->groupBy('blogs.id');
        })
            ->orderByRaw("CASE 
                        WHEN blogs.featured_post = 'on' THEN 1 
                        WHEN blogs.bumpPost = 1 THEN 2 
                        ELSE 3 
                    END, blogs.id DESC")
            ->get();
        $users = Users::all();
        $admins = Admins::all();
        // dd($matchingRecords);
        $existingRecord = DB::table('saved_post')->get();
        return view('frontend.event.event_listing', compact('matchingRecords', 'country','users', 'admins', 'existingRecord'));
    }

    public function eventSingle($id)
    {
        $blog = Blogs::find($id);
        $users = Users::all();
        $admins = Admins::all();
        $related_event = Blogs::where('sub_category', $blog->sub_category)->limit(4)->get();
        $existingRecord = DB::table('saved_post')->get();
        $itemFeaturedImages = trim($blog->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $blog->title,
                 'description' => $blog->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];
        return view('frontend.event.event_single', compact('blog', 'users', 'admins','related_event', 'existingRecord','ogmetaData'));
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


    public function listingBumpPost()
    {
        // $bumpdPost = Blogs::whereIn('blogs.id', function($query) {
        //     $query->select('blogs.id')
        //         ->from('blogs')
        //         ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        //         ->where('blogs.status', '=', '1')
        //         ->where('blogs.bumpPost', '=', '1') // Add this condition
        //         ->groupBy('blogs.id');
        // })
        // ->orderBy('blogs.id', 'desc')
        // ->get();


        $bumpdPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
            ->where('blogs.status', '=', '1')
            ->where('blogs.featured_post', '=', 'on')
            ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
            ->groupBy('blogs.id') // Add groupBy() method
            ->get();
        $users = Users::all();
        $admin = Admins::all();
        // dd($bumpdPost);
        // echo "<pre>"; print_r($matchingRecords);
        return view('frontend.bump.bump', compact('bumpdPost','users', 'admin'));
        }

    // public function getAllpost()
    // {

    // $allPost = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
    //     ->where('blogs.status', '=', '1')
    //     ->where('blogs.featured_post', '=', null)
    //     ->where('blogs.deleted_at', '=', null)
    //     ->orderByRaw("CASE
    //                 WHEN blogs.bumpPost = 1 THEN 0 
    //                 ELSE 1 
    //             END ASC, blogs.id DESC")
    //     ->groupBy('blogs.id') // Add groupBy() method
    //     ->get();
    // // dd($allPost);

    // $allVideo = Video::where('view_as', 'public')->where('status', 1)->where('video_by', 'user')->orderByRaw("CASE 
    //                 WHEN videos.featured_post = 'on' THEN 1 
    //                 WHEN videos.bumpPost = 1 THEN 2 
    //                 ELSE 3 
    //             END, videos.id DESC")->get();

    // $blogs = BlogPost::where('status', 1)->where('posted_by', 'user')->orderByRaw("CASE 
    //                 WHEN blog_post.featured_post = 'on' THEN 1 
    //                 WHEN blog_post.bumpPost = 1 THEN 2 
    //                 ELSE 3 
    //             END, blog_post.id DESC")->get();
    // // dd($blogs);
    // $entertainment = Entertainment::where('status', 1)->orderByRaw("CASE 
    //                 WHEN Entertainment.featured_post = 'on' THEN 1 
    //                 WHEN Entertainment.bumpPost = 1 THEN 2 
    //                 ELSE 3 
    //             END, Entertainment.id DESC")->get();

    // $blog_categories  = BlogCategories::whereNull('parent_id')->where('status', 1)->orderBy('title', 'ASC')->get();

    // }
public function FilterData_popular(Request $request)
{
    $slug = $request->slug;
    $id = $request->id;
    $subid = $request->sub_id;

    if ($id == 1) {
        $Filter_data = Business::where('status', 1)
            ->whereNull('deleted_at')
            ->where('draft', '1')
            ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'businesses.id')
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'businesses.id')
                     ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
            ->select('businesses.*', 'likes.likes')
            ->orderByDesc('likes.likes')
            ->groupBy('businesses.id')
            ->get();

    } elseif (in_array($id, [2, 4, 5, 6, 7, 705])) {
        $Filter_data = Blogs::where('blogs.status', 1)
            ->whereNull('blogs.deleted_at')
            ->where('blogs.draft', 1)
            ->where('blogs.sub_category', $subid)
            ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
            ->where('blog_category_relation.category_id', $id)
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'blogs.id')
                     ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
            ->select('blogs.*', 'likes.likes')
            ->orderByDesc('likes.likes')
            ->groupBy('blogs.id')
            ->get();

    } elseif ($id == 741) {
        $Filter_data = Entertainment::where('status', 1)
            ->where('sub_category', $subid)
            ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'Entertainment.id')
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'Entertainment.id')
                     ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
            ->select('Entertainment.*', 'likes.likes')
            ->orderByDesc('likes.likes')
            ->groupBy('Entertainment.id')
            ->get();
    }

    $productIds = $Filter_data->pluck('id');

    $allreview = ProductReview::whereIn('product_id', $productIds)
        ->where('type', 'shopping')
        ->get();

    $html = view('frontend.bump.popular_post_filter', [
        'Filter_data' => $Filter_data,
        'id' => $id,
        'allreview' => $allreview
    ])->render();

    return response()->json(['html' => $html]);
}

public function FilterData_popular_category(Request $request)
    {
        $id = $request->id;
        if ($id ==1) {
            $Filter_data = BlogCategoryRelation::join('businesses', function($join) {
                $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                    ->where(function($query) {
                         $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                               ->orWhereNull('blog_category_relation.sub_category_id')
                               ->orWhere('businesses.sub_category', '=', '')
                               ->orWhereNull('businesses.sub_category');
                     });
        })
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'businesses.id')
                    ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                    ->select('likes.likes');
            })
                    ->where('businesses.status', 1)
                    ->whereNull('businesses.deleted_at')
                    ->where('businesses.draft', '1')
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('businesses.id') 
                    ->get();
        } elseif ($id == 2 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 705) {
            $Filter_data = Blogs::join('blog_category_relation', function($join) {
                    $join->on('blog_category_relation.blog_id', '=', 'blogs.id')
                            ->where(function($query) {
                            $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('blogs.sub_category', '=', '')
                                ->orWhereNull('blogs.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'blogs.id')
                             ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                             ->select('likes.likes');
                    })
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $id)
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('blogs.id')
                    ->get();
     
        }elseif($id==741){
            $Filter_data = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                     ->where(function($query) {
                         $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                               ->orWhereNull('blog_category_relation.sub_category_id')
                               ->orWhere('Entertainment.sub_category', '=', '')
                               ->orWhereNull('Entertainment.sub_category');
                     });
            })
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'Entertainment.id')
                     ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                     ->select('likes.likes');
            })
            ->where('Entertainment.status', 1)
            ->whereNull('Entertainment.deleted_at')
            ->where('Entertainment.draft', 1)
            ->orderBy('likes.likes', 'desc')
            ->groupBy('Entertainment.id') 
            ->get();       
        }
        $productIds = $Filter_data->pluck('id');

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();
        $html = view('frontend.bump.popular_post_category', ['Filter_data' => $Filter_data,'id' =>$id, 'allreview' => $allreview])->render();
        return response()->json(['html' => $html]);

    }



    public function get_post_Uncategorized(){
        $blogs = BlogPost::where('status', 1)->where('subcategory','')->where('posted_by', 'user')->orderByRaw("CASE 
                            WHEN blog_post.featured_post = 'on' THEN 1 
                            WHEN blog_post.bumpPost = 1 THEN 2 
                            ELSE 3 
                        END, blog_post.id DESC")->get();
        // dd($blogs);
        $entertainment = Entertainment::where('status', 1)->where('sub_category','')->orderByRaw("CASE 
                            WHEN Entertainment.featured_post = 'on' THEN 1 
                            WHEN Entertainment.bumpPost = 1 THEN 2 
                            ELSE 3 
                        END, Entertainment.id DESC")->get();

        $listing_data = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blogs.sub_category', '')
                ->groupBy('blogs.id');
        })->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
            ->orderByRaw("CASE 
                    WHEN blogs.featured_post = 'on' THEN 1 
                    WHEN blogs.bumpPost = 1 THEN 2 
                    ELSE 3 
                END, blogs.id DESC")
            ->get();
        // dd($blogs);
        $html = view('frontend.bump.uncategory', ['listing_data' => $listing_data,'entertainment' =>$entertainment,'blogs' => $blogs])->render();
        return response()->json(['html' => $html]);
    }

public static function getAllPost()
{
    $business = BlogCategoryRelation::join('businesses', function($join) {
        $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                    ->where(function($query) {
                         $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                               ->orWhereNull('blog_category_relation.sub_category_id')
                               ->orWhere('businesses.sub_category', '=', '')
                               ->orWhereNull('businesses.sub_category');
                     });
        })
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'businesses.id')
                    ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
                        ->where('businesses.status', 1)
                        ->where('businesses.draft', '1')
                        ->whereNull('businesses.deleted_at')
                        ->select('businesses.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();

    $ads = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->where(function($query) {
                         $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                               ->orWhereNull('blog_category_relation.sub_category_id')
                               ->orWhere('blogs.sub_category', '=', '')
                               ->orWhereNull('blogs.sub_category');
                     });
        })
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'blogs.id')
                    ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
                        ->where('blogs.status', '1')
                        ->where('blogs.draft', 1)
                        ->whereNull('blogs.deleted_at')
                        ->select('blogs.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();


    $entertainment = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                     ->where(function($query) {
                         $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                               ->orWhereNull('blog_category_relation.sub_category_id')
                               ->orWhere('Entertainment.sub_category', '=', '')
                               ->orWhereNull('Entertainment.sub_category');
                     });
            })
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'Entertainment.id')
                     ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
            })
                                ->where('Entertainment.status', 1)
                                ->whereNull('Entertainment.deleted_at')
                                ->where('Entertainment.draft', 1)
                                ->select('Entertainment.*', 'blog_category_relation.category_id', 'likes.likes')
                                ->get();

    $shopping = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
            ->join('likes', function($join) {
                $join->on('likes.blog_id', '=', 'blogs.id')
                        ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
        })
                    ->where('blogs.status', '1')
                    ->where('blogs.draft', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blog_category_relation.category_id', 6)
                    ->groupBy('blogs.id')
                    ->select('blogs.*')
                    ->get();

    $sortedCombined = $ads
        ->merge($business)
        ->merge($entertainment)
        ->sortByDesc(function($post) {
            return $post->likes;
        })->values();

    $productIds = $sortedCombined->pluck('id')->merge($shopping->pluck('id'))->unique();
    $allreview = ProductReview::whereIn('product_id', $productIds)
        ->where('type', 'shopping')
        ->get();

    return view('frontend.bump.bump', compact('sortedCombined', 'allreview'));
}

public function getPostsByLocation(Request $request)
{
    $main_category_id = $request->input('searcjobParent');
    $sub_category_id = $request->input('searcjobChild');
    $location_search = $request->input('location');
    $locations = null;
    $allreview = collect();
    $category_name = '';

    $main_category = BlogCategories::find($main_category_id);

    if ($main_category) {
        $category_name = $main_category->title;
    }

    if ($main_category_id && !$sub_category_id && !$location_search) {
        if ($main_category_id == 1) {
            $locations = BlogCategoryRelation::join('businesses', function($join) {
                    $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                        ->where(function($query) {
                            $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('businesses.sub_category', '=', '')
                                ->orWhereNull('businesses.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'businesses.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                            ->select('likes.likes');
                    })
                    ->where('businesses.status', 1)
                    ->whereNull('businesses.deleted_at')
                    ->where('businesses.draft', '1')
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('businesses.id') 
                    ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 7, 705])) {
            $locations = Blogs::join('blog_category_relation', function($join) {
                    $join->on('blog_category_relation.blog_id', '=', 'blogs.id')
                            ->where(function($query) {
                            $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('blogs.sub_category', '=', '')
                                ->orWhereNull('blogs.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'blogs.id')
                             ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                             ->select('likes.likes');
                    })
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $main_category_id)
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('blogs.id')
                    ->get();
                
        } elseif ($main_category_id == 741) {
            $locations = BlogCategoryRelation::join('Entertainment', function($join) {
                    $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                        ->where(function($query) {
                            $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('Entertainment.sub_category', '=', '')
                                ->orWhereNull('Entertainment.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'Entertainment.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                            ->select('likes.likes');
                    })
                    ->where('Entertainment.status', 1)
                    ->whereNull('Entertainment.deleted_at')
                    ->where('Entertainment.draft', 1)
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('Entertainment.id') 
                    ->get();    
        }
    }

    // If both main and sub category are selected
    if ($main_category_id && $sub_category_id && !$location_search) {
        if ($main_category_id == 1) {
            $locations = BlogCategoryRelation::join('businesses', function($join) use ($sub_category_id) {
                    $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                        ->where('businesses.sub_category', $sub_category_id);
                })
                ->join('likes', function($join) {
                    $join->on('likes.blog_id', '=', 'businesses.id')
                        ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                })
                ->select('businesses.*', 'likes.likes')
                ->where('businesses.status', 1)
                ->whereNull('businesses.deleted_at')
                ->where('businesses.draft', 1)
                ->orderByDesc('likes.likes')
                ->groupBy('businesses.id')
                ->get();

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 7, 705])) {
            $locations = Blogs::join('blog_category_relation', function($join) use ($sub_category_id) {
                    $join->on('blog_category_relation.blog_id', '=', 'blogs.id')
                        ->where('blogs.sub_category', $sub_category_id);
                })
                ->join('likes', function($join) {
                    $join->on('likes.blog_id', '=', 'blogs.id')
                        ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                })
                ->select('blogs.*', 'likes.likes')
                ->where('blogs.status', 1)
                ->whereNull('blogs.deleted_at')
                ->where('blogs.draft', 1)
                ->where('blog_category_relation.category_id', $main_category_id)
                ->orderByDesc('likes.likes')
                ->groupBy('blogs.id')
                ->get();

        } elseif ($main_category_id == 741) {
            $locations = BlogCategoryRelation::join('Entertainment', function($join) use ($sub_category_id) {
                    $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                        ->where('Entertainment.sub_category', $sub_category_id);
                })
                ->join('likes', function($join) {
                    $join->on('likes.blog_id', '=', 'Entertainment.id')
                        ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                })
                ->select('Entertainment.*', 'likes.likes')
                ->where('Entertainment.status', 1)
                ->whereNull('Entertainment.deleted_at')
                ->where('Entertainment.draft', 1)
                ->orderByDesc('likes.likes')
                ->groupBy('Entertainment.id')
                ->get();
        }
    }


    // If main category is selected & filter by location
    if ($main_category_id && $location_search && !$sub_category_id) {
        if ($main_category_id == 1) {
            $location = BlogCategoryRelation::join('businesses', function($join) {
                $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                        ->where(function($query) {
                            $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('businesses.sub_category', '=', '')
                                ->orWhereNull('businesses.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'businesses.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                            ->select('likes.likes');
                    })
                    ->where('businesses.status', 1)
                    ->whereNull('businesses.deleted_at')
                    ->where('businesses.location', 'like', '%' . $location_search . '%')
                    ->where('businesses.draft', '1')
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('businesses.id') 
                    ->get();

    } elseif (in_array($main_category_id, [2, 4, 5, 6, 7, 705])) {
            $locations = Blogs::join('blog_category_relation', function($join) {
                    $join->on('blog_category_relation.blog_id', '=', 'blogs.id')
                            ->where(function($query) {
                            $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('blogs.sub_category', '=', '')
                                ->orWhereNull('blogs.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'blogs.id')
                             ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                             ->select('likes.likes');
                    })
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $main_category_id)
                    ->where('blogs.location', 'like', '%' . $location_search . '%')
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('blogs.id')
                    ->get();

        } elseif ($main_category_id == 741) {
            $locations = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                        ->where(function($query) {
                            $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                                ->orWhereNull('blog_category_relation.sub_category_id')
                                ->orWhere('Entertainment.sub_category', '=', '')
                                ->orWhereNull('Entertainment.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'Entertainment.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id')
                            ->select('likes.likes');
                    })
                    ->where('Entertainment.status', 1)
                    ->whereNull('Entertainment.deleted_at')
                    ->where('Entertainment.location', 'like', '%' . $location_search . '%')
                    ->where('Entertainment.draft', 1)
                    ->orderBy('likes.likes', 'desc')
                    ->groupBy('Entertainment.id') 
                    ->get();  
        }
    }

    // If both main and sub category are selected & filter by location
    if ($main_category_id && $sub_category_id && $location_search) {
        if ($main_category_id == 1) {
            $location = BlogCategoryRelation::join('businesses', function($join) use ($sub_category_id) {
                        $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                            ->where('businesses.sub_category', $sub_category_id);
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'businesses.id')
                            ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                    })
                    ->select('businesses.*', 'likes.likes')
                    ->where('businesses.status', 1)
                    ->whereNull('businesses.deleted_at')
                    ->where('businesses.location', 'like', '%' . $location_search . '%')
                    ->where('businesses.draft', 1)
                    ->orderByDesc('likes.likes')
                    ->groupBy('businesses.id')
                    ->get();     

        } elseif (in_array($main_category_id, [2, 4, 5, 6, 7, 705])) {
            $locations = Blogs::join('blog_category_relation', function($join) use ($sub_category_id) {
                    $join->on('blog_category_relation.blog_id', '=', 'blogs.id')
                        ->where('blogs.sub_category', $sub_category_id);
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'blogs.id')
                            ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                    })
                    ->select('blogs.*', 'likes.likes')
                    ->where('blogs.status', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blogs.draft', 1)
                    ->where('blog_category_relation.category_id', $main_category_id)
                    ->where('blogs.location', 'like', '%' . $location_search . '%')
                    ->orderByDesc('likes.likes')
                    ->groupBy('blogs.id')
                    ->get();

        } elseif ($main_category_id == 741) {
            $locations = BlogCategoryRelation::join('Entertainment', function($join) use ($sub_category_id) {
                        $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                            ->where('Entertainment.sub_category', $sub_category_id);
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'Entertainment.id')
                            ->whereColumn('likes.cate_id', 'blog_category_relation.category_id');
                    })
                    ->select('Entertainment.*', 'likes.likes')
                    ->where('Entertainment.status', 1)
                    ->whereNull('Entertainment.deleted_at')
                    ->where('Entertainment.location', 'like', '%' . $location_search . '%')
                    ->where('Entertainment.draft', 1)
                    ->orderByDesc('likes.likes')
                    ->groupBy('Entertainment.id')
                    ->get();
        }
    }

    // If no category is selected, filter only by location
    if (!$main_category_id && !$sub_category_id && $location_search) {
        $business = BlogCategoryRelation::join('businesses', function($join) {
            $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                    ->where(function($query) {
                         $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('businesses.sub_category', '=', '')
                            ->orWhereNull('businesses.sub_category');
                    });
                })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'businesses.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                    })
                    ->where('businesses.status', 1)
                    ->where('businesses.draft', '1')
                    ->whereNull('businesses.deleted_at')
                    ->where('businesses.location', 'like', '%' . $location_search . '%')
                    ->select('businesses.*', 'blog_category_relation.category_id', 'likes.likes')
                    ->get();

        $ads = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->where(function($query) {
                         $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('blogs.sub_category', '=', '')
                            ->orWhereNull('blogs.sub_category');
                        });
                    })
                        ->join('likes', function($join) {
                            $join->on('likes.blog_id', '=', 'blogs.id')
                                ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                        })
                        ->where('blogs.status', '1')
                        ->where('blogs.draft', 1)
                        ->whereNull('blogs.deleted_at')
                        ->where('blogs.location', 'like', '%' . $location_search . '%')
                        ->select('blogs.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();


        $entertainment = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                     ->where(function($query) {
                         $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('Entertainment.sub_category', '=', '')
                            ->orWhereNull('Entertainment.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'Entertainment.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                    })
                        ->where('Entertainment.status', 1)
                        ->whereNull('Entertainment.deleted_at')
                        ->where('Entertainment.draft', 1)
                        ->where('Entertainment.location', 'like', '%' . $location_search . '%')
                        ->select('Entertainment.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();


        $locations = $ads
                ->merge($business)
                ->merge($entertainment)
                ->sortByDesc(function($post) {
                    return $post->likes;
                })->values();

    }

    if (!$main_category_id && !$sub_category_id && !$location_search) {
        $business = BlogCategoryRelation::join('businesses', function($join) {
            $join->on('businesses.id', '=', 'blog_category_relation.blog_id')
                    ->where(function($query) {
                         $query->whereColumn('businesses.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('businesses.sub_category', '=', '')
                            ->orWhereNull('businesses.sub_category');
                    });
                })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'businesses.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                    })
                    ->where('businesses.status', 1)
                    ->where('businesses.draft', '1')
                    ->whereNull('businesses.deleted_at')
                    ->select('businesses.*', 'blog_category_relation.category_id', 'likes.likes')
                    ->get();

        $ads = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->where(function($query) {
                         $query->whereColumn('blogs.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('blogs.sub_category', '=', '')
                            ->orWhereNull('blogs.sub_category');
                        });
                    })
                        ->join('likes', function($join) {
                            $join->on('likes.blog_id', '=', 'blogs.id')
                                ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                        })
                        ->where('blogs.status', '1')
                        ->where('blogs.draft', 1)
                        ->whereNull('blogs.deleted_at')
                        ->select('blogs.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();


        $entertainment = BlogCategoryRelation::join('Entertainment', function($join) {
                $join->on('Entertainment.id', '=', 'blog_category_relation.blog_id')
                     ->where(function($query) {
                         $query->whereColumn('Entertainment.sub_category', '=', 'blog_category_relation.sub_category_id')
                            ->orWhereNull('blog_category_relation.sub_category_id')
                            ->orWhere('Entertainment.sub_category', '=', '')
                            ->orWhereNull('Entertainment.sub_category');
                        });
                    })
                    ->join('likes', function($join) {
                        $join->on('likes.blog_id', '=', 'Entertainment.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                    })
                        ->where('Entertainment.status', 1)
                        ->whereNull('Entertainment.deleted_at')
                        ->where('Entertainment.draft', 1)
                        ->select('Entertainment.*', 'blog_category_relation.category_id', 'likes.likes')
                        ->get();

        $locations = $ads
                    ->merge($business)
                    ->merge($entertainment)
                    ->sortByDesc(function($post) {
                        return $post->likes;
                    })->values();
    }

    if ($locations->isNotEmpty()) {
    
        $shopping = Blogs::join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('likes', function($join) {
                    $join->on('likes.blog_id', '=', 'blogs.id')
                            ->whereColumn('likes.cate_id', '=', 'blog_category_relation.category_id');
                })
                    ->where('blogs.status', '1')
                    ->where('blogs.draft', 1)
                    ->whereNull('blogs.deleted_at')
                    ->where('blog_category_relation.category_id', 6)
                    ->groupBy('blogs.id')
                    ->select('blogs.*')
                    ->get();

        $productIds = $locations->pluck('id')->merge($shopping->pluck('id'))->unique(); 

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();
    }
    // Render the view with the filtered posts
    $html = view('frontend.bump.listing_search_filter', [
        'locations' => $locations,
        'category_name' => $category_name,
        'allreview' => $allreview
    ])->render();

    return response()->json(['html' => $html]);
}

    

    public function profileJobpost($id)
    {
        $matchRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 2)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();
        // dd($matchRecords);
        $existingRecord = DB::table('saved_post')->get();
        // dd($allPost);
        return view('frontend.profile_page.jobs', compact('matchRecords', 'existingRecord'));
    }

    public function profilerealestatepost($id)
    {
        $matchRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 4)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();
        // dd($matchRecords);
        $existingRecord = DB::table('saved_post')->get();
        // dd($allPost);
        return view('frontend.profile_page.realestate', compact('matchRecords', 'existingRecord'));
    }


    public function profilecommunitypost($id)
    {
        $matchRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 5)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();
        // dd($matchRecords);
        $existingRecord = DB::table('saved_post')->get();
        // dd($allPost);
        return view('frontend.profile_page.community', compact('matchRecords', 'existingRecord'));
    }

    public function profileshoppingpost($id)
    {
        $matchRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 6)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();
        // dd($matchRecords);
        $existingRecord = DB::table('saved_post')->get();
        // dd($allPost);
        return view('frontend.profile_page.shopping', compact('matchRecords', 'existingRecord'));
    }
    public function profileservicespost($id)
    {
        $matchRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->join('users', 'users.id', '=', 'blogs.user_id')
                ->where('blogs.status', '=', '1')
                ->where('blog_category_relation.category_id', '=', 705)
                ->groupBy('blogs.id');
        })
            ->where('users.id', '=', $id) // Add the condition to filter by user ID 2132
            ->orderBy('blogs.id', 'desc')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.image', 'users.bio', 'users.first_name')
            ->get();
        // dd($matchRecords);
        $existingRecord = DB::table('saved_post')->get();
        // dd($allPost);
        return view('frontend.profile_page.services', compact('matchRecords', 'existingRecord'));
    }

    public function blog_listing_page()
    {
        // $blog_post =  BlogPost::where("posted_by","admin")->get();
        $blog_post =  BlogPost::where('status', 1)
                    ->where('posted_by', 'user')
                    ->where('draft', 1)
                    // ->where('featured_post', 'on')
                    ->whereNull('deleted_at')
                    ->orderBy('id', 'desc')
                    ->get();
        return view('frontend.blog.blog_listing', compact('blog_post'));
    }
    public function blog_SA_admin_listing_page()
    {
        // $blog_post =  BlogPost::where("posted_by","admin")->get();
        $blog_post =  BlogPost::where('status', 1)->where('posted_by','admin')->orderBy('created_at', 'desc')->get();

        return view('frontend.blog.blogAdmin_listing', compact('blog_post'));
    }

    public function blog_single_page($slug)
    {
        //$blog_post =  BlogPost::where("posted_by","admin")->first();
        //dd($blog_post);
        //  $blog_post =  BlogPost::where("posted_by","admin")->get();
        $blog_post =  BlogPost::where('slug',$slug)->first();
        // dd($blog_post);
        if(empty($blog_post)){
        abort(404);
        }
        if ($blog_post && $blog_post->posted_by == 'admin') {
            $author = Admins::where('id', $blog_post->user_id)
                ->select('id', 'first_name', 'image', 'slug')
                ->first();
        } else {
            $author = Users::where('id', $blog_post->user_id)
                ->select('id', 'first_name', 'image', 'slug')
                ->first();
        }
        $recent_blog = BlogPost::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();
        // dd($recent_blog);
        $BlogComments = BlogComments::where('blog_id', $blog_post->id)->where('status',1)->where('com_id',null)->get();
        $BlogCommentsReply = BlogComments::where('blog_id', $blog_post->id)->where('status',1)->whereNotNull('com_id')->get();
        $BlogComments_count = BlogComments::where('blog_id', $blog_post->id)->where('status',1)->get();

        $get_follower = Follow::where('follower_id',$blog_post->user_id)->get();
        // dd($get_follower);
        // Collect all user IDs from the BlogComments collection
        $userIds = $BlogComments->pluck('user_id');

        // Fetch user details for the collected user IDs
        $users = Users::whereIn('id', $userIds)
            ->select('id', 'first_name', 'image','slug')
            ->get();
        // dd($author);

        $previousPostId = BlogPost::where('id', '<', $blog_post->id)->orderBy('id', 'desc')->pluck('slug')->first();
        // Get the next post ID
        $nextPostId = BlogPost::where('id', '>', $blog_post->id)->orderBy('id', 'asc')->pluck('slug')->first();
        $shareComponent = \Share::page(
            'https://www.finderspage.com/blogs/' . $slug,
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);

            $itemFeaturedImage  = explode(',', $blog_post->image);
            //  dd($blog_post);

            $content = $blog_post->content;
            $periodPos = strpos($content, '.');

            if ($periodPos !== false) {
                // Extract the substring before the first full stop
                $description = substr($content, 0, $periodPos + 1); // +1 to include the full stop
            } else {
                // No full stop found, take the entire content
                $description = $content;
            }


            $ogmetaData = [
                'title' => $blog_post->title,
                'description' => $description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];

            $metaData = [
                'title' => $blog_post->metaTitle,
                'description' => $blog_post->metaDescription,
            ];

            //  dd($ogmetaData);
        $BlogsViews = BlogsViews::where('Post_id', $blog_post->id)->sum('count');

            $BlogLikes = Like::join('blog_post', 'blog_post.id', '=', 'likes.blog_id')
            ->where('likes.blog_id',$blog_post->id)
            ->select('likes.*')
            ->where('likes.type', 'Blogs')
            ->get();

        //  dd($BlogLikes);
        
        return view('frontend.blog.blog_single', compact('blog_post', 'author', 'BlogComments', 'users', 'BlogComments_count', 'recent_blog', 'previousPostId', 'nextPostId', 'shareComponent', 'BlogsViews','ogmetaData','metaData','BlogCommentsReply','get_follower', 'BlogLikes'));
    }


    public function blogs_html()
    {

        return view('frontend.featured_view.blogs_html');
    }

    public function businessViewAll()
    {
        $business = Business::where('status', 1)->where('featured' ,'on')->orderByRaw("CASE
                    WHEN featured = 'on' AND bumpPost = 1 THEN 1  
                    END ASC,id DESC")
                    ->whereNull('deleted_at')
                    ->where('draft', '1')
                    ->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);

        return view('frontend.featured_view.businessFeatured', compact('business', 'users'));
    }

    public function jobViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 2) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id','b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
           ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);
            
        return view('frontend.featured_view.jobFeatured', compact('matchingRecords', 'users'));
    }


    public function realesteteViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 4) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title','b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
           ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);
        return view('frontend.featured_view.realestateFeatured', compact('matchingRecords', 'users'));
    }

    public function communityViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 5) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.*',)
           ->orderByRaw("CASE
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();

        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);
        return view('frontend.featured_view.comunity', compact('matchingRecords', 'users'));
    }

    public function shoppingViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 6) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title','b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost', 'b2.product_price', 'b2.product_sale_price', 'b2.user_id')
            ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        // dd($matchingRecords);
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);


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

        $productIds = $shopping->pluck('id');

        $allreview = ProductReview::whereIn('product_id', $productIds)
            ->where('type', 'shopping')
            ->get();

        return view('frontend.shoppingFeature', compact('matchingRecords', 'users', 'allreview'));
    }

    public function servicViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 705) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id', 'b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
           ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);

        return view('frontend.featured_view.serviceFeatured', compact('matchingRecords', 'users'));
    }

    public function fundraiserViewAll()
    {
        $matchingRecords = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.status', '=', '1')
                ->where('blogs.deleted_at', null)
                ->where('blogs.draft', 1)
                ->where('blogs.featured_post', 'on')
                ->where('blog_category_relation.category_id', '=', 7) // Add this condition
                ->groupBy('blogs.id');
        })
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->select('blogs.id','b2.title', 'b2.slug', 'b2.image1','b2.created', 'b2.featured_post', 'b2.bumpPost',)
           ->orderByRaw("CASE
                         WHEN blogs.featured_post = 'on' AND blogs.bumpPost = 1 THEN 1  
                WHEN blogs.featured_post = 'on' THEN 2  
                    END ASC, blogs.id DESC")
            ->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);
            
        return view('frontend.featured_view.fundraiserFeatured', compact('matchingRecords', 'users'));
    }

    public function entertainmentViewAll()
    {
        $entertainment = Entertainment::where('status', 1)->where('featured_post' ,'on')->orderByRaw("CASE
                         WHEN featured_post = 'on' AND bumpPost = 1 THEN 1  
                WHEN featured_post = 'on' THEN 2  
                    END ASC,id DESC")
                    ->whereNull('deleted_at')
                    ->where('draft', 1)
                    ->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);

        return view('frontend.featured_view.entertainmentFeatured', compact('entertainment', 'users'));
    }

    public function videoViewAll()
    {
        $video =  Video::where('view_as', 'public')->where('featured_post', 'on')->where('status', 1)->where('video_by', 'user')->orderByRaw("CASE
                         WHEN featured_post = 'on' AND bumpPost = 1 THEN 1  
                WHEN featured_post = 'on' THEN 2  
                    END ASC, id DESC")->get();
        $users = Users::where('status', 1)
            ->whereNull('deleted_at')
            ->get(['image', 'id', 'username']);

        return view('frontend.videoFeatured', compact('video', 'users'));
    }


    //  public function BlogsViewAll()
    // {
    //     $BlogsView = BlogPost::where('status', 1)->where('featured_post' ,'on')->orderByRaw("CASE
    //                      WHEN featured_post = 'on' AND bumpPost = 1 THEN 1  
    //             WHEN blog_post.featured_post = 'on' THEN 2  
    //                 END ASC, id DESC")->get();
        
    //     $users = Users::where('status', 1)
    //         ->whereNull('deleted_at')
    //         ->get(['image', 'id', 'username']);

    //     return view('frontend.featured_view.blogsFeature', compact('BlogsView', 'users'));
    // }


    public function BlogsViewAll()
    {
        $BlogsView = BlogPost::where('status', 1)
                ->where('posted_by', 'user')
                ->where('draft', 1)
                ->where('featured_post', 'on')
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('frontend.featured_view.blogsFeature', compact('BlogsView'));
    }


    public function newpricing()
    {
        return view('frontend.dashboard_pages.newpricing');
    }


    public function checkCormFUnct()
    {
        try {
        $currentDateTime = Carbon::now();
        
         // dd($BumpPost_Video_77);
        $BumpPost_Video = Video::where('normal_post', 1)->where('normal_end_date', '<', $currentDateTime)->update([
            'bump_start' => null,
            'normal_end_date' => null,
            'status' => 0,
        ]);
        // dd($BumpPost_Video);
        } catch (QueryException $e) {
            echo'QueryException: ' . $e->getMessage();
            // Handle the query exception, e.g., rollback transactions, notify administrators, etc.
        } catch (\Exception $e) {
           echo'Exception: ' . $e->getMessage();
            // Handle other exceptions as needed
        }
    }



    function update_available_now(Request $request){
            if($request->post_id){
                if($request->available_now == 1){
                   $availableUpdate = DB::table('blogs')
                    ->where('id', $request->post_id)
                    ->limit(1)
                    ->update([
                        'available_now' => $request->available_now,
                        'available_since' => now()->addHours(4)
                    ]);
            }else{
                $availableUpdate = DB::table('blogs')
                        ->where('id', $request->post_id)
                        ->limit(1)
                        ->update(['available_now' => $request->available_now ,'available_since' => null]);
            }

            if($availableUpdate){
                return response()->json(['success' => 'Updated successfully.']);
            }else{
                return response()->json(['error' => 'Somthing went wrong.']);
            }
        }
    }
    
    
    function update_available_now_business(Request $request){
            if($request->post_id){
                if($request->available_now == 1){
                   $availableUpdate = DB::table('businesses')
                    ->where('id', $request->post_id)
                    ->limit(1)
                    ->update([
                        'available_now' => $request->available_now,
                        'available_since' => now()->addHours(4)
                    ]);
            }else{
                $availableUpdate = DB::table('businesses')
                        ->where('id', $request->post_id)
                        ->limit(1)
                        ->update(['available_now' => $request->available_now ,'available_since' => null]);
            }

            if($availableUpdate){
                return response()->json(['success' => 'Updated successfully.']);
            }else{
                return response()->json(['error' => 'Somthing went wrong.']);
            }
        }
    }



    
    function remove_image_db(Request $request) {
        if ($request->id) {
            $getImage = DB::table('blogs')->where('id', $request->id)->first(['image1']);
            if ($getImage) {
                // Check if image1 is an array and contains the image to be removed
                $image1 = json_decode($getImage->image1, true);
                if (is_array($image1)) {
                    $key = array_search($request->removeName, $image1);
                    if ($key !== false) {
                        unset($image1[$key]);
                        
                        // Re-index the array to ensure consistency
                        $image1 = array_values($image1);
                        
                        // Update the database
                        $updateData = DB::table('blogs')->where('id', $request->id)->update(['image1' => json_encode($image1)]);
                        if ($updateData) {
                            return response()->json(['type' => 'success', 'message' => 'Image removed.']);
                        } else {
                            return response()->json(['type' => 'error', 'message' => 'Something went wrong.']);
                        }
                    } else {
                        return response()->json(['type' => 'error', 'message' => 'Image not found.']);
                    }
                } else {
                    return response()->json(['type' => 'error', 'message' => 'Image data is not an array.']);
                }
            } else {
                return response()->json(['type' => 'error', 'message' => 'No image found for the provided id.']);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Id is required.']);
        }
    }





    function remove_image_db_blog(Request $request) {
        if ($request->id) {
            $getImage = DB::table('blog_post')->where('id', $request->id)->first(['image']);
            // dd($getImage);
            if ($getImage) {
                // Check if image1 is an array and contains the image to be removed
                $image1 = explode(',',$getImage->image);
                
                if (is_array($image1)) {
                    $key = array_search($request->removeName, $image1);
                    if ($key !== false) {
                        unset($image1[$key]);
                        
                        // Re-index the array to ensure consistency
                        $image1 = array_values($image1);
                        // dd($image1);
                        // Update the database
                        $updateData = DB::table('blog_post')->where('id', $request->id)->update(['image' => implode(',',$image1)]);
                        if ($updateData) {
                            return response()->json(['type' => 'success', 'message' => 'Image removed.']);
                        } else {
                            return response()->json(['type' => 'error', 'message' => 'Something went wrong.']);
                        }
                    } else {
                        return response()->json(['type' => 'error', 'message' => 'Image not found.']);
                    }
                } else {
                    return response()->json(['type' => 'error', 'message' => 'Image data is not an array.']);
                }
            } else {
                return response()->json(['type' => 'error', 'message' => 'No image found for the provided id.']);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Id is required.']);
        }
    }



    function remove_image_db_entertainment(Request $request) {
        if ($request->id) {
            $getImage = DB::table('Entertainment')->where('id', $request->id)->first(['image']);
            if ($getImage) {
                // Check if image1 is an array and contains the image to be removed
                $image1 = explode(',',$getImage->image);
                if (is_array($image1)) {
                    $key = array_search($request->removeName, $image1);
                    if ($key !== false) {
                        unset($image1[$key]);
                        
                        // Re-index the array to ensure consistency
                        $image1 = array_values($image1);
                        
                        // Update the database
                        $updateData = DB::table('Entertainment')->where('id', $request->id)->update(['image' => implode(',',$image1)]);
                        if ($updateData) {
                            return response()->json(['type' => 'success', 'message' => 'Image removed.']);
                        } else {
                            return response()->json(['type' => 'error', 'message' => 'Something went wrong.']);
                        }
                    } else {
                        return response()->json(['type' => 'error', 'message' => 'Image not found.']);
                    }
                } else {
                    return response()->json(['type' => 'error', 'message' => 'Image data is not an array.']);
                }
            } else {
                return response()->json(['type' => 'error', 'message' => 'No image found for the provided id.']);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Id is required.']);
        }
    }



    function get_blog_image_location(Request $request) {
        if ($request->blog_id) {
            $getData = DB::table('blog_post')->where('id', $request->blog_id)->first(['id','image','location']);
            
            $view = view('frontend.dashboard_pages.image_location', ['getData' => $getData])->render();

            return response()->json(['html' => $view]);
             
            
        } else {
            return response()->json(['type' => 'error', 'message' => 'Id is required.']);
        }
    }



function GetdeletedlisttingData($id){
    $matchingRecords = Blogs::onlyTrashed()
    ->where('blogs.user_id', $id) 
    ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
    ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
    ->groupBy('blogs.id')
    ->select(
        'blogs.id', 
        'b2.title', 
        'b2.user_id',
        'b2.image1', 
        'b2.created', 
        'b2.slug', 
        'b2.featured_post', 
        'b2.bumpPost',
        'blog_category_relation.category_id'
    )
    ->orderBy('blogs.id', 'DESC')
    ->get();

    $blogs_data = BlogPost::onlyTrashed()->get();

    $entertainment_data = Entertainment::onlyTrashed()->get();

    $business_data = Business::onlyTrashed()
    ->where('user_id', '=', UserAuth::getLoginId())
    ->get();

    return view('frontend.dashboard_pages.restoreListing',compact('matchingRecords','blogs_data','business_data','entertainment_data'));
}

public function GetdeletedSinglelistting($category_id)
{

    $matchingRecords = null;

    if (in_array($category_id, [2, 4, 5, 6, 705])) {

        $matchingRecords = Blogs::onlyTrashed()
            ->where('blogs.user_id', UserAuth::getLoginId())
            ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
            ->join('blogs AS b2', 'b2.id', '=', 'blogs.id')
            ->where('blog_category_relation.category_id', $category_id)
            ->groupBy('blogs.id')
            ->select(
                'blogs.id', 
                'b2.title', 
                'b2.user_id',
                'b2.image1', 
                'b2.created', 
                'b2.slug', 
                'b2.featured_post', 
                'b2.bumpPost',
                'blog_category_relation.category_id'
            ) 
            ->orderBy('blogs.id', 'DESC')
            ->get();
    } else {
        $matchingRecords = collect();
    }

    $blogs_data = null;
    $entertainment_data = null;
    $business_data = null;

    if ($category_id == 728) {
        $blogs_data = BlogPost::onlyTrashed()->where('user_id', UserAuth::getLoginId())->get();
    }
    if ($category_id == 741) {
        $entertainment_data = Entertainment::onlyTrashed()->where('user_id', UserAuth::getLoginId())->get();
    }
    if ($category_id == 1) {
        $business_data = Business::onlyTrashed()->where('user_id', UserAuth::getLoginId())->get();
    }

    return view('frontend.dashboard_pages.restoreSingleListing', compact('matchingRecords', 'blogs_data', 'entertainment_data', 'business_data', 'category_id'));
}



function restoreDeletedData($id, $type)
{
    $blogs = null;
    $blogPost = null;
    $entertainment = null;
    $business = null;

    // Find the blog post with the given ID, including soft deleted ones
    if ($type == 'Blogs') {
        $blogs = Blogs::withTrashed()->find($id);
    } elseif ($type == 'BlogPost') {
        $blogPost = BlogPost::withTrashed()->find($id);
    } elseif ($type == 'Entertainment') {
        $entertainment = Entertainment::withTrashed()->find($id);
    } elseif ($type == 'Business') {
        $business = Business::withTrashed()->find($id);
    }

    if ($blogs) {
        $blogs->restore();
        return redirect()->back()->with(['success' => 'Listing recovered successfully.']);
    } elseif ($blogPost) {
        $blogPost->restore();
        return redirect()->back()->with(['success' => 'Blog recovered successfully.']);
    } elseif ($entertainment) {
        $entertainment->restore();
        return redirect()->back()->with(['success' => 'Listing recovered successfully.']);
    } elseif ($business) {
        $business->restore();
        return redirect()->back()->with(['success' => 'Listing recovered successfully.']);
    } else {
        return redirect()->back()->with(['error' => 'Listing not found.']);
    }
}



function DeletedDataPermanently($id, $type)
{
    
    $blogs = null;
    $blogPost = null;
    $entertainment = null;
    $business = null;

    // Find the blog post with the given ID, including soft deleted ones
    if ($type == 'Blogs') {
        $blogs = Blogs::withTrashed()->find($id);
    } elseif ($type == 'BlogPost') {
        $blogPost = BlogPost::withTrashed()->find($id);
    } elseif ($type == 'Entertainment') {
        $entertainment = Entertainment::withTrashed()->find($id);
    } elseif ($type == 'Business') {
        $business = Business::withTrashed()->find($id);
    }

    // Check if the blog post exists before attempting to restore
    if ($blogs) {
        $blogs->forceDelete();
        return redirect()->back()->with(['success' => 'Listing deleted successfully.']);
    } elseif ($blogPost) {
        $blogPost->forceDelete();
        return redirect()->back()->with(['success' => 'Blog deleted successfully.']);
    } elseif ($entertainment) {
        $entertainment->forceDelete();
        return redirect()->back()->with(['success' => 'Listing deleted successfully.']);
    } elseif ($business) {
        $business->forceDelete();
        return redirect()->back()->with(['success' => 'Listing deleted successfully.']);
    } else {
        return redirect()->back()->with(['error' => 'Listing not found.']);
    }
}


function updateimageData(Request $request){
   
     try {
        // Retrieve the image data
        $imageData = Blogs::findOrFail($request->id);
        
       // Extract filenames from the array and convert to a comma-separated string
       $filenames = array_column($request->imgarray, 'filename');
    
       $img_array = json_encode($filenames);
       
    //    implode(',', $filenames);
      
        // Update the image data
        $imageData->update([
            'image1' => $img_array,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Featured image set successfully.',
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        // Log::error('Error updating image data: ', ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while set featured image.'
        ], 500);
    }
}



function updateimageData_blogpost(Request $request){
    //  dd($request->all());
     try {
        // Retrieve the image data
        $imageData = BlogPost::findOrFail($request->id);
        
       // Extract filenames from the array and convert to a comma-separated string
       $filenames = array_column($request->imgarray, 'filename');
    
    //    $img_array = json_encode($filenames);
       $img_array = implode(',', $filenames);
       
    //    implode(',', $filenames);
      
        // Update the image data
        $imageData->update([
            'image' => $img_array,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Featured image set successfully.',
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        // Log::error('Error updating image data: ', ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while set featured image.'
        ], 500);
    }
}




function updateimageData_entertainment(Request $request){
    //  dd($request->all());
     try {
        // Retrieve the image data
        $imageData = Entertainment::findOrFail($request->id);
        
       // Extract filenames from the array and convert to a comma-separated string
       $filenames = array_column($request->imgarray, 'filename');
    
       $img_array = json_encode($filenames);
       
    //    implode(',', $filenames);
      
        // Update the image data
        $imageData->update([
            'image' => $img_array,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Featured image set successfully.',
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        // Log::error('Error updating image data: ', ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while set featured image.'
        ], 500);
    }
}



    public function CheckFunction(){
      $blogs = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->on('blogs.sub_category', '=', 'blog_category_relation.sub_category_id');
        })
        // ->where('blogs.status', '1')
        // ->whereNull('blogs.deleted_at')
        // ->where('blogs.draft', 1)
        ->select('blogs.*', 'blog_category_relation.category_id')
        ->get();
        
        foreach($blogs as $blog){
            
                $route = '#';
                $category_name = '';
                if ($blog->category_id == 1) {
                    $category_name = 'Business';
                    $route = route('business_page.front.single.listing', $blog->slug);
                } elseif ($blog->category_id == 2) {
                    $category_name = 'Jobs';
                    $route = route('jobpost', $blog->slug);
                } elseif ($blog->category_id == 4) {
                    $category_name = 'Real Estate';
                    $route = route('real_esate_post', $blog->slug);
                } elseif ($blog->category_id == 5) {
                    $category_name = 'Welcome to our Community';
                    $route = route('community_single_post', $blog->slug);
                } elseif ($blog->category_id == 6) {
                    $category_name = 'Shopping';
                    $route = route('shopping_post_single', $blog->slug);
                } elseif ($blog->category_id == 7) {
                    $category_name = 'Fundraisers';
                    $route = route('single.fundraisers', $blog->slug);
                } elseif ($blog->category_id == 705) {
                    $category_name = 'Services';
                    $route = route('service_single', $blog->slug);
                } elseif ($blog->category_id == 741) {
                    $category_name = 'Entertainment Industry';
                    $route = route('Entertainment.single.listing', $blog->slug);
                }
            $givenTime = strtotime($blog->created);
            $currentTimestamp = time();
            $timeDifference = $currentTimestamp - $givenTime;

            $days = floor($timeDifference / (60 * 60 * 24));
            $slug = $blog->slug;
            echo"<pre>";print_r($days);
            echo"<br>";print_r($slug);
            if($days == 37){
                $userData = Users::where('id',$blog->user_id)->first();
                $notice = [
                    'from_id' => 7,
                    'to_id' =>$userData->id,
                    'type' => 'post',
                    'message' => 'Your listing expires in 7 days',
                    ];
                Notification::create($notice); 

                $codes = [
                    '{first_name}' => $userData->username,
                    '{listing_link}' => $route,
                ];

                General::sendTemplateEmail(
                    $userData->email,
                    'weekly-notification-before-the-expiration-date',
                    $codes
                );
                
                echo'Notifications sent successfully!';
            }
        } die('fdhgsjd');
    }

  
}
