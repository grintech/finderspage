<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Session;
use Stripe;
use DB;
use App\Libraries\General;
use App\Models\UserAuth;
use Carbon\Carbon;
use App\Models\Admin\Users;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Entertainment;
use App\Models\Business;
use App\Models\Video;
use App\Models\Admin\Notification;
use Exception;
use App\Models\Admin\SubPlan;
use Illuminate\Support\Facades\Redirect;


class PayPalPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bumpPayment($post_id){
        $post_id = General::decrypt($post_id);
        $featurepost = Blogs::where('id', $post_id)->first();
        if($featurepost->bumpPost == 1){
            Session::flash('success', 'Your post is already bumped. Thank you.');  
            return redirect()->back();
        }else{
            return view('frontend.paypal.bump',compact('post_id'));
        }
    }

   public function payment(Request $request,$id,$amt)
    {
    
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success',$id),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amt
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel()
    {
        $featureUser = UserAuth::getLoginUser();

        $codes = [
            '{first_name}' => $featureUser->first_name,
        ];

        General::sendTemplateEmail(
            $featureUser->email,
            'payment-failed-on-finderspage',
            $codes
        );

        return redirect()
              ->back()
              ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess_bump(Request $request, $post_id)
    {
        // dd($post_id,$request->all());
        $post_id = General::decrypt($post_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        
    
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 
                        'bumpPost_start_date' => $start_date, 
                        'bumpPost_end_date' => $end_date
                    ]);
            }

             // Post Updated aginst PostID 
            $featurepost = Blogs::where('id', $post_id)->first();
            if ($featurepost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'subscription',
                'rel_id' => $featurepost->id,
                'message' => "A new bump Ad \"{$featurepost->title}\" is created by {$user->username}.",
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Your Ad \"{$featurepost->title}\" has been bumped.",
            ];
            Notification::create($notice);

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'Bump-post-success',
                $codes
            );
            return redirect()
                ->route('index_user')
                ->with('success', 'Payment successful. Bumped successfully.');
        } else {
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return redirect()
                ->route('index_user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }






        public function payment_for_paid_listing(Request $request)
        {
            //  dd($request->all());
            // $post_id = General::decrypt($request->post_id);
            $post_id = $request->post_id;
            
            $start_date = date('Y-m-d H:i:s');
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            $get_duration = explode('-', $request->planprice);


            $paymentStatus = $request->status;
            $payment_id = $request->paymentID;
            $payment_source = $request->paymentSource;
            $email = $request->email;
            $name = $request->name;
            $user = UserAuth::getLoginUser();      
            $amount = $request->amount;
            $type = $request->type;
    
            if (isset($request['status']) && $request['status'] == 'COMPLETED') {
                DB::table('post_payments')->insert(
                    [
                        'user_id' => $user->id,
                        'payment_id' => $payment_id,
                        'post_id' => $post_id,
                        'duration' => '1-day',
                        'payment_method' => $payment_source,
                        'type' => 'listing',
                        'balance_transaction' =>$amount,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]
                );

                

            $featurepost = Blogs::where('id', $post_id)->first();
            $featureUser = Users::where('id', $user->id)->first();        
           
            if ($featurepost->id) {
                
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Normal Post',
                        'draft' => '1',
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'post',
                'rel_id' => $featurepost->id,
                'message' => "A new Ad \"{$featurepost->title}\" is created by {$user->username}.",
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Payment successful. You have successfully created a Ad: \"{$featurepost->title}.\"",
            ];
            Notification::create($notice);
            if($type == 'services'){
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{URL}' => route('service_single',$featurepost->slug),
                ];
            }elseif($type == 'jobs'){
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{URL}' => route('jobpost',$featurepost->slug),
                ];
            }elseif($type == "fundraiser"){
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{URL}' => route('single.fundraisers',$featurepost->slug),
                ];
            }


            General::sendTemplateEmail(
                $featureUser->email,
                'Paid-Listing',
                $codes
            );
                return response()
                    ->json(['success'=>'Payment successful. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.']);
            } else {
                $featureUser = UserAuth::getLoginUser();

                $codes = [
                    '{first_name}' => $featureUser->first_name,
                ];
        
                General::sendTemplateEmail(
                    $featureUser->email,
                    'payment-failed-on-finderspage',
                    $codes
                );
                return response()
                    ->json(['error'=> 'Something went wrong.']);
            }
        }


        public function payment_bump_Success_blog_bump(Request $request)
        {
            // $post_id = General::decrypt($request->post_id);
            $post_id = $request->post_id;
            
            $start_date = date('Y-m-d H:i:s');
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            $get_duration = explode('-', $request->planprice);


            $paymentStatus = $request->status;
            $payment_id = $request->paymentID;
            $payment_source = $request->paymentSource;
            $email = $request->email;
            $name = $request->name;
            $user = UserAuth::getLoginUser();      
            $amount = 5;
    
            if (isset($request['status']) && $request['status'] == 'COMPLETED') {
                DB::table('post_payments')->insert(
                    [
                        'user_id' => $user->id,
                        'payment_id' => $payment_id,
                        'post_id' => $post_id,
                        'payment_method' => $payment_source,
                        'duration' => '1-day',
                        'type' => 'blog',
                        'balance_transaction' =>$amount,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]
                );

                $user_id = UserAuth::getLoginId();
                $featureUser = Users::where('id', $user_id)->first();
                if ($post_id && $user_id) {
                    DB::table('users')
                        ->where('id', $user_id)
                        ->limit(1)
                        ->update([
                            'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                        ]);
                }
    
                 // Post Updated aginst PostID 
                $Blog_post = BlogPost::where('id', $post_id)->first();
                if ($Blog_post->id) {
                    DB::table('blog_post')
                        ->where('id', $post_id)
                        ->limit(1)
                        ->update([
                            'bumpPost' => '1',
                            'bump_start' => $start_date,
                            'bump_end' => $end_date,
                        ]);
                }
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 728,
                    'type' => 'subscription',
                    'rel_id' => $Blog_post->id,
                    'message' => "A new bump post \"{$Blog_post->title}\" is created by {$user->username}.",
                    'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
                ];
                Notification::create($notice);

                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => $featureUser->id,
                    'cate_id' => 728,
                    'type' => 'payment',
                    'rel_id' => $Blog_post->id,
                    'message' => "Your post \"{$Blog_post->title}\" has been bumped.",
                    'url' => route('blogPostSingle', ['slug' => $Blog_post->slug]),
                ];
                Notification::create($notice);
    
                $codes = [
                    '{name}' => $featureUser->first_name,
                ];
    
                General::sendTemplateEmail(
                    $featureUser->email,
                    'Bump-post-success',
                    $codes
                );
                return response()
                    ->json(['success'=>'Payment successful. Your blog bumped successfully.']);
            } else {
                $featureUser = UserAuth::getLoginUser();
    
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                ];
        
                General::sendTemplateEmail(
                    $featureUser->email,
                    'payment-failed-on-finderspage',
                    $codes
                );
                
                return response()
                    ->json(['error'=> 'Something went wrong.']);
            }
        }




        public function payment_bump_Success_entertainment_bump(Request $request)
        {
            // $post_id = General::decrypt($request->post_id);
            $post_id = $request->post_id;
            
            $start_date = date('Y-m-d H:i:s');
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            $get_duration = explode('-', $request->planprice);


            $paymentStatus = $request->status;
            $payment_id = $request->paymentID;
            $payment_source = $request->paymentSource;
            $email = $request->email;
            $name = $request->name;
            $user = UserAuth::getLoginUser();   
            $amount = 5;   
        
    
            if (isset($request['status']) && $request['status'] == 'COMPLETED') {
                DB::table('post_payments')->insert(
                    [
                        'user_id' => $user->id,
                        'payment_id' => $payment_id,
                        'post_id' => $post_id,
                        'payment_method' => $payment_source,
                        'duration' => '1-day',
                        'type' => 'Entertainment',
                        'balance_transaction' =>$amount,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]
                );

                $user_id = UserAuth::getLoginId();
                $featureUser = Users::where('id', $user_id)->first();
                if ($post_id && $user_id) {
                    DB::table('users')
                        ->where('id', $user_id)
                        ->limit(1)
                        ->update([
                            'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                        ]);
                }
    
                 // Post Updated aginst PostID 
                 // Post Updated aginst PostID 
                 $entertainment_post = Entertainment::where('id', $post_id)->first();
                 if ($entertainment_post->id) {
                    DB::table('Entertainment')
                        ->where('id', $post_id)
                        ->limit(1)
                        ->update([
                            'bumpPost' => '1',
                            'post_type' => 'Bump Post',
                            'bump_start' => $start_date,
                            'bump_end' => $end_date,
                            'draft' => '1',
                            
                        ]);
                }
    
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 741,
                    'type' => 'subscription',
                    'rel_id' => $entertainment_post->id,
                    'message' => "A new bump entertainment post \"{$entertainment_post->Title}\" is created by {$user->username}.",
                    'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                ];
                Notification::create($notice);
    
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => $featureUser->id,
                    'cate_id' => 741,
                    'type' => 'payment',
                    'rel_id' => $entertainment_post->id,
                    'message' => "Your entertainment post \"{$entertainment_post->Title}\" has been bumped.",
                    'url' => route('Entertainment.single.listing', $entertainment_post->slug),
                ];
                Notification::create($notice);
    
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{post_url}' => route('Entertainment.single.listing', $entertainment_post->slug),
                ];
    
                General::sendTemplateEmail(
                    $featureUser->email,
                    'Bump-post-success',
                    $codes
                );
                return response()
                    ->json(['success'=>'Payment successful. Your blog bumped successfully.']);
            } else {
                $featureUser = UserAuth::getLoginUser();
    
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                ];
        
                General::sendTemplateEmail(
                    $featureUser->email,
                    'payment-failed-on-finderspage',
                    $codes
                );
                
                return response()
                    ->json(['error'=> 'Something went wrong.']);
            }
        }

        public function payment_bump_Success_business_bump(Request $request)
        {
            // $post_id = General::decrypt($request->post_id);
            $post_id = $request->post_id;
            $start_date = date('Y-m-d H:i:s');
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            $get_duration = explode('-', $request->planprice);


            $paymentStatus = $request->status;
            $payment_id = $request->paymentID;
            $payment_source = $request->paymentSource;
            $email = $request->email;
            $name = $request->name;
            $user = UserAuth::getLoginUser();      
            $amount = 5;
    
            if (isset($request['status']) && $request['status'] == 'COMPLETED') {
                DB::table('post_payments')->insert(
                    [
                        'user_id' => $user->id,
                        'payment_id' => $payment_id,
                        'post_id' => $post_id,
                        'payment_method' => $payment_source,
                        'duration' => '1-day',
                        'type' => 'blog',
                        'balance_transaction' =>$amount,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]
                );

                $user_id = UserAuth::getLoginId();
                $featureUser = Users::where('id', $user_id)->first();
                if ($post_id && $user_id) {
                    DB::table('users')
                        ->where('id', $user_id)
                        ->limit(1)
                        ->update([
                            'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                        ]);
                }
    
                 // Post Updated aginst PostID 
                $Business = Business::where('id', $post_id)->first();
                if ($Business->id) {
                    DB::table('businesses')
                        ->where('id', $post_id)
                        ->limit(1)
                        ->update([
                            'type' => 'Bump',
                            'bump_start' => $start_date,
                            'bump_end' => $end_date,
                        ]);
                }
                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'cate_id' => 1,
                    'type' => 'subscription',
                    'rel_id' => $Business->id,
                    'message' => "A new bump business \"{$Business->business_name}\" is created by {$user->username}.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
                Notification::create($notice);

                $notice = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => $featureUser->id,
                    'cate_id' => 1,
                    'type' => 'payment',
                    'rel_id' => $Business->id,
                    'message' => "Your business \"{$Business->business_name}\" has been bumped.",
                    'url' => route('business_page.front.single.listing', $Business->slug),
                ];
                Notification::create($notice);
    
                $codes = [
                    '{name}' => $featureUser->first_name,
                ];
    
                General::sendTemplateEmail(
                    $featureUser->email,
                    'Bump-post-success',
                    $codes
                );
                return response()
                    ->json(['success'=>'Payment successful. Your blog bumped successfully.']);
            } else {
                $featureUser = UserAuth::getLoginUser();
    
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                ];
        
                General::sendTemplateEmail(
                    $featureUser->email,
                    'payment-failed-on-finderspage',
                    $codes
                );
                
                return response()
                    ->json(['error'=> 'Something went wrong.']);
            }
        }
        









    public function Blog_payment(Request $request,$id,$amt)
    {
    
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.blog.payment.success',$id),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amt
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Blog_paymentCancel()
    {
        return Redirect::back()->withErrors(['message' => 'You have canceled the transaction.']);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Blog_paymentSuccess_bump(Request $request, $post_id)
    {
        $post_id = General::decrypt($post_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        
    
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                    ]);
            }

             // Post Updated aginst PostID 
            $Blog_post = BlogPost::where('id', $post_id)->first();
            if ($Blog_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'Bump-post-success',
                $codes
            );
            return redirect()
                ->route('index_user')
                ->with('success', 'Payment successful. Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
        } else {
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return redirect()
                ->route('index_user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    } 






    public function Entertainment_payment(Request $request,$id,$amt)
    {
    
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.entertainment.payment.success',$id),
                "cancel_url" => route('paypal.entertainment.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amt
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Entertainment_paymentCancel()
    {
        return Redirect::back()->withErrors(['message' => 'You have canceled the transaction.']);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function Entertainment_paymentSuccess_bump(Request $request, $post_id)
    {
        $post_id = General::decrypt($post_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        $featurepost = Entertainment::where('id', $post_id)->first();
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $tresponse->getTransId(),
                    'post_id' => $postID,
                    'balance_transaction' => $price,
                    'type' => 'Entertainment',
                    'duration' => $get_duration,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            
            $featureUser = Users::where('id', $user->id)->first();
            if ($postID && $user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                    ]);
            }

             // Post Updated aginst PostID 
            if ($featurepost->id) {
                DB::table('Entertainment')
                    ->where('id', $postID)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'post_type' => 'Bump Post',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                        
                    ]);
            }

            $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => 7,
                        'cate_id' => 741,
                        'type' => 'post',
                        'rel_id' => $featurepost->id,
                        'message' => "A new bump entertainment post \"{$featurepost->Title}\" is created by {$user->username}.",
                        'url' => route('Entertainment.single.listing', $featurepost->slug),
                    ];
                    Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'cate_id' => 741,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Your entertainment post \"{$featurepost->Title}\" has been bumped.",
                'url' => route('Entertainment.single.listing', $featurepost->slug),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $featureUser->first_name,
                '{post_url}' => route('Entertainment.single.listing', $featurepost->slug),
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'Bump-post-success',
                $codes
            );
            if($featurepost->status==1){
                return redirect()
                ->route('index_user')
                ->with('success', 'Thank you for your payment.');
            }else{
                return redirect()
                ->route('index_user')
                ->with('success', 'Thank you for your payment. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            }
            } else {
                if ($tresponse->getErrors() != null) {
                    // dd($tresponse->getErrors());
                    $featureUser = UserAuth::getLoginUser();

                    $codes = [
                        '{first_name}' => $featureUser->first_name,
                    ];
                
                    General::sendTemplateEmail(
                        $featureUser->email,
                        'payment-failed-on-finderspage',
                        $codes
                    );

                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
                }
            }
    }



    public function paypal_subscription($user_id,$planname)
    {
        $user_id = General::decrypt($user_id);
        return view('frontend.paypal.subscription', ['user_id' => General::encrypt($user_id ),'planname' => $planname]);
    }


    public function createSubscription(Request $request, $planname)
    {
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
        $end_date = Carbon::now();
     // dd($request->subscriptionId);
         $subscriptionId = $request->subscriptionId;
         $order_id = $request->order_id;
         
        if($planname=='weekly'){
            $featurePostCount = $plan_week->feature_listing;
            $bumpPostCount = "2";
            $paidPostCount = "1";
            $slideshow_limit = 4;
            $end_date->addDay(7);
            $duration = '7-days';
            $amount = $plan_week->price;
        }elseif($planname=='month'){
            $featurePostCount = $plan_month->feature_listing;
            $bumpPostCount = "4";
            $paidPostCount = "2";
            $slideshow_limit = 15;
            $end_date->addMonths(1);
            $duration = '30-days';
            $amount = $plan_month->price;
        }elseif($planname=='three-month'){
            $featurePostCount = $plan_3month->feature_listing;
            $bumpPostCount = "6";
            $paidPostCount = "3";
            $slideshow_limit = 20;
            $end_date->addMonths(3);
            $duration = '90-days';
            $amount = $plan_3month->price;
        }
        elseif($planname=='six-month'){
            $featurePostCount = $plan_6month->feature_listing;
            $bumpPostCount = "8";
            $paidPostCount = "4";
            $slideshow_limit = 25;
            $end_date->addMonths(6);
            $duration = '180-days';
            $amount = $plan_6month->price;
        }elseif($planname=='year'){
            $featurePostCount = $plan_year->feature_listing;
            $bumpPostCount = "Unlimited";
            $paidPostCount = "Unlimited";
            $slideshow_limit = 25;
            $end_date->addMonths(12);
            $duration = '365-days';
            $amount = $plan_year->price;
        }
        
    $user = UserAuth::getLoginUser();
    $start_date = date('Y-m-d');
    if ($user->feature_end_date !== null) {
        $current_date = strtotime($start_date);
        $feature_end_date = strtotime($user->feature_end_date);
        $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
        
        // Add the differenceInDays to $end_date
        $end_date->addDays($differenceInDays);
    }

    $end_date_formatted = $end_date->format('Y-m-d');

       DB::table('post_payments')->insert(
                [
                    'payment_id' => $subscriptionId,
                    'user_id' => $user->id,
                    // 'post_id' => $post_id,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    'type' =>'subscription',
                    'paid' => 'yes',
                    'balance_transaction' => $amount,
                    'duration' => $duration,
                    'start_date' => $start_date,
                    'end_date' => $end_date_formatted
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1',
                        'feature_start_date' => $start_date,
                        'feature_end_date' => $end_date_formatted,
                        'subscribedPlan' =>  $planname ,
                        'cancel_at' => 0 ,
                        'featured_post_count' => $featurePostCount,
                        'slideshow_limit' => $slideshow_limit ,
                        'paypal_orderID' => $order_id ,
                        'paypal_subscriptionID' => $request->subscriptionId,
                        'paid_post_count' => $paidPostCount,
                        'bump_post_count' => $bumpPostCount,
                    ]);
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'subscription',
                'url' =>route('UserProfileFrontend',$user->slug),
                'message' => 'New plan ' . $planname . ' subscribe   by ' . $user->first_name . '.',
                ];
            Notification::create($notice); 
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'type' => 'payment',
                'message' => 'Payment successful. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
            ];
            Notification::create($notice);
    
            $codes = [
                '{first_name}' => $user->first_name,
                '{featured_count}' => $planData->feature_listing,
                '{bump_count}' => $bump_postCount,
                '{paid_count}' => $paid_postCount,
            ];
    
            General::sendTemplateEmail(
                $userData->email,
                'Subscription-template',
                $codes
            );
            return redirect()
                    ->route('index_user')
                    ->with('success', 'Payment successfull! ');
        // $request->session()->flash('success', 'Payment Successfully.');
        // return response()->json(['success' => 'Payment successfully.']); 
    }



    public function cancelSubscription(Request $request)
    {
        $user = UserAuth::getLoginUser();
        try {
            $subscriptionId = $request->subid;
            $clientId = "AatTYfa6pUOo21YMpaFDAulZWxALxdgHMcgNUPLFAX38lSnfk8v2ChMmlGXV1BCoHrQ_szgl6pALqmfI";
            $clientSecret = "EJMGgzyViSKLQd6wUf-czuJgVWQjoT_weMwH_9UV4cldxUWT8rP3FSmrgzvANknkw7HBbKneiQ_3DbhV";

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/billing/subscriptions/$subscriptionId/cancel");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Basic " . base64_encode("$clientId:$clientSecret");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new \Exception('Error:' . curl_error($ch));
            }
            DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'cancel_at' => 1 ,
                        'paypal_subscriptionID' =>null,
                    ]);

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'subscription',
                'message' => $user->first_name . ' canceled its ' . $user->subscribedPlan . ' subscription plan.',
            ];
            Notification::create($notice); 

            $notice2 = [
                'from_id' => 7,
                'to_id' => $user->id,
                'type' => 'subscription',
                'message' => 'You have canceled your ' . $user->subscribedPlan . ' subscription plan.',
            ];
            Notification::create($notice2); 

            $codes = [
                '{first_name}' => $user->first_name,
            ];
    
            General::sendTemplateEmail(
                $user->email,
                'canceled-subscription',
                $codes
            );
            return response()->json(['success' => true, 'message' => 'Subscription successfully cancelled.']);
        } catch (\Exception $e) {
            // Log::error('Error cancelling PayPal subscription: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function featuredForm($post_id){
        $post_id = General::decrypt($post_id);
        $Featureblog = Blogs::where('id', $post_id)->first();

        if($Featureblog->featured_post == 'on'){
            Session::flash('success', 'Your listing is allready featured. Thank you.');  
            return redirect()->back();
        }else{
            return view('frontend.paypal.featuredPost', ['post_id' => General::encrypt($post_id)]);
        }
    }

     public function createfeaturedPost(Request $request)
    {
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
         $end_date = Carbon::now();
     // dd($request->subscriptionId);
         $subscriptionId = $request->subscriptionId;
         $order_id = $request->order_id;
         $planname = $request->planname;
         $post_id  = $request->post_id;
        if($planname=='weekly'){
            $featurePostCount = $plan_week->feature_listing;
            $bumpPostCount = "2";
            $paidPostCount = "1";
            $slideshow_limit = 4;
            $end_date->addDay(7);
            $duration = '7-days';
            $amount = $plan_week->price;
        }elseif($planname=='month'){
            $featurePostCount = $plan_month->feature_listing;
            $bumpPostCount = "4";
            $paidPostCount = "2";
            $slideshow_limit = 15;
            $end_date->addMonths(1);
            $duration = '30-days';
            $amount = $plan_month->price;
        }elseif($planname=='three-month'){
            $featurePostCount = $plan_3month->feature_listing;
            $bumpPostCount = "6";
            $paidPostCount = "3";
            $slideshow_limit = 20;
            $end_date->addMonths(3);
            $duration = '90-days';
            $amount = $plan_3month->price;
        }
        elseif($planname=='six-month'){
            $featurePostCount = $plan_6month->feature_listing;
            $bumpPostCount = "8";
            $paidPostCount = "4";
            $slideshow_limit = 25;
            $end_date->addMonths(6);
            $duration = '180-days';
            $amount = $plan_6month->price;
        }elseif($planname=='year'){
            $featurePostCount = $plan_year->feature_listing;
            $bumpPostCount = "Unlimited";
            $paidPostCount = "Unlimited";
            $slideshow_limit = 25;
            $end_date->addMonths(12);
            $duration = '365-days';
            $amount = $plan_year->price;
        }
        
    $user = UserAuth::getLoginUser();
    $start_date = date('Y-m-d');
    if ($user->feature_end_date !== null) {
        $current_date = strtotime($start_date);
        $feature_end_date = strtotime($user->feature_end_date);
        $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
        
        // Add the differenceInDays to $end_date
        $end_date->addDays($differenceInDays);
    }

    $end_date_formatted = $end_date->format('Y-m-d');

       DB::table('post_payments')->insert(
                [
                    'payment_id' => $subscriptionId,
                    'post_id' => $post_id,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    'type' =>'subscription',
                    'paid' => 'yes',
                    'balance_transaction' =>$amount,
                    'duration' => $duration,
                    'start_date' => $start_date,
                    'end_date' => $end_date_formatted
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date_formatted,'subscribedPlan' =>  $planname ,'cancel_at' => 0 ,'featured_post_count' => $featurePostCount,'slideshow_limit' => $slideshow_limit ,'paypal_orderID' => $order_id ,'paypal_subscriptionID' => $request->subscriptionId,'bump_post_count' => $bumpPostCount,'paid_post_count' => $paidPostCount,
                    ]);
            }

            $featurepost = Blogs::where('id', $post_id)->first();
            if ($featurepost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on',
                        'draft' =>1
                    ]);
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'post',
                'message' => 'New plan ' . $planname . ' subscribe by ' . $user->first_name . '.',
                ];
            Notification::create($notice); 
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'type' => 'payment',
                'message' => 'Payment successful. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date.'.',
            ];
            Notification::create($notice);
    
            $codes = [
                '{first_name}' => $user->first_name,
                '{featured_count}' => $planData->feature_listing,
                '{bump_count}' => $bump_postCount,
                '{paid_count}' => $paid_postCount,
            ];
    
            General::sendTemplateEmail(
                $userData->email,
                'Subscription-template',
                $codes
            );
            $request->session()->flash('success', 'Payment successfully.');
        return response()->json(['success' => 'Payment successfully.']); 
    }








    public function featured_blog_Form($post_id){
        $post_id = General::decrypt($post_id);
        $Featureblog = BlogPost::where('id', $post_id)->first();

        if($Featureblog->featured_post == 'on'){
            Session::flash('success', 'Your listing is already featured. Thank you.');  
            return redirect()->back();
        }else{
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return view('frontend.paypal.featuredPost_blog', ['post_id' => General::encrypt($post_id)]);
        }
    }

     public function createfeatured_blog_Post(Request $request)
    {
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
         $end_date = Carbon::now();
     // dd($request->subscriptionId);
         $subscriptionId = $request->subscriptionId;
         $order_id = $request->order_id;
         $planname = $request->planname;
         $post_id  = $request->post_id;
        if($planname=='weekly'){
            $featurePostCount = $plan_week->feature_listing;
            $slideshow_limit = 4;
            $end_date->addDay(7);
            $duration = '7-days';
            $amount = $plan_week->price;
        }elseif($planname=='month'){
            $featurePostCount = $plan_month->feature_listing;
            $slideshow_limit = 15;
            $end_date->addMonths(1);
            $duration = '30-days';
            $amount = $plan_month->price;
        }elseif($planname=='three-month'){
            $featurePostCount = $plan_3month->feature_listing;
            $slideshow_limit = 20;
            $end_date->addMonths(3);
            $duration = '90-days';
            $amount = $plan_3month->price;
        }
        elseif($planname=='six-month'){
            $featurePostCount = $plan_6month->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(6);
            $duration = '180-days';
            $amount = $plan_6month->price;
        }elseif($planname=='year'){
            $featurePostCount = $plan_year->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(12);
            $duration = '365-days';
            $amount = $plan_year->price;
        }
        
    $user = UserAuth::getLoginUser();
    $start_date = date('Y-m-d');
    if ($user->feature_end_date !== null) {
        $current_date = strtotime($start_date);
        $feature_end_date = strtotime($user->feature_end_date);
        $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
        
        // Add the differenceInDays to $end_date
        $end_date->addDays($differenceInDays);
    }

    $end_date_formatted = $end_date->format('Y-m-d');

    DB::table('post_payments')->insert(
        [
            'payment_id' => $subscriptionId,
            'post_id' => $post_id,
            // 'payment_method' => $strip->payment_method,
            // 'payment_method_details' => json_encode($strip->payment_method_details),
            // 'outcome' => json_encode($strip->outcome),
            'type' =>'subscription',
            'paid' => 'yes',
            'balance_transaction' =>$amount,
            'duration' => $duration,
            'start_date' => $start_date,
            'end_date' => $end_date_formatted
        ]
    );

            // Update User         

            
            // dd($featureUser);
            if ($user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date_formatted,'subscribedPlan' =>  $planname ,'cancel_at' => 0 ,'featured_post_count' => $featurePostCount,'slideshow_limit' => $slideshow_limit ,'paypal_orderID' => $order_id ,'paypal_subscriptionID' => $request->subscriptionId,
                    ]);
            }

            $feature_post = BlogPost::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on',
                        'draft' =>1
                    ]);
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'post',
                'message' => 'New plan ' . $planname . ' subscribe by ' . $user->first_name . '.',
                ];
            Notification::create($notice); 
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'type' => 'payment',
                'message' => 'Payment successful. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date.'.',
            ];
            Notification::create($notice);
    
            $codes = [
                '{first_name}' => $user->first_name,
                '{featured_count}' => $planData->feature_listing,
                '{bump_count}' => $bump_postCount,
                '{paid_count}' => $paid_postCount,
            ];
    
            General::sendTemplateEmail(
                $userData->email,
                'Subscription-template',
                $codes
            );
            $request->session()->flash('success', 'Payment successfully.');
        return response()->json(['success' => 'Payment successfully.']); 
    }




    public function featured_entertainment_Form($post_id){
        $post_id = General::decrypt($post_id);
        $Featureblog = Entertainment::where('id', $post_id)->first();

        if($Featureblog->featured_post == 'on'){
            Session::flash('success', 'Your listing is already featured. Thank you.');  
            return redirect()->back();
        }else{
            return view('frontend.paypal.featuredPost_entertainment', ['post_id' => General::encrypt($post_id)]);
        }
    }

     public function createfeatured_entertainment_Post(Request $request)
    {
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
         $end_date = Carbon::now();
     // dd($request->subscriptionId);
         $subscriptionId = $request->subscriptionId;
         $order_id = $request->order_id;
         $planname = $request->planname;
         $post_id  = $request->post_id;
        if($planname=='weekly'){
            $featurePostCount = $plan_week->feature_listing;
            $slideshow_limit = 4;
            $end_date->addDay(7);
            $duration = '7-days';
            $amount = $plan_week->price;
        }elseif($planname=='month'){
            $featurePostCount = $plan_month->feature_listing;
            $slideshow_limit = 15;
            $end_date->addMonths(1);
            $duration = '30-days';
            $amount = $plan_month->price;
        }elseif($planname=='three-month'){
            $featurePostCount = $plan_3month->feature_listing;
            $slideshow_limit = 20;
            $end_date->addMonths(3);
            $duration = '90-days';
            $amount = $plan_3month->price;
        }
        elseif($planname=='six-month'){
            $featurePostCount = $plan_6month->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(6);
            $duration = '180-days';
            $amount = $plan_6month->price;
        }elseif($planname=='year'){
            $featurePostCount = $plan_year->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(12);
            $duration = '365-days';
            $amount = $plan_year->price;
        }
        
    $user = UserAuth::getLoginUser();
    $start_date = date('Y-m-d');
    if ($user->feature_end_date !== null) {
        $current_date = strtotime($start_date);
        $feature_end_date = strtotime($user->feature_end_date);
        $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
        
        // Add the differenceInDays to $end_date
        $end_date->addDays($differenceInDays);
    }

    $end_date_formatted = $end_date->format('Y-m-d');

    DB::table('post_payments')->insert(
        [
            'payment_id' => $subscriptionId,
            'post_id' => $post_id,
            // 'payment_method' => $strip->payment_method,
            // 'payment_method_details' => json_encode($strip->payment_method_details),
            // 'outcome' => json_encode($strip->outcome),
            'type' =>'subscription',
            'paid' => 'yes',
            'balance_transaction' =>$amount,
            'duration' => $duration,
            'start_date' => $start_date,
            'end_date' => $end_date_formatted
        ]
    );

            // Update User         

            
            // dd($featureUser);
            if ($user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date_formatted,'subscribedPlan' =>  $planname ,'cancel_at' => 0 ,'featured_post_count' => $featurePostCount,'slideshow_limit' => $slideshow_limit ,'paypal_orderID' => $order_id ,'paypal_subscriptionID' => $request->subscriptionId,
                    ]);
            }

            $feature_post = Entertainment::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on',
                        'draft' =>1
                    ]);
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'post',
                'message' => 'New plan ' . $planname . ' subscribe   by ' . $user->first_name,
                ];
            Notification::create($notice); 
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'type' => 'payment',
                'message' => 'Payment successful. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date.'.',
            ];
            Notification::create($notice);
    
            $codes = [
                '{first_name}' => $user->first_name,
                '{featured_count}' => $planData->feature_listing,
                '{bump_count}' => $bump_postCount,
                '{paid_count}' => $paid_postCount,
            ];
    
            General::sendTemplateEmail(
                $userData->email,
                'Subscription-template',
                $codes
            );
            $request->session()->flash('success', 'Payment successfully.');
        return response()->json(['success' => 'Payment successfully.']); 
    }




    public function featured_business($post_id){
        $post_id = General::decrypt($post_id);
        $Featureblog = Business::where('id', $post_id)->first();

        if($Featureblog->featured == 'on'){
            Session::flash('success', 'Your listing is already featured. Thank you.');  
            return redirect()->back();
        }else{
            $featureUser = UserAuth::getLoginUser();

            $codes = [
                '{first_name}' => $featureUser->first_name,
            ];
    
            General::sendTemplateEmail(
                $featureUser->email,
                'payment-failed-on-finderspage',
                $codes
            );
            
            return view('frontend.paypal.featuredPost_business', ['post_id' => General::encrypt($post_id)]);
        }
    }

     public function createfeatured_business_Post(Request $request)
    {
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
         $end_date = Carbon::now();
     // dd($request->subscriptionId);
         $subscriptionId = $request->subscriptionId;
         $order_id = $request->order_id;
         $planname = $request->planname;
         $post_id  = $request->post_id;
        if($planname=='weekly'){
            $featurePostCount = $plan_week->feature_listing;
            $slideshow_limit = 4;
            $end_date->addDay(7);
            $duration = '7-days';
            $amount = $plan_week->price;
        }elseif($planname=='month'){
            $featurePostCount = $plan_month->feature_listing;
            $slideshow_limit = 15;
            $end_date->addMonths(1);
            $duration = '30-days';
            $amount = $plan_month->price;
        }elseif($planname=='three-month'){
            $featurePostCount = $plan_3month->feature_listing;
            $slideshow_limit = 20;
            $end_date->addMonths(3);
            $duration = '90-days';
            $amount = $plan_3month->price;
        }
        elseif($planname=='six-month'){
            $featurePostCount = $plan_6month->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(6);
            $duration = '180-days';
            $amount = $plan_6month->price;
        }elseif($planname=='year'){
            $featurePostCount = $plan_year->feature_listing;
            $slideshow_limit = 25;
            $end_date->addMonths(12);
            $duration = '365-days';
            $amount = $plan_year->price;
        }
        
    $user = UserAuth::getLoginUser();
    $start_date = date('Y-m-d');
    if ($user->feature_end_date !== null) {
        $current_date = strtotime($start_date);
        $feature_end_date = strtotime($user->feature_end_date);
        $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
        
        // Add the differenceInDays to $end_date
        $end_date->addDays($differenceInDays);
    }

    $end_date_formatted = $end_date->format('Y-m-d');

    DB::table('post_payments')->insert(
        [
            'payment_id' => $subscriptionId,
            'post_id' => $post_id,
            // 'payment_method' => $strip->payment_method,
            // 'payment_method_details' => json_encode($strip->payment_method_details),
            // 'outcome' => json_encode($strip->outcome),
            'type' =>'subscription',
            'paid' => 'yes',
            'balance_transaction' =>$amount,
            'duration' => $duration,
            'start_date' => $start_date,
            'end_date' => $end_date_formatted
        ]
    );

            // Update User         

            
            // dd($featureUser);
            if ($user->id) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date_formatted,'subscribedPlan' =>  $planname ,'cancel_at' => 0 ,'featured_post_count' => $featurePostCount,'slideshow_limit' => $slideshow_limit ,'paypal_orderID' => $order_id ,'paypal_subscriptionID' => $request->subscriptionId,
                    ]);
            }

            $feature_post = Business::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('businesses')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured' => 'on',
                        'draft' =>'1',
                        'type' =>"Featured",
                    ]);
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'post',
                'message' => 'New plan ' . $planname . ' subscribe by ' . $user->first_name . '.',
                ];
            Notification::create($notice); 
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $user->id,
                'type' => 'payment',
                'message' => 'Payment successful. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date.'.',
            ];
            Notification::create($notice);
    
            $codes = [
                '{first_name}' => $user->first_name,
                '{featured_count}' => $planData->feature_listing,
                '{bump_count}' => $bump_postCount,
                '{paid_count}' => $paid_postCount,
            ];
    
            General::sendTemplateEmail(
                $userData->email,
                'Subscription-template',
                $codes
            );
            $request->session()->flash('success', 'Payment successfully.');
        return response()->json(['success' => 'Payment successfully.']); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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



    public function bumpPayment_blogs($post_id){
        $post_id = $post_id;
        $featurepost = BlogPost::where('id', $post_id)->first();
        if($featurepost->bumpPost == 1){
            Session::flash('success', 'Your post is already bumped. Thank you.');  
            return redirect()->back();
        }else{
            return view('frontend.paypal.blog_bump',compact('post_id'));
        }
    }

   public function payment_blogs(Request $request,$post_id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.blog.success',$post_id),
                "cancel_url" => route('paypal.payment.cancel.blogs'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "3.00"
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel_blogs()
    {
        return Redirect::back()->withErrors(['message' => 'You have canceled the transaction.']);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess_bump_blogs(Request $request, $post_id)
    {
        $post_id = General::decrypt($post_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        
    
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

          DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    // 'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', $user_id)->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                    ]);
            }

             // Post Updated aginst PostID 
            $Blog_post = BlogPost::where('id', $post_id)->first();
            if ($Blog_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                    ]);
            }

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'feature-post',
                $codes
            );
            return redirect()
                ->route('index_user')
                ->with('success', 'Payment successful! Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
        } else {
            return redirect()
                ->route('index_user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }












     public function paid_post_Payment($post_id){
        $post_id = General::decrypt($post_id);
        return view('frontend.paypal.paid_post',compact('post_id'));
    }

   public function paid_post_payment_save(Request $request,$post_id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.paid.success',$post_id),
                "cancel_url" => route('paypal.payment.cancel.paid'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "5.00"
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment_paid_post_Cancel()
    {
        return redirect()
              ->route('paypal')
              ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment_paid_post_Success(Request $request, $post_id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        
        
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Paid Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
            return redirect()
                ->route('index_user')
                ->with('success', 'Payment successful! Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
        } else {
            return redirect()
                ->route('index_user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }







//service paid [post]

public function service_paid_post_Payment($post_id){
        $post_id = General::decrypt($post_id);
        return view('frontend.paypal.paid_post',compact('post_id'));
    }

   public function service_paid_post_payment_save(Request $request,$post_id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.paid.success',$post_id),
                "cancel_url" => route('paypal.payment.cancel.paid'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "3.00"
                    ]
                ]
            ]
        ]);


  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function service_payment_paid_post_Cancel()
    {
        return redirect()
              ->route('paypal')
              ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function service_payment_paid_post_Success(Request $request, $post_id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);


        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $get_duration = explode('-', $request->planprice);


        $paymentStatus = $response['status'];
        $payment_id = $response['id'];
        $paypal_payment = $response['payment_source'];
        $email = $paypal_payment['paypal']['email_address'];
        $account_id = $paypal_payment['paypal']['account_id'];
        $name = $paypal_payment['paypal']['name'];
        $fullname = $name['given_name'].' '. $name['surname'] ;
        $user = UserAuth::getLoginUser();
        
        
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $payment_id,
                    'post_id' => $post_id,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Paid Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $user->email,
                'feature-post',
                $codes
            );
            return redirect()
                ->route('index_user')
                ->with('success', 'Payment successful. Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
        } else {
            return redirect()
                ->route('index_user')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }



    public function subscribe_plan(Request $request)
    {
        $planId = $request->plan_id;

        $paypal = new PayPalClient();
        $paypal->setApiCredentials(config('paypal'));
        $paypal->getAccessToken();

        $response = $paypal->createSubscription(['plan_id' => $planId]);
            // dd($response);
        if ($response['status'] == 'APPROVAL_PENDING') {
        // Redirect user to PayPal payment page
        return redirect($response['links'][0]['href']);
        } elseif ($response['status'] == 'approved') {
            // Subscription created and payment completed successfully
        } else {
            // Subscription creation failed
        }
    }




    // PaymentController.php
    public function applePay(Request $request)
    {
        dd($request->all());
        // Handle the Apple Pay payment process
    }

    // PaymentController.php
public function validateMerchant(Request $request)
{
    $validationURL = $request->input('validationURL');

    // Call PayPal API to get merchant session
    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://api.paypal.com/v1/checkout/orders', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ],
        'body' => json_encode([
            'validationUrl' => $validationURL,
            'domainName' => 'your-domain.com'
        ])
    ]);

    return $response->getBody()->getContents();
}

// PaymentController.php
public function processPayment(Request $request)
{
    $paymentData = $request->input('payment');

    // Process payment with PayPal API
    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://api.paypal.com/v1/checkout/orders', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ],
        'body' => json_encode([
            // Add required payment data here
        ])
    ]);

    return $response->getBody()->getContents();
}

}
