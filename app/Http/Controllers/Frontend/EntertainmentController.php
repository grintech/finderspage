<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategories;
use App\Models\Entertainment;
use App\Models\Blogs;
use App\Models\Like;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\Admin\Notification;
use App\Models\Admin\SubPlan;
use App\Libraries\General;
use Auth;
use DB;
use App\Models\ListingViews;

class EntertainmentController extends Controller
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
                "parent_id =741",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        return view('frontend.dashboard_pages.entertainment',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listingEntertainment()
    {
        $list =  Entertainment::where('user_id');
        return view('frontend.dashboard_pages.entertainment',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
         $data = $request->toArray();
         unset($data['_token']);
        $Entertainment = new Entertainment();

        $subCategories = $categories = [];
                if (isset($data['categories']) && $data['categories']) {
                    $categories = $data['categories'];
                }

                if (isset($data['sub_category']) && $data['sub_category']) {
                    $subCategories = $data['sub_category'];
                }
         
        unset($data['categories']);
         $Entertainment =  $Entertainment->add_Entertainment($data);
         $lastInsertedId = Entertainment::orderBy('id', 'desc')->value('id');
         $entertainment_post =  Entertainment::where('id' , $lastInsertedId)->first();
        if (!empty($categories)) {
            Blogs::handleCategories($lastInsertedId, $categories);
        }

        if (!empty($subCategories)) {
            Blogs::handleSubCategories($lastInsertedId, $subCategories);
        }
        if(empty($Entertainment)){
            $user = UserAuth::getLoginUser();
                      // dd($data['post_type']);
                    if ($request->post_type == "Feature Post") {
                        if(!empty($user->featured_post_count ) && $user->featured_post_count > 0 || $user->featured_post_count == 'Unlimited'){
                            if($user->featured_post_count == 'Unlimited'){
                                $new_post_count ='Unlimited';
                            }else{
                                $new_post_count = (int) $user->featured_post_count - 1;
                            }
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Entertainment::where('id', $entertainment_post->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 741,
                                'rel_id' => $entertainment_post->id,
                                'type' => 'feature',
                                'message' => "A featured entertainment post \"{$data['title']}\" is created by {$user->username}.",
                                'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                            ];
                            Notification::create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your post. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                            
                        }else{
                            return redirect()->route('paypal.featured_post.entertainment', ['post_id' => General::encrypt($lastInsertedId)]);
                        }
                        
                    }elseif($request->post_type == "Bump Post") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 741,
                            'type' => 'bump',
                            'rel_id' => $entertainment_post->id,
                            'message' => "A new bump entertainment post \"{$data['title']}\" is created by {$user->username}.",
                            'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                        ];
                        Notification::create($notice);
                        return redirect()->route('paypal.featured_post.entertainment', ['post_id' => General::encrypt($lastInsertedId)]);
                    }else {
                        if($user->featured_post_count == 'Unlimited'){
                            $new_post_count ='Unlimited';
                            Users::where('id', $user->id)->update(['featured_post_count' => $new_post_count]);
                            Entertainment::where('id', $blog->id)->update(['draft'=> 1,'featured_post' => 'on']);
                            $notice = [
                                'from_id' => UserAuth::getLoginId(),
                                'to_id' => 7,
                                'cate_id' => 741,
                                'type' => 'feature',
                                'rel_id' => $entertainment_post->id,
                                'message' => "A new featured entertainment post \"{$data['title']}\" is created by {$user->username}.",
                                'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                                ];
                            Notification::create($notice); 
                           
                            $request->session()->flash('success', 'Thanks for your post. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                        }
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 741,
                            'type' => 'entertainment',
                            'rel_id' => $entertainment_post->id,
                            'message' => "A new entertainment post \"{$data['title']}\" is created by {$user->username}.",
                            'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                        ];
                        Notification::create($notice);

                        $codes = [
                            '{name}' => $user->first_name,
                            '{post_url}' => route('Entertainment.single.listing', $entertainment_post->slug),
                            '{post_description}' =>  $user->description,

                        ];
  
                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                    }
                    
                    $request->session()->flash('success', 'Thanks for your post. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
                    return redirect()->route('Entertainment.d-list');
                    }
                    $request->session()->flash('error', 'Somthing went wrong.');
                                return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listing_D_Entertainment()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $Entertainment = Entertainment::where('user_id',UserAuth::getLoginId())->get();

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

        return view('frontend.dashboard_pages.entertainmentlist', compact('Entertainment', 'plan_week', 'plan_month', 'plan_3month', 'plan_6month', 'plan_year'));
    }

    public function single_listing($slug)
    {
        $Entertainment = Entertainment::where('slug',$slug)->first(); 
        $id = $Entertainment->id;
        $previousPostId = Entertainment::where('id', '<', $id)->orderBy('id', 'desc')->pluck('id')->first();
        $shareComponent = \Share::page(
            'https://www.finderspage.com/Entertainment/single/listing/' . $slug,
            'Your share text comes here',
        )
            ->facebook($slug)
            ->twitter($slug)
            ->linkedin($slug)
            ->telegram($slug)
            ->whatsapp($slug)
            ->pinterest($slug);
            $itemFeaturedImages = trim($Entertainment->image1, '[""]');
            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
            $ogmetaData = [
                'title' => $Entertainment->title,
                 'description' => $Entertainment->description,
                'image' => asset('images_blog_img').'/'.$itemFeaturedImage['0'],
            ];    
        $viewsCount = ListingViews::where('Post_id', $id)->where('type', 'entertainment')->count();
        // Get the next post ID
        $nextPostId = Entertainment::where('id', '>', $id)->orderBy('id', 'asc')->pluck('id')->first();
        $user = Users::where('id',$Entertainment->user_id)->first();

        $BlogLikes = Like::join('Entertainment', 'Entertainment.id', '=', 'likes.blog_id')
            ->where('likes.blog_id',$id)
            ->select('likes.*')
            ->where('likes.type', 'Entertainment')
            ->get();

        $existingRecord = DB::table('saved_post')
            ->where('user_id', UserAuth::getLoginId())
            ->where('post_id', $id)
            ->where('post_type', 'Entertainment')
            ->exists();

        return view('frontend.entertainment.single_listing', compact('Entertainment','existingRecord','user','previousPostId','nextPostId','shareComponent','viewsCount','ogmetaData','BlogLikes') );
    }


    public function listing()
    {
        $Entertainment = Entertainment::where('status', '1')
    ->orderByRaw("CASE WHEN post_type = 'Feature Post' THEN 1 WHEN post_type = 'Bump Post' THEN 2 ELSE 3 END")
    ->get();
        return view('frontend.entertainment.listing', compact('Entertainment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
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
                "parent_id =741",
                "blog_categories.status = 0",
            ],
            'title asc',
        );
        $Entertainment = Entertainment::where('slug',$slug)->first();
        // dd($Entertainment);
        return view('frontend.dashboard_pages.edit_entertainment',compact('Entertainment','categories'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd($request->all());
        if ($request->post_type == "Feature Post") {
                $middleware = app()->make('App\Http\Middleware\CheckSubscriptionPlan');
                $response = $middleware->handle($request, function ($request) {
                   
                });

                if ($response) {
                    return $response; // Return the response from the middleware
                }
            }
        $Entertainment = Entertainment::where('slug',$slug)->first();
        $id=$Entertainment->id;
        if(empty($Entertainment)){
           $request->session()->flash('error', 'Post could not be updated. Please try again.');
             return redirect()->back();
       }else{
         $user = UserAuth::getLoginUser();
         // dd($request->post_type);
                    if ($request->post_type == "Feature Post") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 741,
                            'type' => 'featured',
                            'rel_id' => $id,
                            'message' => "A featured entertainment post \"{$request->title}\" is updated by {$user->username}.",
                            'url' => route('Entertainment.single.listing', $slug),
                        ];
                        Notification::feature_update($notice);
                        return redirect()->route('stripe.feature.Entertainment_update', ['post_id' => General::encrypt($id)]);
                    }elseif($request->post_type == "Bump Post") {
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 741,
                            'type' => 'bump',
                            'rel_id' => $id,
                            'message' => "A new bump entertainment post \"{$request->title}\" is updated by {$user->username}.",
                            'url' => route('Entertainment.single.listing', $slug),
                        ];
                        Notification::update_post($notice);
                        return redirect()->route('stripe.createstripe.Entertainment', ['post_id' => General::encrypt($id)]);
                    }else {
                         $Entertainment = $Entertainment->update_Entertainment($request ,$id);
                        $notice = [
                            'from_id' => UserAuth::getLoginId(),
                            'to_id' => 7,
                            'cate_id' => 741,
                            'type' => 'entertainment',
                            'rel_id' => $id,
                            'message' => "A entertainment post \"{$request->title}\" is updated by {$user->username}.",
                            'url' => route('Entertainment.single.listing', $slug),
                        ];
                        Notification::update_post($notice);

                        $codes = [
                            '{name}' => $user->first_name,
                            '{post_url}' => route('Entertainment.single.listing', $slug),
                            '{post_description}' =>  $user->description,

                        ];
  
                        General::sendTemplateEmail(
                            $user->email,
                            'feature-post',
                            $codes
                        );
                    }
                //     if($Entertainment->status == 1){
                //      $request->session()->flash('success', 'Blog post Updated successfully..');
                //     return redirect()->route('Entertainment.d-list');
                // }else{
                    $request->session()->flash('success', 'Updated successfully.');
                    return redirect()->route('Entertainment.d-list');
                    // }
                    // $request->session()->flash('error', 'Somthing went wrong .');
                    //             return redirect()->back();

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
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $Entertainment = Entertainment::find($id); 

      $Entertainment =  $Entertainment->delete();

      if($Entertainment){
        return redirect()->route('Entertainment.d-list')->with(['success','Listing deleted successfully.']);
      }else{
            $request->session()->flash('error', 'Listing could not be deleted.');

            return redirect()->back()->with(['error', 'Listing could not be deleted.']);
        }
      
    }




}
