<?php



/**

 * Blogs Class

 *

 * @package    BlogsController

 * @copyright  2021 Globiz Technology Inc..

 * @author     Ritish Vermani <ritish.vermani@globiztechnology.com>

 * @version    Release: 1.0.0

 * @since      Class available since Release 1.0.0

 */





namespace App\Http\Controllers\Admin\Blogs;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\Settings;

use App\Models\Admin\Permissions;

use App\Models\Admin\AdminAuth;

use App\Libraries\General;

use App\Models\Admin\Blogs;

use App\Models\Admin\BlogCategories;

use App\Models\Admin\Admins;

use App\Models\User;
use App\Models\ProductReview;
use App\Models\Admin\Users;
use App\Models\PostReport;

use App\Models\Admin\BlogCategoryRelation;

use Illuminate\Validation\Rule;

use App\Models\Admin\Notification;
use App\Models\Admin\BlogPost;
use App\Models\Support;

use Illuminate\Support\Str;

use App\Libraries\FileSystem;
use App\Models\Latest_post;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Video;
use App\Models\Admin\Follow;
use DB;
use App\Models\Entertainment;
use App\Models\reviewModel;

use App\Http\Controllers\Admin\AppController;



class BlogsController extends AppController

{

	function __construct()

	{

		parent::__construct();

	}



    function index(Request $request)

    {

    	if(!Permissions::hasPermission('blogs', 'listing'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$where = [];

    	if($request->get('search'))

    	{

    		$search = $request->get('search');

    		$search = '%' . $search . '%';

    		$where['(blogs.title LIKE ? or owner.first_name LIKE ? or owner.last_name LIKE ?)'] = [$search, $search, $search];

    	}



    	if($request->get('created_on'))

    	{

    		$createdOn = $request->get('created_on');

    		if(isset($createdOn[0]) && !empty($createdOn[0]))

    			$where['blogs.created >= ?'] = [

    				date('Y-m-d 00:00:00', strtotime($createdOn[0]))

    			];

    		if(isset($createdOn[1]) && !empty($createdOn[1]))

    			$where['blogs.created <= ?'] = [

    				date('Y-m-d 23:59:59', strtotime($createdOn[1]))

    			];

    	}



    	if($request->get('admins'))

    	{

    		$admins = $request->get('admins');

    		$admins = $admins ? implode(',', $admins) : 0;

    		$where[] = 'blogs.created_by IN ('.$admins.')';

    	}



    	if($request->get('category'))

    	{

    		$blogIds = BlogCategoryRelation::distinct()->whereIn('category_id', $request->get('category'))->pluck('blog_id')->toArray();

    		$blogIds = !empty($blogIds) ? implode(',', $blogIds) : '0';

    		$where[] = 'blogs.id IN ('.$blogIds.')';

    	}



    	if($request->get('status') !== "" && $request->get('status') !== null)

    	{    		

    		$where['blogs.status'] = $request->get('status');

    	}

    	

    	$listing = Blogs::getListing($request, $where );
        // $listing = Blogs::getListing($request, $where );





    	if($request->ajax())

    	{

		    $html = view(

	    		"admin/blogs/listingLoop", 

	    		[

	    			'listing' => $listing

	    		]

	    	)->render();



		    return Response()->json([

		    	'status' => 'success',

	            'html' => $html,

	            'page' => $listing->currentPage(),

	            'counter' => $listing->perPage(),

	            'count' => $listing->total(),

	            'pagination_counter' => $listing->currentPage() * $listing->perPage()

	        ], 200);

		}

		else

		{

			/** Filter Data **/

			$filters = $this->filters($request);

	    	/** Filter Data **/

	    	return view(

	    		"admin/blogs/index", 

	    		[

	    			'listing' => $listing,

	    			'categories' => $filters['categories'],

	    			'admins' => $filters['admins']

	    		]

	    	);

	    }

    }

 public function update_status(Request $request){
        
    // dd($request->all());
    $blog =  Blogs::where('id', $request->id)->first();
    if($request->status == '1'){
    if($blog){
        // dd($blog->id);
       Blogs::where('id', $request->id)->update(['status'=> $request->status, 'created' => now()]); 
       $usert = User::where('id', $blog->user_id)->first();
                    if($request->cateID=='2'){
                        $message1 = "Your job Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('jobpost', $blog->slug);
                    }elseif($request->cateID=='4'){
                        $message1 = "Your realestate Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('real_esate_post', $blog->slug);                        
                    }elseif($request->cateID=='5'){
                        $message1 = "Your community Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('community_single_post', $blog->slug);
                    }elseif($request->cateID=='6'){
                        $message1 = "Your shopping Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('shopping_post_single', $blog->slug);
                    }elseif($request->cateID=='705'){
                        $message1 = "Your service Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('service_single', $blog->slug);
                    }elseif($request->cateID=='7'){
                        $message1 = "Your fundraiser Ad \"{$blog->title}\" is approved.";
                        $postUrl = route('single.fundraisers', $blog->slug);
                    }
            $notice = [
                    'from_id' => AdminAuth::getLoginId(),
                    'to_id' => $blog->user_id,
                    'type' =>'approve',
                    'rel_id' => $blog->id,
                    'cate_id' => $request->cateID,
                    'url' => $postUrl,
                    'message' => $message1,
                ];
                Notification::create($notice);
                
            
            // Assuming you have models for Follow and Users
            // dd($request->user_id);
            // Retrieve followers
            $followers = Follow::where('follower_id', $blog->user_id)->pluck('following_id')->toArray();
               // dd($followers);
            foreach ($followers as $followerId) {
                // Retrieve follower details
                $followerDetails = Users::find($followerId);

                // Check if follower details are found
                if ($followerDetails) {
                    // Access individual follower details
                    $followerUserId = $followerDetails->id;
                    $followerFirstName = $followerDetails->first_name;
                    if($request->cateID=='2'){
                        $message = "A new job Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('jobpost',$blog->slug);
                    }elseif($request->cateID=='4'){
                        $message = "A new realestate Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('real_esate_post',$blog->slug);                        
                    }elseif($request->cateID=='5'){
                        $message = "A new community Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('community_single_post',$blog->slug);
                    }elseif($request->cateID=='6'){
                        $message = "A new shopping Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('shopping_post_single',$blog->slug);
                    }elseif($request->cateID=='705'){
                        $message = "A new service Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('service_single',$blog->slug);
                    }elseif($request->cateID=='7'){
                        $message = "Your fundraiser Ad \"{$blog->title}\" is created by {$usert->first_name}.";
                        $post_url = route('single.fundraisers', $blog->slug);
                    }


                    $neimg = trim($blog->image1, '[""]');
                    $extract_img = explode('","', $neimg);


                    $image_url = asset('images_blog_img').'/'.$extract_img[0];
                    // $post_url = route('get_listing_view',$blog->slug);
                    $codes = [
                        '{name}' => $usert->first_name,
                        '{title}' => $blog->title,
                        '{image}' => $image_url,
                        '{post_url}' => $post_url,
                        '{posted_date}' => $blog->created_at,

                    ];

                    General::sendTemplateEmail(
                        $followerDetails->email,
                        'post-notification-member',
                        $codes
                    );
                    // Create notification
                    $notice = [
                        'from_id' => $blog->user_id,
                        'to_id' => $followerUserId,
                        'type' => 'post_front',
                        'rel_id' => $blog->id,
                        'cate_id' => $request->cateID,
                        'message' => $message,
                        'url' => $post_url,
                    ];

                    //Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
                    }

                    $data =[
                        "user_id" => $blog->user_id,
                        'to_id' => $followerUserId,
                        "post_id" => $blog->id,
                        "category" => $request->cateID,
                        "type" => "blogs",   
                    ];
                    Latest_post::create_latestpost($data);
                 }   
        $codes = [
                    '{first_name}' => $usert->first_name,
                    '{post_url}'=> $postUrl,
                ];

                General::sendTemplateEmail(
                    $usert->email,
                    'post-approved-by-admin',
                    $codes
                );
          // dd($usert);
        return response()->json(['Post_success' => 'Post updated successfully.']);
    }else{
        return response()->json(['Post_error' => 'Somthing went wrong.']);
    }
    }else{
         Blogs::where('id', $request->id)->update(['status'=> $request->status, 'created' => now()]); 
           $usert =  User::where('id', $blog->user_id)->first();
                    if($request->cateID=='2'){
                        $message = "Your job Ad \"{$blog->title}\" is not approved.";
                        $postUrl = route('jobpost', $blog->slug);
                    }elseif($request->cateID=='4'){
                        $message = "Your realestate Ad \"{$blog->title}\" is not approved.";  
                        $postUrl = route('real_esate_post', $blog->slug);                      
                    }elseif($request->cateID=='5'){
                        $message = "Your community Ad \"{$blog->title}\" is not approved.";
                        $postUrl = route('community_single_post', $blog->slug);
                    }elseif($request->cateID=='6'){
                        $message = "Your shopping Ad \"{$blog->title}\" is not approved.";
                        $postUrl = route('shopping_post_single', $blog->slug);
                    }elseif($request->cateID=='705'){
                        $message = "Your service Ad \"{$blog->title}\" is not approved.";
                        $postUrl = route('service_single', $blog->slug);
                    }elseif($request->cateID=='7'){
                        $message = "Your fundraiser Ad \"{$blog->title}\" is not approved.";
                        $postUrl = route('single.fundraisers', $blog->slug);
                    }
           $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $blog->user_id,
                        'cate_id' => $request->cateID,
                        'type' =>'approve',
                        'rel_id' => $blog->id,
                        'cate_id' => $request->cateID,
                        'url' => $postUrl,
                        'message' => $message,
                    ];
            Notification::create($notice);
            return response()->json(['Post_success' => 'Post updated successfully.']);
    }
    
    }


public function update_status_entertainment(Request $request){
    $blog =  Entertainment::where('id', $request->id)->first();
    if($blog){
       Entertainment::where('id', $request->id)->update(['status'=> $request->status, 'created_at' => now()]); 
       $usert =  User::where('id', $blog->user_id)->first();
       if($request->status == 1){
        $message = "Your entertainment post \"{$blog->title}\" is approved.";
        $postUrl = route('Entertainment.single.listing', $blog->slug);
       }else{
        $message = "Your entertainment post \"{$blog->title}\" is not approved.";
       }
       $notice = [
                    'from_id' => AdminAuth::getLoginId(),
                    'to_id' => $blog->user_id,
                    'cate_id' => 741,
                    'type' =>'approve',
                    'notification_by' => '1',
                    'message' => $message,
                    'url' => route('Entertainment.single.listing', $blog->slug),
                ];
                    Notification::create($notice);


            // Assuming you have models for Follow and Users
            // dd($request->user_id);
            // Retrieve followers
            $followers = Follow::where('follower_id', $blog->user_id)->pluck('following_id')->toArray();
               // dd($followers);
            foreach ($followers as $followerId) {
                // Retrieve follower details
                $followerDetails = Users::find($followerId);

                // Check if follower details are found
                if ($followerDetails) {
                    // Access individual follower details
                    $followerUserId = $followerDetails->id;
                    $followerFirstName = $followerDetails->first_name;

                    $image_url = asset('images_blog_img').'/'.$blog->image[0];
                    $post_url = route('Entertainment.single.listing',$blog->slug);
                    $codes = [
                        '{name}' => $usert->first_name,
                        '{title}' => $blog->title,
                        '{image}' => $image_url,
                        '{post_url}' => $post_url,
                        '{posted_date}' => $blog->created_at,

                    ];

                    General::sendTemplateEmail(
                        $followerDetails->email,
                        'post-notification-member',
                        $codes
                    );
                    // Create notification
                    $notice = [
                        'from_id' => $blog->user_id,
                        'to_id' => $followerUserId,
                        'type' => 'Entertainment_front',
                        'rel_id' => $blog->id,
                        'cate_id' => $request->cateID,
                        'message' => "A new entertainment post \"{$blog->title}\" is created by {$usert->first_name}.",
                        'url' => $post_url,
                    ];

                    // Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
                    }
                 }   
        $codes = [
                    '{first_name}' => $usert->first_name,
                    '{post_url}'=> $postUrl,
                ];

                General::sendTemplateEmail(
                    $usert->email,
                    'post-approved-by-admin',
                    $codes
                );
          // dd($usert);
        return response()->json(['Post_success' => 'Post updated successfully.']);
    }else{
        return response()->json(['Post_error' => 'Somthing went wrong.']);
    }
    
    }
    function filters(Request $request)

    {

    	$catIds = BlogCategoryRelation::distinct()->pluck('category_id')->toArray();

    	$categories = [];

    	if($catIds)

    	{

			$categories = BlogCategories::getAllCategorySubCategory($catIds);

		}



		$admins = [];

		$adminIds = Blogs::distinct()->whereNotNull('created_by')->pluck('created_by')->toArray();

		if($adminIds)

		{

	    	$admins = Admins::getAll(

	    		[

	    			'admins.id',

	    			'admins.first_name',

	    			'admins.last_name',

	    			'admins.status',

	    		],

	    		[

	    			'admins.id in ('.implode(',', $adminIds).')'

	    		],

	    		'concat(admins.first_name, admins.last_name) desc'

	    	);

	    }

    	return [

    		'categories' => $categories,

	    	'admins' => $admins

    	];

    }



    function view(Request $request, $id)

    {
    	if(!Permissions::hasPermission('blogs', 'listing'))

    	{
    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$blog = Blogs::get($id);

    	if($blog)

    	{

	    	return view("admin/blogs/view", [

    			'blog' => $blog

    		]);

		}

		else

		{

			abort(404);

		}

    }



    function add(Request $request)

    {

    	if(!Permissions::hasPermission('blogs', 'create'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	if($request->isMethod('post'))

    	{
     // echo "<pre>";print_r($request->all());die('developer');

    		$data = $request->toArray();

    		unset($data['_token']);

    		   



    		$validator = Validator::make(

	            $request->toArray(),

	            [
	                'title' => 'required',
	            ]

	        );



	        if(!$validator->fails())

	        {

	        	$subCategories = $categories = [];

	        	if(isset($data['category']) && $data['category']) {

	        		$categories = $data['category'];

	        	}

	        	// unset($data['categories']);

	        	if(isset($data['sub_categories']) && $data['sub_categories']) {

	        		$subCategories = $data['sub_categories'];

	        	}



	        	// if ($request->hasFile('image1')) {
				//     $image = $request->file('image1');
				//     $name = time() . '.' . $image->getClientOriginalExtension();
				//     $destinationPath = public_path('images_blog_img');
				//     $image->move($destinationPath, $name);
				//     $data['image1'] = $name;
				// }
					if ($request->hasFile('image1')) {
                        $images = $request->file('image1');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $data['image1'] = $imageNames;
                    }

					if ($request->hasFile('post_video')) {
	                    $video = $request->file('post_video');
	                    $videoName = time() . '.' . $video->getClientOriginalExtension();
	                    $video->move(public_path('images_blog_video'), $videoName);
	                    $data['post_video'] = $videoName;
                    	}

	        	 unset($data['category']);

	        	// pr($data); die;

	        	$blog = Blogs::create($data);

	        	if($blog)
	        	{

                    	
	        		if(!empty($categories))

	        		{

	        			Blogs::handleCategories($blog->id, $categories);

	        		}

                $followers = Users::pluck('email')->toArray();
                $followers_ids = Users::pluck('id');
                $allemail = implode(',', $followers);
                // dd($allemail);
               
                foreach ($followers_ids as $followers_id) {
                    
                    $notice = [
                                'from_id' => 7,
                                'to_id' => $followers_id,
                                'type' => 'Blogpost_front',
                                'rel_id' => $blog->id,
                                'message' => "A new Ad \"{$blog->title}\" is created by FindersPage.",
                                'url' => route('jobpost', $blog->slug),
                            ];

                            // Assuming Notification model has mass assignable fields defined
                            Notification::create($notice);
                    }
                    $codes = [
                        '{title}' => $blog->title,
                        '{post_url}' => url('/job-post/' . $blog->slug),
                    ];

                    
                    General::sendTemplateEmail(
                        $allemail,
                        'listing-by-admin',
                        $codes
                    );

                    

	        		$request->session()->flash('success', 'Post created successfully.');

	        		return redirect()->route('admin.blogs');

	        	}

	        	else

	        	{

	        		$request->session()->flash('error', 'Post could not be saved. Please try again.');

		    		return redirect()->back()->withErrors($validator)->withInput();

	        	}

		    }

		    else

		    {

		    	$request->session()->flash('error', 'Please provide valid inputs.');

		    	return redirect()->back()->withErrors($validator)->withInput();

		    }

		}

	    

	    // $categories = BlogCategories::getAllCategorySubCategory();
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
	    // $countries = Country::all();
	     $countries = Country::where('id','=','233')->get();

	    // return view("admin/blogs/add", [

	    // 			'categories' => $categories

	    // 		]);

	    return view("admin/blogs/postform/jobs", [

	    			'categories' => $categories,
	    			'countries' => $countries


	    		]);

    }


    function realestae_post(Request $request)

    {

    	if(!Permissions::hasPermission('blogs', 'create'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	  if ($request->isMethod('post')) {
           
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');

             // echo"<pre>"; print_r($request->all());  die;
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',  
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                 if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

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
                 $data['user_id'] = AdminAuth::getLoginId();
                $blog = Blogs::realEstate_create($data);

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

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = AdminAuth::getLoginId();

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                $followers = Users::pluck('email')->toArray();
                $followers_ids = Users::pluck('id');
                $allemail = implode(',', $followers);
            // dd($allemail);
               
                foreach ($followers_ids as $followers_id) {
                    
                    $notice = [
                                'from_id' => 7,
                                'to_id' => $followers_id,
                                'type' => 'Blogpost_front',
                                'rel_id' => $blog->id,
                                'message' => "A new Ad \"{$blog->title}\" is created by FindersPage.",
                                'url' => route('realestate_single', $blog->slug),
                            ];

                            // Assuming Notification model has mass assignable fields defined
                            Notification::create($notice);
                    }
                    $codes = [
                        '{title}' => $blog_postData->title,
                        '{post_url}' => url('/real_esate-post/' . $blog->slug),
                    ];
                    General::sendTemplateEmail(
                        $allemail,
                        'listing-by-admin',
                        $codes
                    );


                    $request->session()->flash('success', 'Ad add successfully.');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Ad could not be updated. Please try again.');
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
                "parent_id = 4",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
	     $countries = Country::where('id','=','233')->get();
	    return view("admin/blogs/postform/realestate", [

	    			'categories' => $categories,
	    			'countries' => $countries


	    		]);

    }






     public function edit_realestate(Request $request ,$id)
    {
        if(!Permissions::hasPermission('blogs', 'create'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}
        
        if ($request->isMethod('post')) {
           
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');
            // $poll_option = isset($data['poll_option'])?$data['poll_option']:array();
            unset($data['_token']);
            unset($data['poll_question']);
            // unset($data['poll_option']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'title' => 'required',
                    'sub_category' => 'required',
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                 if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

                if ($categories && $subCategories) {
                }
               
                $feature = $request->feature;
                unset($data['sub_category']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                // $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::realEstate_edit($id,$data);

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
                    // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();

                    

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = UserAuth::getLoginUser();

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                    $request->session()->flash('success', 'Ad updated successfully.');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Ad could not be update. Please try again.');
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
        $blog = Blogs::find($id);
        //echo"<pre>"; print_r($countries); echo "</pre>";

        return view(
            "admin/blogs/postform/edit_realestate",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' => $blog,
            ]
        );
        // return view('frontend.dashboard_pages.realestate');
    }





    public function shopping(Request $request)
    {   
        if(!Permissions::hasPermission('blogs', 'create'))
        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

        }
        
        if ($request->isMethod('post')) {
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');
            //$poll_option = isset($data['poll_option'])?$data['poll_option']:array();
            // echo"<pre>"; print_r($request->all());  die;

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
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                 if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

                if ($categories && $subCategories) {

                   
                }

                unset($data['state_name_']);
                unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
               
                $feature = $request->feature;
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                // $data['user_id'] = UserAuth::getLoginId();
               
                $blog = Blogs::shopping_create($data);

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
                    // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();

                    

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = UserAuth::getLoginUser();

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                $followers = Users::pluck('email')->toArray();
                $followers_ids = Users::pluck('id');
                $allemail = implode(',', $followers);
                // dd($allemail);
               
                foreach ($followers_ids as $followers_id) {
                    
                    $notice = [
                                'from_id' => 7,
                                'to_id' => $followers_id,
                                'type' => 'Blogpost_front',
                                'rel_id' => $blog->id,
                                'message' => "A new Ad \"{$blog->title}\" is created by FindersPage.",
                                'url' => route('shopping_single', $blog->slug),
                            ];

                            // Assuming Notification model has mass assignable fields defined
                            Notification::create($notice);
                    }
                    $codes = [
                        '{title}' => $blog_postData->title,
                        '{post_url}' => url('/shopping-post-single/' . $blog->slug),
                    ];

                    try {
                        General::sendTemplateEmail(
                            $allemail,
                            'listing-by-admin',
                            $codes
                        );

                    } catch (\Exception $e) {
                        \Log::error('Error sending email: ' . $e->getMessage());
                        // You can handle the error here, like logging and continuing
                    }


                    $request->session()->flash('success', 'Product created successfully ...!!');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
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

        return view(
            "admin/blogs/postform/shopping",
            [
                'sub_blog_categories' => $sub_blog_categories,
                'countries' => $countries,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');
    }



    public function shopping_edit(Request $request , $id)
    {   
          if(!Permissions::hasPermission('blogs', 'create'))

        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

        }
        
        if ($request->isMethod('post')) {

            
           
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');
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
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                 if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

                if ($categories && $subCategories) {
                }

               
                $feature = $request->feature;
                unset($data['sub_category']);
                unset($data['feature']);
                $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;
                $data['product_color'] = isset($data['product_color']) && $data['product_color'] ? implode('|', $data['product_color']) : null;
                // $data['user_id'] = UserAuth::getLoginId();
                // dd($data);
                $blog = Blogs::shopping_edit($id ,$data);

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
                    // You can store the image path in the database or perform any other necessary actions here.
                    }
                    $blog->save();

                    

                    if (!empty($categories)) {
                        Blogs::handleCategories($blog->id, $categories);
                    }

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = UserAuth::getLoginUser();

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                    $request->session()->flash('success', 'Product Updated successfully ...!!');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
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
        $blog = Blogs::find($id);
        return view(
            "admin.blogs.postform.edit_shopping",
            [
                'sub_blog_categories' => $sub_blog_categories,
                'countries' => $countries,
                'blog' => $blog,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');
    }


public function services(Request $request)
    {   
          if(!Permissions::hasPermission('blogs', 'create'))

        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

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
                    'sub_category' => 'required',
                ]
            );
            if (!$validator->fails()) {
                $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                 if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }

                if ($categories && $subCategories) {

                    // $data['city_name'] = isset($data['city_name_']) ? $data['city_name_'] : '';
                    // $data['state_name'] = isset($data['state_name_']) ? $data['state_name_'] : '';
                    // $data['country'] = isset($data['event_country']) ? $data['event_country'] : '';
                    // $data['zipcode'] = isset($data['event_zipcode']) ? $data['event_zipcode'] : '';

                     
                }

                unset($data['state_name_']);
                // unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
               
                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = AdminAuth::getLoginId();
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

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                    // $user = AdminAuth::getLoginUser();

                    // // dd($user);

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                    $followers = Users::pluck('email')->toArray();
                $followers_ids = Users::pluck('id');
                $allemail = implode(',', $followers);
            // dd($allemail);
               
                foreach ($followers_ids as $followers_id) {
                    
                    $notice = [
                                'from_id' => 7,
                                'to_id' => $followers_id,
                                'type' => 'Blogpost_front',
                                'rel_id' => $blog->id,
                                'message' => "A new Ad \"{$blog->title}\" is created by FindersPage.",
                                'url' => route('service_single', $blog->slug),
                            ];

                            // Assuming Notification model has mass assignable fields defined
                            Notification::create($notice);
                    }
                    $codes = [
                        '{title}' => $blog_postData->title,
                        '{post_url}' => url('/service-single/' . $blog->slug),
                    ];

                    try {
                        General::sendTemplateEmail(
                            $allemail,
                            'listing-by-admin',
                            $codes
                        );

                    } catch (\Exception $e) {
                        \Log::error('Error sending email: ' . $e->getMessage());
                        // You can handle the error here, like logging and continuing
                    }


                    $request->session()->flash('success', 'Post Created Successfully..!!');
                    return redirect()->route('admin.blogs');
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
               "parent_id = 705",
                
            ],
            'title asc',
            
        );
        $countries = Country::where('id', '233')->get();

        return view(
            "admin.blogs.postform.add_services",
            [
                'categories' => $categories,
                'countries' => $countries,
            ]
        );
        // return view('frontend.dashboard_pages.shopping');
    }


    public function Service_edit(Request $request , $id)
    {

        if(!Permissions::hasPermission('blogs', 'create'))

        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

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
                    // 'service_date' => 'required|date',
                    // 'service_time' => 'required',
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

                unset($data['state_name_']);
                // unset($data['event_country']);
                unset($data['city_name_']);
                unset($data['event_zipcode']);
                unset($data['categories']);
               
                $feature = $request->feature;
                unset($data['sub_categories']);
                unset($data['feature']);
                $data['user_id'] = AdminAuth::getLoginId();
                
                $blog = Blogs::Service_update($id, $data);
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

                    if (!empty($categories)) {
                        Blogs::handleSubCategories($blog->id, $subCategories);
                    }


                   // $user = AdminAuth::getLoginUser();

                    // dd($user);

                    // if ($feature == "feature_post") {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // } else {
                    //     $notice = [
                    //         'from_id' => AdminAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    // }

                    $request->session()->flash('success', 'Post updated successfully.');
                    return redirect()->route('admin.blogs');
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
               "parent_id = 705",
                
            ],
            'title asc',
            
        );
        $countries = Country::where('id', '233')->get();
        $blog = Blogs::find($id);
        return view(
            "admin.blogs.postform.edit_services",
            [
                'categories' => $categories,
                'countries' => $countries,
                'blog' =>  $blog,
            ]
        );
    }




    public function event_add(Request $request)
    {
        if(!Permissions::hasPermission('blogs', 'create'))

        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

        }
        
        if ($request->isMethod('post')) {
         // echo "<pre>"; print_r($request->all());die();
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');
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
                $data['user_id'] = AdminAuth::getLoginId();
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

                    // if (!empty($categories)) {
                    //     Blogs::handleSubCategories($blog->id, $subCategories);
                    // }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = UserAuth::getLoginUser();
                    //   // dd($data['post_type']);
                    // if ($request->post_type == "Feature Post") {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    // }elseif($request->post_type == "Bump Post") {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new Bump Post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    // }else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);

                    //     $codes = [
                    //         '{name}' => $user->first_name,
                    //         '{post_url}' => route('jobpost', ['id' => $blog->id]),
                    //         '{post_description}' =>  $user->description,

                    //     ];
  
                    //     General::sendTemplateEmail(
                    //         $user->email,
                    //         'feature-post',
                    //         $codes
                    //     );
                    // }
                    
                    $request->session()->flash('success', 'Your post is created and still under process.Once the admin approves it, your post will be live on website.Thank you for your patience.');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Post could not be save. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $countries = Country::where('id','233')->get();
        
        return view(
            "admin.blogs.postform.addEvent",
            [
                'countries' => $countries,
            ]
        );
    }



    public function edit_event_post(Request $request, $id)
    {
        if(!Permissions::hasPermission('blogs', 'create'))

        {

            $request->session()->flash('error', 'Permission denied.');

            return redirect()->route('admin.dashboard');

        }
        
        if ($request->isMethod('post')) {
         // echo "<pre>"; print_r($request->all());die();
            $data = $request->toArray();
            $question = isset($data['poll_question'])?$data['poll_question']:'';
            $poll_option = array('Yes','No','May Be');
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
                $data['user_id'] = AdminAuth::getLoginId();
                // dd($data);
                $blog = Blogs::editevent($data,$id);

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

                    // if (!empty($categories)) {
                    //     Blogs::handleSubCategories($blog->id, $subCategories);
                    // }


                     if($question != '' && count($poll_option) > 0) {
                       $ques = array('title' => $question, 'post_id' => $blog->id);
                       $quesid = DB::table('poll_questions')->insertGetId($ques);
                       if($quesid) {
                        $options = array();
                        foreach ($poll_option as $k => $o) {
                            $options[$k]['title'] = $o;
                            $options[$k]['question_id'] = $quesid;
                            $options[$k]['post_id'] = $blog->id;
                        }
                            DB::table('poll_options')->insert($options);
                       }
                    }

                    // $user = UserAuth::getLoginUser();

                    // if ($request->post_type == "Feature Post") {
                    //     if($blog->featured_post == null){
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new featured post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    // }elseif($request->post_type == "Bump Post") {
                    //     if($blog->bumpPost == null){
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new Bump Post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     return redirect()->route('stripe.createstripe.bump', ['post_id' => General::encrypt($blog->id)]);
                    //     }
                    
                    // } else {
                    //     $notice = [
                    //         'from_id' => UserAuth::getLoginId(),
                    //         'to_id' => 7,
                    //         'message' => 'A new post '.$data['title']. ' is created by '.$user->first_name,
                    //     ];
                    //     Notification::create($notice);
                    //     $codes = [
                    //         '{name}' => $user->first_name,
                    //         '{post_url}' => route('jobpost', ['id' => $blog->id]),
                    //         '{post_description}' =>  $user->description,

                    //     ];
  
                    //     General::sendTemplateEmail(
                    //         $user->email,
                    //         'feature-post',
                    //         $codes
                    //     );
                    // }
                    
                    $request->session()->flash('success', 'Your post is updated.');
                    return redirect()->route('admin.blogs');
                } else {
                    $request->session()->flash('error', 'Post could not be update. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $countries = Country::where('id','233')->get();
         $blog = Blogs::find($id);
        return view(
            "admin.blogs.postform.editEvent",
            [
                'countries' => $countries,
                'blog' => $blog
            ]
        );
    }







    function edit(Request $request, $id)

    {

    	if(!Permissions::hasPermission('blogs', 'update'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$blog = Blogs::get($id);
		$category = BlogCategoryRelation::where('blog_id', $id)->get();
		$category = json_decode($category, true);
		


    	if($blog)

    	{

	    	if($request->isMethod('post'))

	    	{

	    		$data = $request->toArray();

	    		$validator = Validator::make(

		            $request->toArray(),

		            [

		                'title' => [

		                	'required',

		                	// Rule::unique('blogs')->ignore($blog->id)

		                ],

		                'description' => 'required'

		            ]

		        );



		        if(!$validator->fails())

		        {

		        	unset($data['_token']);

		        	if(isset($data['image1']) && $data['image1'])

		        	{

			       if ($request->hasFile('image1')) {
                        $images = $request->file('image1');
                        $imageNames = [];

                        foreach ($images as $image) {
                            $name = time() . '_' . $image->getClientOriginalName();
                            $destinationPath = public_path('/images_blog_img');
                            $image->move($destinationPath, $name);
                            $imageNames[] = $name;
                        }

                        $data['image1'] = $imageNames;
                    }
				
		        	}

		        	else

		        	{

		        		unset($data['image1']);

		        		

		        	}


		        	if(isset($data['post_video']) && $data['post_video'])

		        	{
				if ($request->hasFile('post_video')) {
		                    $video = $request->file('post_video');
		                    $videoName = time() . '.' . $video->getClientOriginalExtension();
		                    $video->move(public_path('images_blog_video'), $videoName);
		                    $data['post_video'] = $videoName;
	                    	}

		        		// $oldImage = $blog->image;

		        	}

		        	else

		        	{

		        		unset($data['post_video']);

		        		

		        	}

		        	/** IN CASE OF SINGLE UPLOAD **/



		        	$categories = [];

		        	if(isset($data['category']) && $data['category']) {

		        		$categories = $data['category'];

		        	}

		        	unset($data['category']);

		        	 // $data['choices'] = isset($data['choices']) && $data['choices'] ? implode('|', $data['choices']) : null;

		        	if(Blogs::modify($id, $data))

		        	{

		        		/** IN CASE OF SINGLE UPLOAD **/

		        		if(isset($oldImage) && $oldImage)

		        		{

		        			FileSystem::deleteFile($oldImage);

		        		}

		        		/** IN CASE OF SINGLE UPLOAD **/



		        		if(!empty($categories))

		        		{

		        			Blogs::handleCategories($blog->id, $categories);

		        		}



		        		$request->session()->flash('success', 'Blog updated successfully.');

		        		return redirect()->route('admin.blogs');

		        	}

		        	else

		        	{

		        		$request->session()->flash('error', 'Blog could not be save. Please try again.');

			    		return redirect()->back()->withErrors($validator)->withInput();

		        	}

			    }

			    else

			    {

			    	$request->session()->flash('error', 'Please provide valid inputs.');

			    	return redirect()->back()->withErrors($validator)->withInput();

			    }

			}

			$countries = Country::where('id','=','233')->get();
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

		return view("admin/blogs/postform/edit_job", [

			'blog' => $blog,

			'categories' => $categories,
			'category' => $category,
			'countries' => $countries,

    		]);

		}

		else

		{

			abort(404);

		}

    }



    function delete(Request $request, $id)

    {

    	if(!Permissions::hasPermission('blogs', 'delete'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$blog = Blogs::find($id);

    	if($blog->delete())

    	{

    		$request->session()->flash('success', 'Blog deleted successfully.');

    		return redirect()->route('admin.blogs');

    	}

    	else

    	{

    		$request->session()->flash('error', 'Blog could not be delete.');

    		return redirect()->route('admin.blogs');

    	}

    }



    function bulkActions(Request $request, $action)

    {

    	if( ($action != 'delete' && !Permissions::hasPermission('blogs', 'update')) || ($action == 'delete' && !Permissions::hasPermission('blogs', 'delete')) ) 

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$ids = $request->get('ids');

    	if(is_array($ids) && !empty($ids))

    	{

    		switch ($action) {

    			case 'active':

    				Blogs::modifyAll($ids, [

    					'status' => 1

    				]);

    				$message = count($ids) . ' records has been published.';

    			break;

    			case 'inactive':

    				Blogs::modifyAll($ids, [

    					'status' => 0

    				]);

    				$message = count($ids) . ' records has been unpublished.';

    			break;

    			case 'delete':

    				Blogs::removeAll($ids);

    				$message = count($ids) . ' records has been deleted.';

    			break;

    		}



    		$request->session()->flash('success', $message);



    		return Response()->json([

    			'status' => 'success',

	            'message' => $message,

	        ], 200);		

    	}

    	else

    	{

    		return Response()->json([

    			'status' => 'error',

	            'message' => 'Please select atleast one record.',

	        ], 200);	

    	}

    }


    function fetured_post(){
    $blog =	Blogs::all();
    return view('admin.blogs.featuredpost' , compact($blog));

    }



     public function fetch_state_job(Request $request)
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

    public function fetch_city_job(Request $request)
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

    public function payment_get()
    {
        $post_payments_type = DB::table('post_payments')->pluck('type');
        //  dd($post_payments_type);
         foreach($post_payments_type as $type){
            if($type == 'listing'){
                $payments = DB::table('post_payments')
                ->leftJoin('blogs', 'post_payments.post_id', '=', 'blogs.id')
                ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
                ->orderByDesc('post_payments.id')
                ->select('post_payments.*', 'blogs.title','blogs.slug', 'blogs.bumpPost', 'blogs.featured_post','users.id as blogs.user_id','users.username')
                ->get();
            }elseif($type == 'blog'){
                $payments = DB::table('post_payments')
                ->leftJoin('blog_post', 'post_payments.post_id', '=', 'blog_post.id')
                ->leftJoin('users', 'blog_post.user_id', '=', 'users.id')
                ->orderByDesc('post_payments.id')
                ->select('post_payments.*', 'blog_post.title','blog_post.slug', 'blog_post.bumpPost', 'blog_post.featured_post','users.id as user_id','users.username')
                ->get();
            }elseif($type == 'Entertainment'){
                $payments = DB::table('post_payments')
                ->leftJoin('Entertainment', 'Entertainment.post_id', '=', 'Entertainment.id')
                ->leftJoin('users', 'Entertainment.user_id', '=', 'users.id')
                ->orderByDesc('post_payments.id')
                ->select('post_payments.*', 'Entertainment.title','Entertainment.slug', 'Entertainment.bumpPost', 'Entertainment.featured_post','users.id as user_id','users.username')
                ->get();
            }elseif($type == 'subscription'){
                $payments = DB::table('post_payments')
                ->leftJoin('users', 'post_payments.user_id', '=', 'users.id')
                ->orderByDesc('post_payments.id')
                ->select('post_payments.*','users.id as user_id','users.username')
                ->get();
            }

         }
        
        //   dd($payments);
        return view('admin.payments.payment_list',compact('payments'));
    }

    public function blogForm()
    {
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
        return view('admin.blog_Post.add',compact('categories'));
    }


public function blogFormsave(Request $request)
{
    $blog_post = new BlogPost();
    $blog_post = $blog_post->addBlogpost($request);
    // dd($blog_post);
    $lastInsertedId = BlogPost::orderBy('id', 'desc')->value('id');
    if (!empty($blog_post) ){
        $request->session()->flash('error', 'Post could not be updated. Please try again.');
        return redirect()->back();
    } else {
        // Get follower details
       
        $followers = Users::pluck('email')->toArray();
        $followers_ids = Users::pluck('id');
        $allemail = implode(',', $followers);
    // dd($allemail);
        $blog_postData = BlogPost::find($lastInsertedId);
        foreach ($followers_ids as $followers_id) {
            
            $notice = [
                        'from_id' => 7,
                        'to_id' => $followers_id,
                        'type' => 'Blogpost_front',
                        'rel_id' => $blog_postData->id,
                        'url' => route('blogPostSingle', $blog_postData->slug),
                        'message' => "A new post \"{$blog_postData->title}\" is created by FindersPage.",
                    ];

                    // Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
            }
            $codes = [
                '{title}' => $blog_postData->title,
                '{post_url}' => url('/blogs/' . $blog_postData->slug),
            ];

            try {
                General::sendEmailcc(
                    $followers,
                    'Blogs-by-admin',
                    $codes,
                );

            } catch (\Exception $e) {
                \Log::error('Error sending email: ' . $e->getMessage());
                // You can handle the error here, like logging and continuing
            }
        
            $request->session()->flash('success', 'Blog updated successfully.');
        return redirect()->route('blog_post_list');
        
    }
}


public function checkemail_cc(){
    $followers= ['wasim125560@gmail.com','simba@yopmail.com','smith@yopmail.com'];
    $codes = [
        '{title}' => 'hello testing',
        '{post_url}' => url('/blogs/'),
    ];

    try {
        General::sendEmailcc(
            $followers,
            'Blogs-by-admin',
            $codes,
        );
        dd('mail send successfully.');

    } catch (\Exception $e) {
        \Log::error('Error sending email: ' . $e->getMessage());
        // You can handle the error here, like logging and continuing
    }
}




    public function blogList(Request $request)
    {
        $blog_post = BlogPost::orderByDesc('created_at')->get();
       // $blog_post =  BlogPost::where("posted_by","admin")->get();
       // $categories = BlogCategories::getAll(
       //      [
       //          'id',
       //          'title',
       //          'slug',
       //          'image',
       //      ],
       //      [
       //          "parent_id =728",
       //          "blog_categories.status=0",
       //      ],
       //      'title asc',
       //  );
        return view('admin.blog_Post.list',compact('blog_post'));
       
    }


     public function blogUpdate_status(Request $request)
    {
        
        $blog =  BlogPost::where('id', $request->id)->first();
        if($blog){
            BlogPost::where('id', $request->id)->update(['status' => $request->status, 'created_at' => now()]);
            // dd($blog);
            $usert =  User::where('id', $blog->user_id)->first();
            if($request->status == 1){
                $message = 'Your post '.$blog->title.'  is approved.';
            }else{
                 $message = 'Your post '.$blog->title.'  is not approved.';
            }
            $notice = [
                    'from_id' => AdminAuth::getLoginId(),
                    'to_id' => $blog->user_id,
                    'type' =>'approve',
                    'message' => $message,
                    'notification_by' => '1',
                    'url' => route('blogPostSingle', $blog->slug),
                ];
                    Notification::create($notice);


            // Assuming you have models for Follow and Users
            // dd($request->user_id);
            // Retrieve followers
            $followers = Follow::where('follower_id', $blog->user_id)->pluck('following_id')->toArray();
               // dd($followers);
            foreach ($followers as $followerId) {
                // Retrieve follower details
                $followerDetails = Users::find($followerId);

                // Check if follower details are found
                if ($followerDetails) {
                    // Access individual follower details
                    $followerUserId = $followerDetails->id;
                    $followerFirstName = $followerDetails->first_name;

                    // Create notification
                    $notice = [
                        'from_id' => $blog->user_id,
                        'to_id' => $followerUserId,
                        'type' => 'Blogpost_front',
                        'rel_id' => $blog->id,
                        'cate_id' => $request->cateID,
                        'message' => "A new post \"{$blog->title}\" is created by {$usert->first_name}.",
                        'url' => route('blogPostSingle', $blog->slug),
                    ];

                    // Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
                    $image_url = asset('images_blog_img').'/'.$blog->image;
                    $post_url = route('blogPostSingle',$blog->slug);
                    $codes = [
                        '{name}' => $usert->first_name,
                        '{title}' => $blog->title,
                        '{image}' => $image_url,
                        '{post_url}' => $post_url,
                        '{posted_date}' => $blog->created_at,

                    ];

                General::sendTemplateEmail(
                    $followerDetails->email,
                    'post-notification-member',
                    $codes
                );
                    }
                 }   
            $codes = [
                        '{first_name}' => $usert->first_name,
                        '{post_url}' => route('blogPostSingle',$blog->slug),
                    ];

                General::sendTemplateEmail(
                    $usert->email,
                    'post-approved-by-admin',
                    $codes
                );
          //dd($usert);
            return response()->json(['Post_success' => 'Post updated successfully.']); 

        }
    }

    public function blogedit($slug)
    {
       $blog_post =  BlogPost::where('slug',$slug)->first();
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
        return view('admin.blog_Post.edit',compact('categories','blog_post'));
       
    }

    public function blogupdate(Request $request,$slug)
    {
       $blog_post =  BlogPost::where('slug',$slug)->first();
       $blog_post = $blog_post->updateBlogpost($request);

       if(!empty($blog_post)){
       $request->session()->flash('error', 'Post could not be update. Please try again.');
         return redirect()->back();
       }else{
         $request->session()->flash('success', 'Post updated successfully.');
         return redirect()->route('blog_post_list');
       }
       
    }

    public function blogdelete($id)
    {
       $blog_post =  BlogPost::find($id);
       $blog_post->delete();
       if(!empty($blog_post)){
       
         return redirect()->back();
       }else{
         return redirect()->route('blog_post_list');
       }
       
    }

    public function getReportedPost()
    {
        $PostReport = DB::table('post_reports')
            ->join('blog_category_relation', 'post_reports.post_id', '=', 'blog_category_relation.blog_id')
            ->select('post_reports.id', 'post_reports.post_id', 'post_reports.reason', 'post_reports.type', 'post_reports.reported_by', 'blog_category_relation.category_id')
            ->groupBy('post_reports.id')
            ->get();
    
        $user_ids = $PostReport->pluck('reported_by')->unique();
        $users = Users::whereIn('id', $user_ids)->get();
    
        $post_ids = $PostReport->pluck('post_id')->unique();
        $blogPosts = BlogPost::whereIn('id', $post_ids)->pluck('slug', 'id');
    
        // Attach slugs to PostReport items
        $PostReport = $PostReport->map(function ($report) use ($blogPosts) {
            $report->slug = $blogPosts->get($report->post_id, '');
            return $report;
        });
    
        return view('admin/blogs/postform/reportedPosts', compact('PostReport', 'users'));
    }
    


    public function Delete_ReportedPost($id)
        {
            // dd($id);
            $report = PostReport::find($id);
            $report = $report->delete();
            if($report){
                return redirect()->back()->with(['success','deleted Successfully.!!']);
            }else{
                return redirect()->back()->with(['error','somthing went wrong!!']);
            }
        }


    public function DeleteReportedPost($id)
    {
         // dd($id);
        $report = PostReport::find($id);
        $report = $report->delete();
        if($report){
            return redirect()->back()->with(['success','deleted Successfully.!!']);
        }else{
            return redirect()->back()->with(['error','somthing went wrong!!']);
        }
    }

    public function getSupportTicket()
    {
        $supports = Support::join('users', 'supports.user_id', '=', 'users.id')
        ->select('users.id as user_id','users.email', 'users.first_name', 'supports.*')
        ->get();
        // dd($supports);
        $new = Support::where('ticket_status',0)->count();
        $open = Support::where('ticket_status',1)->count();
        $inprogress = Support::where('ticket_status',2)->count();
        $close = Support::where('ticket_status',3)->count();
        
        return view('admin/blogs/postform/supportTicketListing',compact('supports','new','open','inprogress','close'));    
    }



    public function getUserReviews()
    {
        $reviews = reviewModel::join('users', 'review.user_id', '=', 'users.id')
        ->select('users.id as user_id','users.email', 'users.first_name','users.image','review.*')
        ->get();
        
        // dd($reviews);
        return view('admin/reviews/reviewList',compact('reviews'));    
    }


     public function UpdateUserReviews(Request $request)
    {
      

        $reviews = reviewModel::where('id',$request->id)->update(['status' => $request->status]);
        if($reviews){
            return response()->json(['success' => 'Review added to show case.']);
        }else{
           return response()->json(['error' => 'Somthing went wrong.']); 
        }
        

  
    }


    public function DeleteUserReviews($id)
    {
      

        $reviews = reviewModel::find($id);
        $reviews =$reviews->delete();

        if($reviews){
            return redirect()->back()->with(['success' => 'Review deleted successfully.']);
        }else{
           return redirect()->back()->with(['error' => 'Somthing went wrong.']); 
        }
        

  
    }



    public function update_SupportTicket_status(Request $request)
    {
        if($request->status == 1){

            $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $request->user_id,
                        'type' =>'ticket',
                        'message' => 'Your ticket status is open .Our support team will revert you within 24 hours.',
                    ];
                    Notification::create($notice);

        }elseif($request->status == 2){
            $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $request->user_id,
                        'type' =>'ticket',
                        'message' => 'Your ticket status is In-progress . Our support team will revert you within 24 hours.',
                    ];
                    Notification::create($notice);
        }elseif($request->status == 3){

            $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $request->user_id,
                        'type' =>'ticket',
                        'message' => 'Your ticket status is close .',
                    ];
                    Notification::create($notice);
        }
       $update_ststus = Support::where('id',$request->id)->update(['ticket_status' => $request->status]);
        
        if(!empty($update_ststus)){

            return response()->json(['success' => 'Ticket status updated successfully.']);
        }else{
            return response()->json(['error' => 'Somthing went wrong. Please try again later.']);
        }
    }



    public function update_video_status(Request $request)
    {
        $update_ststus = Video::where('id',$request->id)->update(['status' => $request->status ,'draft' =>1]);
        $video = Video::find($request->id);
        if($request->status == 1){

            $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $request->user_id,
                        'type' =>'video',
                        'message' => 'Your video is published.',
                        'notification_by' => '1',

                    ];
                    Notification::create($notice);


            // Assuming you have models for Follow and Users

            // Retrieve followers
            $followers = Follow::where('follower_id', $request->user_id)->pluck('following_id')->toArray();
             // dd($followers);
            foreach ($followers as $followerId) {
                // Retrieve follower details
                $followerDetails = Users::find($followerId);

                // Check if follower details are found
                if ($followerDetails) {
                    // Access individual follower details
                    $followerUserId = $followerDetails->id;
                    $followerFirstName = $followerDetails->first_name;

                    // Create notification
                    $notice = [
                        'from_id' => $request->user_id,
                        'to_id' => $followerUserId,
                        'type' => 'video_front',
                        'rel_id' => $video->id,
                        'message' => "A new post \"{$video->title}\" is created by {$followerFirstName}.",
                    ];

                    // Assuming Notification model has mass assignable fields defined
                    Notification::create($notice);
                } else {
                    // Handle the case where follower details are not found
                    // This might happen if the user with $followerId doesn't exist
                    // You can log an error or handle it based on your application's requirements
                }
            }

        }elseif($request->status == 0){
            $notice = [
                        'from_id' => AdminAuth::getLoginId(),
                        'to_id' => $request->user_id,
                        'type' =>'video',
                        'message' => 'Your video is unpublished by our team.',
                        'notification_by' => '1',
                    ];
                    Notification::create($notice);
        }
       
        
        if(!empty($update_ststus)){

            return response()->json(['success' => 'Video status updated successfully.']);
        }else{
            return response()->json(['error' => 'Somthing went wrong. Please try again later.']);
        }
    }


    public function EmailSupportTicket(Request $request)
    {     
    // dd($request->all);  
        if(!empty($request->message)){
            $codes = [
                        '{message}'=>$request->message,
                     ];
                     // dd($codes);
                $email = General::sendTemplateEmail(
                        $request->email,
                        'news-latter-mail',
                        $codes
                    );
             if($email){
                return redirect()->back()->with(['success' => 'Email sent successfully']);  
             }else{
                return redirect()->back()->with(['error' => 'Email not sent. Somthing went wrong.']);   
             }       
           
        }else{
            return redirect()->back()->with(['error' => 'Please provide valid input']);
        }
                    

    }



    public function get_productReview($id)
    {     
        $ProductReview  = ProductReview::where('product_id',$id)->get();

        return view('admin.blogs.productreview',compact('ProductReview'));
    }


    public function delete_productReview($id)
    {     
        $ProductReview  = ProductReview::where('id',$id)->first();
        $ProductReview = $ProductReview->delete();
        if($ProductReview){
            return redirect()->back()->with(['success' => 'Review deleted successfully.']);
        }else{
            return redirect()->back()->with(['error' => 'somthing went wrong.']);
        }
       
    }

}

