<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Video;
use Exception;
use App\Models\Admin\SubPlan;

class StripePaymentController extends AppController
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function stripe($post_id)
    {
         $public_key = AppController::STRIPE_KEY;
        return view('frontend.stripe.stripe', ['post_id' => $post_id , 'public_key' => $public_key]);
    }



    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $start_date = date('Y-m-d');
        $end_date = Carbon::now()->addMonths(3)->format('Y-m-d');
        // echo"<pre>"; print_r($request->all());  die($ldate);
        $get_duration = explode('-', $request->planprice);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'year') {
            $duration = 'year';
        } else {
            $duration = 'month';
        }


        if($planprice == 14) {
                $plan_name ="7-day-14";
                $price_id = 'price_1OZnAFKwBKiXM0n5mR5WmE9H';
            }else if($planprice == 55) {
                $plan_name ="1-month-55";
                $price_id = 'price_1KdAD6KwBKiXM0n5U355eXY6';
            }else if($planprice == 166) {
                $plan_name ="3-month-166";
                $price_id = 'price_1OgmLEKwBKiXM0n5LAxSh2Wa';
            } else if($planprice == 333) {
                $plan_name ="6-month-333";
                $price_id = 'price_1OgmMLKwBKiXM0n5k7GOeuJb';
            } else if($planprice == 777) {
                $plan_name ="1-year-777";
                $price_id = 'price_1OgmNFKwBKiXM0n5cp0x15IJ';
            }

         $user = UserAuth::getLoginUser();

        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;

try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Subscription::create([
                  'customer' => $customer->id,
                  'items' => [
                    ['price' => $price_id],
                  ],
                ]);

    } catch (\Exception $e) {
        // echo $e->getMessage();

        $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
        
}


        if ($data->status=="active") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date,'subscribedPlan' =>  $plan_name
                    ]);
            }


            $featurepost = Blogs::where('id', $post_id)->first();
            if ($featurepost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on'
                    ]);
            }

            //dd($post_id);
             //dd($user);
            // Post Updated aginst PostID 
            DB::table('blogs')
                ->where('id', $post_id)
                ->limit(1)
                ->update(['featured_post' => 'on']);

            $description = DB::table('blogs')
                ->where('id', $post_id)
                ->value('description');

            // $post_disc = limit($description, 30, '...');

            $codes = [
                '{name}' => $featureUser->first_name,
                '{post_url}' => route('jobpost', ['id' => $post_id]),
                '{post_description}' => $description,
                '{plan_price}' => $planprice,

            ];
  
            General::sendTemplateEmail(
                $featureUser->email,
                'feature-post',
                $codes
            );
        }
        // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
            Please allow us to approve it. Thank you for understanding.');
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


        /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost_old(Request $request)
    {
        $start_date = date('Y-m-d');
        $end_date = Carbon::now()->addMonths(3)->format('Y-m-d');
        // echo"<pre>"; print_r($request->all());  die($ldate);
        $get_duration = explode('-', $request->planprice);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'year') {
            $duration = 'year';
        } else {
            $duration = 'month';
        }

        echo $request->post_id;

        die;
        $post_id = General::decrypt($request->post_id);
        $post_id = $request->post_id;

       


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));




        $strip = Stripe\Charge::create([
            "amount" => $planprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Finderspage payment"
        ]);
        if (!empty($strip->id)) {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $strip->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $strip->balance_transaction,
                    'payment_method' => $strip->payment_method,
                    'payment_method_details' => json_encode($strip->payment_method_details),
                    'outcome' => json_encode($strip->outcome),
                    'paid' => json_encode($strip->paid),
                    'receipt_url' => $strip->receipt_url,
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User 
            $user_id = UserAuth::getLoginId();
            $featureUser = Users::where('id', '$user_id')->first();
            if ($post_id && $user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date
                    ]);
            }

            // Post Updated aginst PostID 
            DB::table('blogs')
                ->where('id', $post_id)
                ->limit(1)
                ->update(['is_feature' => '1']);

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'feature-post',
                $codes
            );
        }
        // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
        $data = array();
        $data['payment_id'] = $strip->id;
        $data['amount'] = $planprice;
        $data['created_at'] = $start_date;
        $data['receipt_url'] = $strip->receipt_url;
        $data['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $data]);
        //return redirect()->to($strip->receipt_url);
    }



    public function stripe_bump($post_id)
    {
        $post_id = General::decrypt($post_id);
        $featurepost = Blogs::where('id', $post_id)->first();

        if($featurepost->bumpPost == 1){
            Session::flash('success', 'Your post is already bumped. Thank you.');  
            return redirect()->back();
        }else{
         $public_key = AppController::STRIPE_KEY;
        return view('frontend.stripe.stripe_bump', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripePost_bump(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 

         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
          try { 
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Charge::create([
                        'customer' => $customer->id,
                        'amount' => 300, // Charge amount in cents (500 cents = $5)
                        'currency' => 'usd',
                        'description' => 'One-time payment for Findersage',
                    ]);
}  catch (\Exception $e) {
    // echo $e->getMessage();

    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
    if(isset($_SERVER['HTTP_REFERER'])) {
      
     $previous = $_SERVER['HTTP_REFERER'];
Session::flash('error', $e->getMessage().'.');
            return redirect()->to($previous);
   die;
}
        
    }
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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

            $codes = [
                '{name}' => $featureUser->first_name,
            ];

            General::sendTemplateEmail(
                $featureUser->email,
                'feature-post',
                $codes
            );
        }
        if($featurepost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');

        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }



public function stripe_services_normal($post_id)
    {
        $post_id = General::decrypt($post_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_normal_service', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        
    }

     public function stripe_savre_NormalService(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        

    $user = UserAuth::getLoginUser();



    $post_id = General::decrypt($request->post_id);
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

            $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);

            $data = Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => 300, // Charge amount in cents (500 cents = $5)
                'currency' => 'usd',
                'description' => 'One-time payment for Finderspage',
            ]);

} catch (\Exception $e) {
        // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

         // dd($data);
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Post Updated aginst PostID 
            // dd($post_id);
            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Normal Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $BlogPost->email,
                'feature-post',
                $codes
            );
            // dd($BlogPost);
        }
        if($BlogPost->status == 1){
            Session::flash('success', 'Payment successful. Your listing is up, your listing will be live on website. Thank you .');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = 3;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = '$3-Normal-listing';
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


    public function stripe_blog_bump($post_id)
    {
        $post_id = General::decrypt($post_id);
        $bumpeblog = BlogPost::where('id', $post_id)->first();

        if($bumpeblog->bumpPost == 1){
            Session::flash('success', 'Your post is already bumped. Thank you.');  
            return redirect()->back();
        }else{
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_blog', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripeBlog_bump(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);
          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => 300, // Charge amount in cents (500 cents = $5)
                'currency' => 'usd',
                'description' => 'One-time payment for Finderspage',
            ]);

}  catch (\Exception $e) {
    // echo $e->getMessage();

    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
    if(isset($_SERVER['HTTP_REFERER'])) {
      
     $previous = $_SERVER['HTTP_REFERER'];
Session::flash('error', $e->getMessage().'.');
            return redirect()->to($previous);
   die;
}

}
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
        }
        if($Blog_post->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }







    public function stripe_blog_feature($post_id)
    {
        $post_id = General::decrypt($post_id);
        $Featureblog = BlogPost::where('id', $post_id)->first();

        if($Featureblog->featured_post == 'on'){
            Session::flash('success', 'Your listing is already bumped. Thank you.');  
            return redirect()->back();
        }else{
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_blog_feature', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripeBlog_feature(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        if($planprice == 14) {
                $plan_name ="7-day-14";
                $price_id = 'price_1OZnAFKwBKiXM0n5mR5WmE9H';
            }else if($planprice == 55) {
                $plan_name ="1-month-55";
                $price_id = 'price_1KdAD6KwBKiXM0n5U355eXY6';
            }else if($planprice == 166) {
                $plan_name ="3-month-166";
                $price_id = 'price_1OgmLEKwBKiXM0n5LAxSh2Wa';
            } else if($planprice == 333) {
                $plan_name ="6-month-333";
                $price_id = 'price_1OgmMLKwBKiXM0n5k7GOeuJb';
            } else if($planprice == 777) {
                $plan_name ="1-year-777";
                $price_id = 'price_1OgmNFKwBKiXM0n5cp0x15IJ';
            }
         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;

try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Subscription::create([
                  'customer' => $customer->id,
                  'items' => [
                    ['price' => $price_id],
                  ],
                ]);
} catch (\Exception $e) {
        // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

        if ($data->status=="active") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date,'subscribedPlan' =>  $plan_name
                    ]);
            }

             // Post Updated aginst PostID 
            $feature_post = BlogPost::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on'
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
        }
        if($feature_post->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your blog. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your blog. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }



    //entertainment////

     public function stripe_entertainment_bump($post_id)
    {
        $post_id = General::decrypt($post_id);
        $featurepost = Entertainment::where('id', $post_id)->first();
// dd($featurepost);
        if($featurepost->bumpPost == 1){
            Session::flash('success', 'Your listing is already bumped. Thank you.');  
            return redirect()->back();
        }else{
         $public_key = AppController::STRIPE_KEY;
        return view('frontend.stripe.stripe_ent_bump', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripeEntertainment_bump(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 

         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;

try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



             $data = Stripe\Charge::create([
                        'customer' => $customer->id,
                        'amount' => 300, // Charge amount in cents (500 cents = $5)
                        'currency' => 'usd',
                        'description' => 'One-time payment for Finderspage',
                    ]);

}  catch (\Exception $e) {
    // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
    if(isset($_SERVER['HTTP_REFERER'])) {
      
     $previous = $_SERVER['HTTP_REFERER'];
Session::flash('error', $e->getMessage().'.');
            return redirect()->to($previous);
   die;
}

}

        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
            $featurepost = Entertainment::where('id', $post_id)->first();
            if ($featurepost->id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'featured_post' => 'off',
                        'post_type' => 'Bump Post',
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
        }
        if($featurepost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }

    public function stripe_Entertainment_feature($post_id)
    {
        $post_id = General::decrypt($post_id);
        $Featureblog = Entertainment::where('id', $post_id)->first();

        if($Featureblog->featured_post == 'on'){
            Session::flash('success', 'Your listing is already bumped. Thank you.');  
            return redirect()->back();
        }else{
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_ent_feature', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripeEntertainment_feature(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        if($planprice == 14) {
                $plan_name ="7-day-14";
                $price_id = 'price_1OZnAFKwBKiXM0n5mR5WmE9H';
            }else if($planprice == 55) {
                $plan_name ="1-month-55";
                $price_id = 'price_1KdAD6KwBKiXM0n5U355eXY6';
            }else if($planprice == 166) {
                $plan_name ="3-month-166";
                $price_id = 'price_1OgmLEKwBKiXM0n5LAxSh2Wa';
            } else if($planprice == 333) {
                $plan_name ="6-month-333";
                $price_id = 'price_1OgmMLKwBKiXM0n5k7GOeuJb';
            } else if($planprice == 777) {
                $plan_name ="1-year-777";
                $price_id = 'price_1OgmNFKwBKiXM0n5cp0x15IJ';
            }

         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Subscription::create([
                  'customer' => $customer->id,
                  'items' => [
                    ['price' => $price_id],
                  ],
                ]);

} catch (\Exception $e) {
        // echo $e->getMessage();

    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );

        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

        if ($data->status=="active") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date,'subscribedPlan' =>  $plan_name
                    ]);
            }

             // Post Updated aginst PostID 
            $feature_post = Entertainment::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on',
                        'post_type' => 'Feature Post',
                        'bumpPost' => '0',
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
        }
        if($feature_post->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }




    public function stripe_video_feature($post_id)
    {
        $post_id = General::decrypt($post_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_video_feature', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
    }

     public function stripe_video_feature_payment(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        if($planprice == 14) {
            $plan_name ="7-day-14";
            $price_id = 'price_1OZnAFKwBKiXM0n5mR5WmE9H';
        }else if($planprice == 55) {
            $plan_name ="1-month-55";
            $price_id = 'price_1KdAD6KwBKiXM0n5U355eXY6';
        }else if($planprice == 166) {
            $plan_name ="3-month-166";
            $price_id = 'price_1OgmLEKwBKiXM0n5LAxSh2Wa';
        } else if($planprice == 333) {
            $plan_name ="6-month-333";
            $price_id = 'price_1OgmMLKwBKiXM0n5k7GOeuJb';
        } else if($planprice == 777) {
            $plan_name ="1-year-777";
            $price_id = 'price_1OgmNFKwBKiXM0n5cp0x15IJ';
        }

         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
   try{     
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Subscription::create([
                  'customer' => $customer->id,
                  'items' => [
                    ['price' => $price_id],
                  ],
                ]);
} catch (\Exception $e) {
        // echo $e->getMessage();

    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

        if ($data->status=="active") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date,'subscribedPlan' =>  $plan_name
                    ]);
            }

             // Post Updated aginst PostID 
            $feature_post = Video::where('id', $post_id)->first();
            if ($feature_post->id) {
                DB::table('videos')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'featured_post' => 'on',
                        'post_type' => 'Feature Post',
                        'bumpPost' => '0',
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
        }
        if($feature_post->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


    public function stripe_video_bump($post_id)
    {
        $post_id = General::decrypt($post_id);
        $featurepost = Video::where('id', $post_id)->first();
//dd($featurepost);
        if($featurepost->bumpPost == 1){
            Session::flash('success', 'Your video is already bumped. Thank you.');  
            return redirect()->back();
        }else{
         $public_key = AppController::STRIPE_KEY;
        return view('frontend.stripe.stripe_video_bump', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        }
    }

     public function stripeVideo_bump(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 

         $user = UserAuth::getLoginUser();




        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);



            $data = Stripe\Charge::create([
                        'customer' => $customer->id,
                        'amount' => 300, // Charge amount in cents (500 cents = $5)
                        'currency' => 'usd',
                        'description' => 'One-time payment for Finderspage',
                    ]);

}  catch (\Exception $e) {
    // echo $e->getMessage();

    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );

    if(isset($_SERVER['HTTP_REFERER'])) {
      
     $previous = $_SERVER['HTTP_REFERER'];
Session::flash('error', $e->getMessage().'.');
            return redirect()->to($previous);
   die;
}

}

        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
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
            $featurepost = Video::where('id', $post_id)->first();
            if ($featurepost->id) {
                DB::table('videos')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'post_type' => 'Bump Post',
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
        }
        if($featurepost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your video. We still need to review the changes before they go live.
Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


public function stripe_subscription($user_id,$planname)
    {
        // dd($planname);
        $user_id = General::decrypt($user_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_subscription', ['user_id' => General::encrypt($user_id ),'planname' => $planname, 'public_key' => $public_key]);

        // $FeatureUser = Users::where('id', $user_id)->first();
        // dd($FeatureUser->feature_end_date);
        // if ($FeatureUser->feature_end_date >= date('Y-m-d')) {

        //     Session::flash('success', 'You have already subscribed to the package. Thank you.');
        //     return redirect()->back();
        // } else {
        //     $public_key = AppController::STRIPE_KEY;
        //     return view('frontend.stripe.stripe_subscription', ['user_id' => General::encrypt($user_id), 'public_key' => $public_key]);
        // }
    }

     public function stripe_subscription_save(Request $request)
    {
        //s dd($request->all());
        $start_date = date('Y-m-d');

        $get_duration = explode('-', $request->planprice);

        $planprice = $get_duration[2];
        $end_date = Carbon::now(); // Initialize $end_date as a Carbon instance

        if ($get_duration[1] == 'year' && $get_duration[0] == 1) {
            $duration = 'year';
            $end_date->addMonths(12);
        } elseif ($get_duration[1] == 'month' && $get_duration[0] == 3) {
            $duration = 'month';
            $end_date->addMonths(3);
        } elseif ($get_duration[1] == 'month' && $get_duration[0] == 6) {
            $duration = 'month';
            $end_date->addMonths(6);
        } elseif ($get_duration[1] == 'month' && $get_duration[0] == 1) {
            $duration = 'month';
            $end_date->addMonths(1);
        } elseif ($get_duration[1] == 'day' && $get_duration[0] == 7) {
            $duration = 'day';
            $end_date->addDay(7);
        }

        // Calculate the number of days between start_date and end_date
$number_of_days = $end_date->diffInDays($start_date);

// dd($number_of_days);


$user_id = UserAuth::getLoginId();
$featureUser = Users::where('id', $user_id)->first();

if ($featureUser->feature_end_date !== null) {
    $current_date = strtotime($start_date);
    $feature_end_date = strtotime($featureUser->feature_end_date);
    $differenceInDays = ($feature_end_date - $current_date) / (60 * 60 * 24);
    
    // Add the differenceInDays to $end_date
    $end_date->addDays($differenceInDays);
}

        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

// Format the final $end_date
$end_date_formatted = $end_date->format('Y-m-d');

// dd($end_date_formatted);
 $user = UserAuth::getLoginUser();
 // dd($user->payment_type);
    if($user->payment_type=="Automatic"){
            if($planprice == 14) {
                $plan_name ="7-day-14";
                $featurePostCount = $plan_week->feature_listing;
                $price_id = 'price_1OZnAFKwBKiXM0n5mR5WmE9H';
                $slideshow_limit = 4;
            }else if($planprice == 55) {
                $plan_name ="1-month-55";
                $price_id = 'price_1KdAD6KwBKiXM0n5U355eXY6';
                $featurePostCount = $plan_month->feature_listing;
                $slideshow_limit = 15;
            }else if($planprice == 166) {
                $plan_name ="3-month-166";
                $price_id = 'price_1OgmLEKwBKiXM0n5LAxSh2Wa';
                $featurePostCount = $plan_3month->feature_listing;
                $slideshow_limit = 20;
            } else if($planprice == 333) {
                $plan_name ="6-month-333";
                $price_id = 'price_1OgmMLKwBKiXM0n5k7GOeuJb';
                $featurePostCount = $plan_6month->feature_listing;
                $slideshow_limit = 25;
            } else if($planprice == 777) {
                $plan_name ="1-year-777";
                $price_id = 'price_1OgmNFKwBKiXM0n5cp0x15IJ';
                $featurePostCount = $plan_year->feature_listing;
                $slideshow_limit = 25;
            }
        }else{
            if($planprice == 14) {
                $plan_name ="7-day-14";
                $price_id = 'price_1OgmSGKwBKiXM0n5rkxOU7xF';
                $featurePostCount = $plan_week->feature_listing;
                $slideshow_limit = 4;
            }else if($planprice == 55) {
                $plan_name ="1-month-55";
                $price_id = 'price_1OgmSvKwBKiXM0n5NIeYpopy';
                $featurePostCount = $plan_month->feature_listing;
                $slideshow_limit = 15;
            }else if($planprice == 166) {
                $plan_name ="3-month-166";
                $price_id = 'price_1OgmTUKwBKiXM0n5IZ9vkpAS';
                $featurePostCount = $plan_3month->feature_listing;
                $slideshow_limit = 20;
            } else if($planprice == 333) {
                $plan_name ="6-month-333";
                $price_id = 'price_1OgmTxKwBKiXM0n5nVhoC4Me';
                $featurePostCount = $plan_6month->feature_listing;
                $slideshow_limit = 25;
            } else if($planprice == 777) {
                $plan_name ="1-year-777";
                $price_id = 'price_1OgmVnKwBKiXM0n5d7ZCgUJS';
                $featurePostCount = $plan_year->feature_listing;
                $slideshow_limit = 25;
            }
        }
        
        
       



        $post_id = General::decrypt($request->post_id);
        // $post_id = $request->post_id;
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

          $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);
        

        $data = Stripe\Subscription::create([
                  'customer' => $customer->id,
                  'items' => [
                    ['price' => $price_id],
                  ],
                ]);
} catch (\Exception $e) {
        // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

        if ($data->status=="active") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date_formatted
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($user_id) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date_formatted,'subscribedPlan' =>  $plan_name , 'customer_id' => $data->customer ,  'cancel_at' => 0 ,'featured_post_count' => $featurePostCount,'slideshow_limit' => $slideshow_limit
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
        }
       
            // echo"<pre>"; print_r($strip);    die;
        $currentDate = date('Y-m-d');
        if($user->feature_end_date <=  $currentDate ){

        }
        Session::flash('success', 'Payment successfully.'); 
        
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = $planprice;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = @$get_duration[0] . ' ' . @$get_duration[1];
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


    public function cancelSubscription($id ,$planName)
    {
        $customer_id = UserAuth::getLoginUser();
    try {
        // Retrieve the subscription ID based on the customer and plan
        $customer = $customer_id->customer_id; // Replace with the actual customer ID
        $plan_id = $this->getPlanId($planName); // Function to get the plan ID based on planName

        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new \Stripe\StripeClient('sk_test_51IvRVEKwBKiXM0n5cRwFWWAnEpjaewzmgJZmCT7EY9MRBCSlNWgbefB8EcYvHcPzvkvxLFjib4wnvHhX6sQya5X000BJZWqldJ');

        // Retrieve the customer's subscriptions
        $subscriptions = $stripe->subscriptions->all(['customer' => $customer]);

        // Find the subscription with the matching plan ID
        foreach ($subscriptions as $subscription) {
            if ($subscription->items->data[0]->price->id === $plan_id) {
                // Cancel the subscription
                $stripe->subscriptions->update($subscription->id, ['cancel_at_period_end' => true]);

                 DB::table('users')
                    ->where('id', $id)
                    ->limit(1)
                    ->update([
                        'cancel_at' => 1 
                    ]);

                return redirect()->back()->with(['success' => 'Subscription canceled successfully.']);
            }
        }

        throw new Exception('No subscription found for the specified plan.');
    } catch (Exception $e) {
        // Handle the exception (e.g., log the error, notify admins, etc.)
        error_log('Error cancelling subscription: ' . $e->getMessage());
        return redirect()->back()->with(['error' => 'Error cancelling subscription: ' . $e->getMessage()]);
    }
}

private function getPlanId($planName)
{
    // Map plan names to corresponding price IDs
    $planMap = [
        'weekly' => 'price_1OZnAFKwBKiXM0n5mR5WmE9H',
        'month' => 'price_1KdAD6KwBKiXM0n5U355eXY6',
        'three-month' => 'price_1OgmLEKwBKiXM0n5LAxSh2Wa',
        'six-month' => 'price_1OgmMLKwBKiXM0n5k7GOeuJb',
        'year' => 'price_1OgmNFKwBKiXM0n5cp0x15IJ',
    ];

    if (array_key_exists($planName, $planMap)) {
        return $planMap[$planName];
    }

    throw new Exception('Invalid plan name');
}



public function stripe_job_normal($post_id)
    {
        $post_id = General::decrypt($post_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_job_normal', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        
    }

     public function stripe_job_Normal_Save(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        

    $user = UserAuth::getLoginUser();



    $post_id = General::decrypt($request->post_id);
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

            $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);

            $data = Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => 500, // Charge amount in cents (500 cents = $5)
                'currency' => 'usd',
                'description' => 'One-time payment for Finderspage',
            ]);

} catch (\Exception $e) {
        // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}

         // dd($data);
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Post Updated aginst PostID 
            // dd($post_id);
            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Normal Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $BlogPost->email,
                'feature-post',
                $codes
            );
            // dd($BlogPost);
        }
        if($BlogPost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
            Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
            Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = 5;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = '$5-Normal-listing';
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }



public function stripe_realestate_normal($post_id)
    {
        $post_id = General::decrypt($post_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_normal_realestate', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        
    }

     public function stripe_realestate_Normal_Save(Request $request)
    {
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        

    $user = UserAuth::getLoginUser();



    $post_id = General::decrypt($request->post_id);
try{
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

            $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);

            $data = Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => 300, // Charge amount in cents (500 cents = $5)
                'currency' => 'usd',
                'description' => 'One-time payment for Finderspage',
            ]);
} catch (\Exception $e) {
        // echo $e->getMessage();
    $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
        if(isset($_SERVER['HTTP_REFERER'])) {
          
         $previous = $_SERVER['HTTP_REFERER'];
    Session::flash('error', $e->getMessage().'.');
                return redirect()->to($previous);
       die;
    }
}
         // dd($data);
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Post Updated aginst PostID 
            // dd($post_id);
            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Normal Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $BlogPost->email,
                'feature-post',
                $codes
            );
            // dd($BlogPost);
        }
        if($BlogPost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
            Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live.
            Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = 3;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = '$3-Normal-listing';
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
    }


    public function stripe_shopping_normal($post_id)
    {
        $post_id = General::decrypt($post_id);
        $public_key = AppController::STRIPE_KEY;
            return view('frontend.stripe.stripe_normal_shopping', ['post_id' => General::encrypt($post_id) , 'public_key' => $public_key]);
        
    }

     public function stripe_shopping_Normal_Save(Request $request)
    {
     
        $start_date = date('Y-m-d H:i:s');
        $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
         // echo"<pre>"; print_r($request->all());  die($end_date);
        $get_duration = explode('-', $request->planprice);
        // echo"<pre>"; print_r($get_duration);  die($end_date);
        $planprice = $get_duration[2];
        if ($get_duration[1] == 'day') {
            $duration = 'day';
        } 


        

    $user = UserAuth::getLoginUser();



    $post_id = General::decrypt($request->post_id);
    try {
        Stripe\Stripe::setApiKey(AppController::STRIPE_SECRET);

            $customer = Stripe\Customer::create([
                'email' => $user->email,
                "source" => $request->stripeToken,
                'description' => "Finderspage payment",
            ]);

            $data = Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => 300, // Charge amount in cents (500 cents = $5)
                'currency' => 'usd',
                'description' => 'One-time payment for Finderspage',
            ]);
        } catch (\Exception $e) {
            $codes = [
                '{first_name}' => $user->first_name,
            ];
  
            General::sendTemplateEmail(
                $user->email,
                'payment-failed',
                $codes
            );
            // Handle the exception here
            // You can log the error, redirect to an error page, or handle it in any way that fits your application
            // For example, log the error and redirect to a specific error page:
            Log::error($e->getMessage());
            Session::flash('error',$e->getMessage());
            return redirect()->back();
        }
         // dd($data);
        if ($data->status=="succeeded") {
            DB::table('post_payments')->insert(
                [
                    'payment_id' => $data->id,
                    'post_id' => $post_id,
                    'balance_transaction' => $planprice,
                    // 'payment_method' => $strip->payment_method,
                    // 'payment_method_details' => json_encode($strip->payment_method_details),
                    // 'outcome' => json_encode($strip->outcome),
                    // 'paid' => json_encode($strip->paid),
                    'duration' => @$get_duration[0] . '-' . @$get_duration[1],
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Post Updated aginst PostID 
            // dd($post_id);
            $BlogPost = Blogs::where('id', $post_id)->first();
             // 
            if ($BlogPost->id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'post_type' => 'Normal Post',
                        'draft' => '1'
                    ]);
            }

            $codes = [
                '{name}' => $user->first_name,
            ];

            General::sendTemplateEmail(
                $BlogPost->email,
                'feature-post',
                $codes
            );
            // dd($BlogPost);
        }
        if($BlogPost->status == 1){
            Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live. Please allow us to approve it. Thank you for understanding.');
        }else{
            // echo"<pre>"; print_r($strip);    die;
        Session::flash('success', 'Payment successful. Thanks for your listing. We still need to review the changes before they go live. Please allow us to approve it. Thank you for understanding.'); 
        }
       
        $dataa = array();
        $dataa['payment_id'] = $data->id;
        $dataa['amount'] = 3;
        $dataa['created_at'] = $start_date;
        $dataa['receipt_url'] = '';
        $dataa['plan_name'] = '$3-Normal-listing';
        return view("frontend.stripe.thankyou", ['datas' => $dataa]);
        //return redirect()->to($strip->receipt_url);
        
    }
}