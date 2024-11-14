<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ANet\Subscription;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use DateTime;
use DB;
use App\Libraries\General;
use App\Models\Business;
use App\Models\UserAuth;
use Carbon\Carbon;
use App\Models\Admin\Users;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Entertainment;
use App\Models\Video;
use App\Models\Admin\Notification;
use App\Models\Admin\SubPlan;
use Exception;
use Auth;

class AuthorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postID)
    {
        $post_id = General::decrypt($postID);
        $userData =  UserAuth::getLoginUser();

        if(!empty($userData->bump_post_count) && $userData->bump_post_count > 0 ){

            $new_bumppost_count = (int) $userData->bump_post_count - 1;
            $start_date = Carbon::now();
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            if ($post_id && $userData->id) {
                DB::table('users')
                    ->where('id', $userData->id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' => $new_bumppost_count,
                    ]);
            }

             // Post Updated aginst PostID 
           
            if ($post_id) {
                DB::table('blogs')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }

        

            $post_data = Blogs::where('id',$post_id)->first();

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 705,
                'type' => 'subscription',
                'rel_id' => $post_data->id,
                'message' => "A new bump listing \"{$post_data->title}\" is created by {$userData->username}.",
                'url' => route('service_single', $post_data->slug),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'cate_id' => 705,
                'type' => 'payment',
                'rel_id' => $post_data->id,
                'message' => "Your listing \"{$post_data->title}\" has been bumped.",
                'url' => route('service_single', $post_data->slug),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $userData->first_name,
                '{post_url}' => route('service_single', $post_data->slug),
            ];

            General::sendTemplateEmail(
                $userData->email,
                'Bump-post-success',
                $codes
            );

            if($post_data->status==1){
                return redirect()->back()->with(['success' =>'Thank you for your payment. Your listing is bumped successfully.']);
            }else{
                redirect()->back()
                ->with('success', 'Thank you for your payment. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            }

        }
        
        return view('frontend.authorize.bump_listing',compact('post_id'));
    }

    public function create($postID)
    {
        $post_id = General::decrypt($postID);
        $userData =  UserAuth::getLoginUser();
        if(!empty($userData->bump_post_count) && $userData->bump_post_count > 0 ){
            
            $new_bumppost_count = (int) $userData->bump_post_count - 1;
            $start_date = Carbon::now();
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            if ($post_id && $userData->id) {
                DB::table('users')
                    ->where('id', $userData->id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' => $new_bumppost_count,
                    ]);
            }

             // Post Updated aginst PostID 
           
            if ($post_id) {
                DB::table('blog_post')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }

            $post_data = BlogPost::where('id',$post_id)->first();

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 728,
                'type' => 'subscription',
                'rel_id' => $post_data->id,
                'message' => "A new bump blog \"{$post_data->title}\" is created by {$userData->username}.",
                'url' => route('blogPostSingle', ['slug' => $post_data->slug]),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'cate_id' => 728,
                'type' => 'payment',
                'rel_id' => $post_data->id,
                'message' => "Your blog \"{$post_data->title}\" has been bumped.",
                'url' => route('blogPostSingle', ['slug' => $post_data->slug]),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $userData->first_name,
                '{post_url}' => route('service_single',$post_data->slug),
            ];

            General::sendTemplateEmail(
                $userData->email,
                'Bump-post-success',
                $codes
            );

            if($post_data->status==1){
                return redirect()->back()->with(['success' =>'Thank you for your payment. Your listing is bumped successfully.']);
            }else{
                redirect()->back()
                ->with('success', 'Thank you for your payment. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            }   
        }

        return view('frontend.paypal.blog_bump',compact('post_id'));
        // return view('frontend.authorize.bump_blogs',compact('post_id'));
    }


    public function create_business_bump($postID)
    {
        $post_id = General::decrypt($postID);
        $userData =  UserAuth::getLoginUser();
        if(!empty($userData->bump_post_count) && $userData->bump_post_count > 0 ){
            
            $new_bumppost_count = (int) $userData->bump_post_count - 1;
            $start_date = Carbon::now();
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            if ($post_id && $userData->id) {
                DB::table('users')
                    ->where('id', $userData->id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' => $new_bumppost_count,
                    ]);
            }

             // Post Updated aginst PostID 
           
            if ($post_id) {
                DB::table('businesses')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }
            $Business = Business::where('id',$post_id)->first();

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 1,
                'type' => 'subscription',
                'rel_id' => $Business->id,
                'message' => "A new bump business \"{$Business->business_name}\" is created by {$userData->username}.",
                'url' => route('business_page.front.single.listing', $Business->slug),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'cate_id' => 1,
                'type' => 'payment',
                'rel_id' => $Business->id,
                'message' => "Your business \"{$Business->business_name}\" has been bumped.",
                'url' => route('business_page.front.single.listing', $Business->slug),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $userData->first_name,
                '{post_url}' => route('service_single',$Business->slug),
            ];

            General::sendTemplateEmail(
                $userData->email,
                'Bump-post-success',
                $codes
            );

            if($Business->status==1){
                return redirect()->back()->with(['success' =>'Thank you for your payment. Your listing is bumped successfully.']);
            }else{
                redirect()->back()
                ->with('success', 'Thank you for your payment. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            }   
        }

        return view('frontend.paypal.business_bump',compact('post_id'));
        // return view('frontend.authorize.bump_blogs',compact('post_id'));
    }

    public function entertainment_bump($postID)
    {
        $post_id = General::decrypt($postID);
        $userData =  UserAuth::getLoginUser();
        if(!empty($userData->bump_post_count) && $userData->bump_post_count > 0 ){
            
            $new_bumppost_count = (int) $userData->bump_post_count - 1;
            $start_date = Carbon::now();
            $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
            if ($post_id && $userData->id) {
                DB::table('users')
                    ->where('id', $userData->id)
                    ->limit(1)
                    ->update([
                        'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date ,'bump_post_count' => $new_bumppost_count,
                    ]);
            }

             // Post Updated aginst PostID 
           
            if ($post_id) {
                DB::table('Entertainment')
                    ->where('id', $post_id)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }

        

            $post_data = Entertainment::where('id',$post_id)->first();
            
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 741,
                'type' => 'subscription',
                'rel_id' => $post_data->id,
                'message' => "A new bump listing \"{$post_data->Title}\" is created by {$userData->username}.",
                'url' => route('Entertainment.single.listing', $post_data->slug),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'cate_id' => 741,
                'type' => 'payment',
                'rel_id' => $post_data->id,
                'message' => "Your listing \"{$post_data->Title}\" has been bumped.",
                'url' => route('Entertainment.single.listing', $post_data->slug),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $userData->first_name,
                '{post_url}' => route('service_single',$post_data->slug),
            ];

            General::sendTemplateEmail(
                $userData->email,
                'Bump-post-success',
                $codes
            );
            if($post_data->status==1){
                return redirect()->back()->with(['success' =>'Thank you for your payment. Your listing is bumped successfully.']);
            }else{
                redirect()->back()
                ->with('success', 'Thank you for your payment. We still need to review it before it goes live. Will let you know once its approved. Thank you for understanding.');
            }
              
        }

        return view('frontend.authorize.bump_entertainment',compact('post_id'));
    }

    public function reccuring_billing($id, $planname)
    {
        $id = General::decrypt($id);
        return view('frontend.authorize.subscription',compact('id','planname'));
    }

    public function paid_Post($id,$type)
    {
        $post_id = General::decrypt($id);
        return view('frontend.authorize.paid_listing',compact('post_id','type'));
    }


    public function reccuring_featured($postid)
    {
        $id = General::decrypt($postid);
        return view('frontend.authorize.featured_listing',compact('id'));
    }


    public function reccuring_featured_blog($postid)
    {
        $id = General::decrypt($postid);
        return view('frontend.authorize.featured_listing',compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,$postID)
    {
    // dd($request->all());
    $price = $request->planprice;
    $name = $request->cardholdername;
    $cardnumber = $request->cardnumber;
    $cardcvc = $request->cardcvc;
    $cardexpirymonth = $request->cardexpirymonth;
    $cardexpiryyear = $request->cardexpiryyear;

    $user = UserAuth::getLoginUser();
    $featurepost = Blogs::where('id', $postID)->first();

    $start_date = Carbon::now();
    $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
    $get_duration =1;

    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName('3zN8Wt8hY');
    $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
    $creditCard->setCardCode($cardcvc);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($postID);
    $order->setDescription($featurepost->title);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("$user->id");
    $customerData->setEmail($user->email);
    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setCustomer($customerData);
    // $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
  
    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    // dd($response);
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                DB::table('post_payments')->insert(
                [
                    'user_id' => $user->id,
                    'payment_id' => $tresponse->getTransId(),
                    'post_id' => $postID,
                    'payment_method' =>"Authorize/credit-debit-card",
                    'balance_transaction' => $price,
                    'type' => 'listing-bump',
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
                        'isbump_post' => '1','bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                    ]);
            }

             // Post Updated aginst PostID 
           
            if ($featurepost->id) {
                DB::table('blogs')
                    ->where('id', $postID)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'subscription',
                'rel_id' => $featurepost->id,
                'message' => "A new bump listing \"{$featurepost->title}\" is created by {$user->username}.",
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Your listing \"{$featurepost->title}\" has been bumped.",
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $featureUser->first_name,
                '{post_url}' => route('service_single',$featurepost->slug),
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
                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
                }
            }
           
        } else {
           
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {

                 return redirect()
                ->back()
                ->with('error', $tresponse->getErrors()[0]->getErrorCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
            } else {
                return redirect()
                ->back()
                ->with('error', $response->getMessages()->getMessage()[0]->getCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
            }
        }
    } else {
       return redirect()
        ->route('index_user')
        ->with('error','Something went wrong.');
    }
              
    }




    public function business_bump_listing(Request $request ,$postID)
    {
    // dd($request->all());
    $price = $request->planprice;
    $name = $request->cardholdername;
    $cardnumber = $request->cardnumber;
    $cardcvc = $request->cardcvc;
    $cardexpirymonth = $request->cardexpirymonth;
    $cardexpiryyear = $request->cardexpiryyear;

    $user = UserAuth::getLoginUser();
    $featurepost = Business::where('id', $postID)->first();

    $start_date = Carbon::now();
    $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
    $get_duration =1;

    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName('3zN8Wt8hY');
    $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
    $creditCard->setCardCode($cardcvc);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($postID);
    $order->setDescription($featurepost->title);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("$user->id");
    $customerData->setEmail($user->email);
    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setCustomer($customerData);
    // $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
  
    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    // dd($response);
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                DB::table('post_payments')->insert( 
                    [
                        'user_id' => $user->id,
                        'payment_id' => $tresponse->getTransId(),
                        'post_id' => $postID,
                        'payment_method' =>"Authorize/credit-debit-card",
                        'balance_transaction' => $price,
                        'type' => 'listing-bump',
                        'duration' => $get_duration,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]
                    
                );

                $user_id = UserAuth::getLoginId();
                $featureUser = Users::where('id', $user_id)->first();
                if ($postID && $user_id) {
                    DB::table('users')
                        ->where('id', $user_id)
                        ->limit(1)
                        ->update([
                            'isbump_post' => '1', 'bumpPost_start_date' => $start_date, 'bumpPost_end_date' => $end_date
                        ]);
                }
    
                 // Post Updated aginst PostID 
                $Business = Business::where('id', $postID)->first();
                if ($Business->id) {
                    DB::table('businesses')
                        ->where('id', $postID)
                        ->limit(1)
                        ->update([
                            'type' => 'Bump',
                            'bumpPost' => 1,
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
                return redirect()
                ->route('index_user')
                ->with('success', 'Thank you for your payment.');
            } else {
                if ($tresponse->getErrors() != null) {
                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
                }
            }
           
        } else {
           
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {

                 return redirect()
                ->back()
                ->with('error', $tresponse->getErrors()[0]->getErrorCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
            } else {
                return redirect()
                ->back()
                ->with('error', $response->getMessages()->getMessage()[0]->getCode().$tresponse->getErrors()[0]->getErrorText()  ?? 'Something went wrong.');
            }
        }
    } else {
       return redirect()
        ->route('index_user')
        ->with('error','Something went wrong.');
    }
              
}



public function bump_blog_post(Request $request ,$postID)
    {
    // dd($request->all());
    $price = $request->planprice;
    $name = $request->cardholdername;
    $cardnumber = $request->cardnumber;
    $cardcvc = $request->cardcvc;
    $cardexpirymonth = $request->cardexpirymonth;
    $cardexpiryyear = $request->cardexpiryyear;

    $user = UserAuth::getLoginUser();
    $featurepost = BlogPost::where('id', $postID)->first();

    $start_date = Carbon::now();
    $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
    $get_duration =1;

    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    // $merchantAuthentication->setName('2BxyK457');
    // $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
    $merchantAuthentication->setName('8Ar82A28Tvz');
    $merchantAuthentication->setTransactionKey('39nWWAs28668jJUc');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
    $creditCard->setCardCode($cardcvc);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($postID);
    $order->setDescription($featurepost->title);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("$user->id");
    $customerData->setEmail($user->email);

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    // $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);
    // $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
  
    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                DB::table('post_payments')->insert(
                [
                    'payment_id' => $tresponse->getTransId(),
                    'post_id' => $postID,
                    'balance_transaction' => $price,
                    'type' => 'blog',
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
                DB::table('blog_post')
                    ->where('id', $postID)
                    ->limit(1)
                    ->update([
                        'bumpPost' => '1',
                        'bump_start' => $start_date,
                        'bump_end' => $end_date,
                        'draft' => '1',
                    ]);
            }

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'cate_id' => 728,
                'type' => 'subscription',
                'rel_id' => $featurepost->id,
                'message' => "A new bump blog \"{$featurepost->title}\" is created by {$user->username}.",
                'url' => route('blogPostSingle', ['slug' => $featurepost->slug]),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'cate_id' => 728,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Your blog \"{$featurepost->title}\" has been bumped.",
                'url' => route('blogPostSingle', ['slug' => $featurepost->slug]),
            ];
            Notification::create($notice);

            $codes = [
                '{first_name}' => $featureUser->first_name,
                '{post_url}' => route('blogPostSingle',$featurepost->slug),
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
                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
                }
            }
           
        } else {
           
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {

                 return redirect()
                ->back()
                ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            } else {
                return redirect()
                ->back()
                ->with('error', $response->getMessages()->getMessage()[0]->getCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            }
        }
    } else {
       return redirect()
        ->route('index_user')
        ->with('error','Something went wrong.');
    }
              
    }

public function bump_entertainment_post(Request $request ,$postID)
    {
    // dd($request->all());
    $price = $request->planprice;
    $name = $request->cardholdername;
    $cardnumber = $request->cardnumber;
    $cardcvc = $request->cardcvc;
    $cardexpirymonth = $request->cardexpirymonth;
    $cardexpiryyear = $request->cardexpiryyear;

    $user = UserAuth::getLoginUser();
    $featurepost = Entertainment::where('id', $postID)->first();
// dd($featurepost);
    $start_date = Carbon::now();
    $end_date = Carbon::now()->addDay()->format('Y-m-d H:i:s');
    $get_duration =1;

    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    // $merchantAuthentication->setName('2BxyK457');
    // $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
    $merchantAuthentication->setName('3zN8Wt8hY');
    $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
    $creditCard->setCardCode($cardcvc);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($postID);
    $order->setDescription($featurepost->Title);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("$user->id");
    $customerData->setEmail($user->email);

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    // $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);
    // $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
  
    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                DB::table('post_payments')->insert(
                [
                    'user_id' => $user->id,
                    'payment_id' => $tresponse->getTransId(),
                    'post_id' => $postID,
                    'payment_method' =>"Authorize/credit-debit-card",
                    'balance_transaction' => $price,
                    'type' => 'listing-bump',
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
                'type' => 'subscription',
                'rel_id' => $featurepost->id,
                'message' => "A new bump listing \"{$featurepost->Title}\" is created by {$user->username}.",
                'url' => route('Entertainment.single.listing', $featurepost->slug),
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'cate_id' => 741,
                'type' => 'payment',
                'rel_id' => $featurepost->id,
                'message' => "Your listing \"{$featurepost->Title}\" has been bumped.",
                'url' => route('Entertainment.single.listing', $featurepost->slug),
            ];
            Notification::create($notice);
            $codes = [
                '{first_name}' => $featureUser->first_name,
                '{post_url}' => route('Entertainment.single.listing',$featurepost->slug),
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
                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
                }
            }
           
        } else {
           
            $tresponse = $response->getTransactionResponse();

        
            if ($tresponse != null && $tresponse->getErrors() != null) {
                 // dd($tresponse->getErrors());
                 return redirect()
                ->back()
                ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            } else {
                return redirect()
                ->back()
                ->with('error', $response->getMessages()->getMessage()[0]->getCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            }
        }
    } else {
       return redirect()
        ->route('index_user')
        ->with('error','Something went wrong.');
    }
              
    }



function createSubscription(Request $request , $id)
{
        $start_date = Carbon::now();
        $name = $request->cardholdername;
        $cardnumber = $request->cardnumber;
        $cardcvc = $request->cardcvc;
        $cardexpirymonth = $request->cardexpirymonth;
        $cardexpiryyear = $request->cardexpiryyear;
        $userData = UserAuth::getLoginUser();
        $user = Auth::user();
        $planname = $request->planname;
        // dd($planname);

        if($planname=='Weekly'){
            $plan_title='weekly';
            $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Weekly')->first();
            $paid_postCount ='2';
            $intervalLength = 7;
            $totalOccurrences = 52;
        }elseif($planname=='Monthly'){
            $plan_title='month';
            $intervalLength = 30;
            $totalOccurrences = 12;
            $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Monthly')->first();
            $paid_postCount ='4';
        }elseif($planname=="Three Month's"){
            $plan_title='three-month';
            $intervalLength = 90;
            $totalOccurrences = 4;
            $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Three Month's")->first();
            $paid_postCount ='6';
        }elseif($planname=="Six Month's"){
            $plan_title='six-month';
            $intervalLength = 180;
            $totalOccurrences = 2;
            $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Six Month's")->first();
            $paid_postCount ='8';
        }elseif($planname=="Yearly"){
            $plan_title='yearly';
            $intervalLength = 365;
            $totalOccurrences = 1;
            $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Yearly")->first();
            $paid_postCount ='10';
        }
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        //   $merchantAuthentication->setName('2BxyK457');
        //   $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
        $merchantAuthentication->setName('3zN8Wt8hY');
        $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
           
          $refId = 'ref' . time();
      
          // Subscription Type Info
          $subscription = new AnetAPI\ARBSubscriptionType();
          $subscription->setName($planData->plan);
      
          $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
          $interval->setLength($intervalLength);
          $interval->setUnit("days");
      
      
          $paymentSchedule = new AnetAPI\PaymentScheduleType();
          $paymentSchedule->setInterval($interval);
          $paymentSchedule->setStartDate(new DateTime($start_date));
          $paymentSchedule->setTotalOccurrences($totalOccurrences);
          $paymentSchedule->setTrialOccurrences("0");
      
          $subscription->setPaymentSchedule($paymentSchedule);
          $subscription->setAmount($planData->price);
          $subscription->setTrialAmount("0.00");
          
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($cardnumber);
          $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
      
          $payment = new AnetAPI\PaymentType();
          $payment->setCreditCard($creditCard);
          $subscription->setPayment($payment);
      
          $order = new AnetAPI\OrderType();
          $order->setInvoiceNumber($id);        
          $order->setDescription($planname); 
          $subscription->setOrder($order); 
          
          $billTo = new AnetAPI\NameAndAddressType();
          $billTo->setFirstName($userData->first_name);
          $billTo->setLastName($userData->first_name);
      
          $subscription->setBillTo($billTo);
          $request = new AnetAPI\ARBCreateSubscriptionRequest();
          $request->setmerchantAuthentication($merchantAuthentication);
          $request->setRefId($refId);
          $request->setSubscription($subscription);
          $controller = new AnetController\ARBCreateSubscriptionController($request);
      
          $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
      
        //    DD($response);
          
           if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
            DB::table('post_payments')->insert(
                [
                    'user_id' => $user->id,
                    'payment_id' => $response->getSubscriptionId(),
                    'post_id' => null,
                    'payment_method' =>"Authorize/credit-debit-card",
                    'duration' => $intervalLength,
                    'type' => 'subscription',
                    'balance_transaction' =>$planData->price,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($userData->id) {
                DB::table('users')
                    ->where('id',$userData->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date, 'subscribedPlan' =>  $plan_title , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing, 'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,'paypal_subscriptionID' =>$response->getSubscriptionId(),'payment_type' =>'Authorize/credit-debit-card',
                    ]);
            }


            $new_post_count = (int) $userData->featured_post_count - 1;
            Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);



            DB::table('blogs')
              ->where('id', $id)
              ->limit(1)
              ->update([
                  'featured_post' => 'on',
                  'draft' => '1',
              ]);

            $notice = [
                'from_id' => $userData->id,
                'to_id' => 7,
                'type' => 'post',
                'url' =>route('UserProfileFrontend',$userData->slug),
                'message' => 'New plan ' . $planname . ' subscribe by ' . $userData->first_name . '.',
                ];
            Notification::create($notice); 


            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'type' => 'payment',
                'message' => 'Thank you for your payment. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
            ];
            Notification::create($notice);

            $codes = [
                '{name}' => $userData->first_name,
            ];

            General::sendTemplateEmail(
                $userData->email,
                'feature-post',
                $codes
            );
            return redirect()
                    ->route('index_user')
                    ->with('success', 'Thank you for your payment.');
        }
        else
        {
        
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";

            return redirect()
                    ->back()
                    ->with('error', $response->getMessages()->getMessage()[0]->getCode().'--'.$errorMessages[0]->getText() ?? 'Something went wrong.');
        }
    
    // return $response;
  }


  function create_business_featured_Subscription(Request $request , $id)
{
    // dd($request->all());
        $id = General::decrypt($id);
        $start_date = Carbon::now();
        $name = $request->cardholdername;
        $cardnumber = $request->cardnumber;
        $cardcvc = $request->cardcvc;
        $cardexpirymonth = $request->cardexpirymonth;
        $cardexpiryyear = $request->cardexpiryyear;
        $userData = UserAuth::getLoginUser();
        $user = Auth::user();
        $planname = $request->planname;
        // dd($planname);

        if($planname=='Weekly'){
            $plan_title='weekly';
            $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Weekly')->first();
            $paid_postCount ='2';
            $intervalLength = 7;
            $totalOccurrences = 52;
        }elseif($planname=='Monthly'){
            $plan_title='month';
            $intervalLength = 30;
            $totalOccurrences = 12;
            $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Monthly')->first();
            $paid_postCount ='4';
        }elseif($planname=="Three Month's"){
            $plan_title='three-month';
            $intervalLength = 90;
            $totalOccurrences = 4;
            $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Three Month's")->first();
            $paid_postCount ='6';
        }elseif($planname=="Six Month's"){
            $plan_title='six-month';
            $intervalLength = 180;
            $totalOccurrences = 2;
            $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Six Month's")->first();
            $paid_postCount ='8';
        }elseif($planname=="Yearly"){
            $plan_title='yearly';
            $intervalLength = 365;
            $totalOccurrences = 1;
            $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Yearly")->first();
            $paid_postCount ='10';
        }
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        //   $merchantAuthentication->setName('2BxyK457');
        //   $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
        $merchantAuthentication->setName('3zN8Wt8hY');
        $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
           
          $refId = 'ref' . time();
      
          // Subscription Type Info
          $subscription = new AnetAPI\ARBSubscriptionType();
          $subscription->setName($planData->plan);
      
          $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
          $interval->setLength($intervalLength);
          $interval->setUnit("days");
      
      
          $paymentSchedule = new AnetAPI\PaymentScheduleType();
          $paymentSchedule->setInterval($interval);
          $paymentSchedule->setStartDate(new DateTime($start_date));
          $paymentSchedule->setTotalOccurrences($totalOccurrences);
          $paymentSchedule->setTrialOccurrences("0");
      
          $subscription->setPaymentSchedule($paymentSchedule);
          $subscription->setAmount($planData->price);
          $subscription->setTrialAmount("0.00");
          
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($cardnumber);
          $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
      
          $payment = new AnetAPI\PaymentType();
          $payment->setCreditCard($creditCard);
          $subscription->setPayment($payment);
      
          $order = new AnetAPI\OrderType();
          $order->setInvoiceNumber($id);        
          $order->setDescription($planname); 
          $subscription->setOrder($order); 
          
          $billTo = new AnetAPI\NameAndAddressType();
          $billTo->setFirstName($userData->first_name);
          $billTo->setLastName($userData->first_name);
      
          $subscription->setBillTo($billTo);
          $request = new AnetAPI\ARBCreateSubscriptionRequest();
          $request->setmerchantAuthentication($merchantAuthentication);
          $request->setRefId($refId);
          $request->setSubscription($subscription);
          $controller = new AnetController\ARBCreateSubscriptionController($request);
      
          $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
      
        //    DD($response);
          
           if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
            DB::table('post_payments')->insert(
                [
                    'user_id' => $user->id,
                    'payment_id' => $response->getSubscriptionId(),
                    'post_id' => null,
                    'payment_method' =>"Authorize/credit-debit-card",
                    'duration' => $intervalLength,
                    'type' => 'subscription',
                    'balance_transaction' =>$planData->price,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($userData->id) {
                DB::table('users')
                    ->where('id',$userData->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date, 'subscribedPlan' =>  $plan_title , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing, 'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,'paypal_subscriptionID' =>$response->getSubscriptionId(),'payment_type' =>'Authorize/credit-debit-card',
                    ]);
            }


            $new_post_count = (int) $userData->featured_post_count - 1;
            Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);



            DB::table('businesses')
              ->where('id', $id)
              ->limit(1)
              ->update([
                  'featured' => 'on',
                  'draft' => '1',
              ]);

            $notice = [
                'from_id' => $userData->id,
                'to_id' => 7,
                'type' => 'post',
                'url' =>route('UserProfileFrontend',$userData->slug),
                'message' => 'New plan ' . $planname . ' subscribe by ' . $userData->first_name . '.',
                ];
            Notification::create($notice); 


            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'type' => 'payment',
                'message' => 'Thank you for your payment. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
            ];
            Notification::create($notice);

            $codes = [
                '{name}' => $userData->first_name,
            ];

            General::sendTemplateEmail(
                $userData->email,
                'feature-post',
                $codes
            );
            return redirect()
                    ->route('index_user')
                    ->with('success', 'Thank you for your payment.');
        }
        else
        {
        
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";

            return redirect()
                    ->back()
                    ->with('error', $response->getMessages()->getMessage()[0]->getCode().'--'.$errorMessages[0]->getText() ?? 'Something went wrong.');
        }
    
    // return $response;
  }

  function create_entertainment_featured_Subscription(Request $request , $id)
  {
      // dd($request->all());
          $id = General::decrypt($id);
          $start_date = Carbon::now();
          $name = $request->cardholdername;
          $cardnumber = $request->cardnumber;
          $cardcvc = $request->cardcvc;
          $cardexpirymonth = $request->cardexpirymonth;
          $cardexpiryyear = $request->cardexpiryyear;
          $userData = UserAuth::getLoginUser();
          $user = Auth::user();
          $planname = $request->planname;
          // dd($planname);
  
          if($planname=='Weekly'){
              $plan_title='weekly';
              $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
              $planData = SubPlan::where('plan', 'Weekly')->first();
              $paid_postCount ='2';
              $intervalLength = 7;
              $totalOccurrences = 52;
          }elseif($planname=='Monthly'){
              $plan_title='month';
              $intervalLength = 30;
              $totalOccurrences = 12;
              $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
              $planData = SubPlan::where('plan', 'Monthly')->first();
              $paid_postCount ='4';
          }elseif($planname=="Three Month's"){
              $plan_title='three-month';
              $intervalLength = 90;
              $totalOccurrences = 4;
              $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
              $planData = SubPlan::where('plan', "Three Month's")->first();
              $paid_postCount ='6';
          }elseif($planname=="Six Month's"){
              $plan_title='six-month';
              $intervalLength = 180;
              $totalOccurrences = 2;
              $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
              $planData = SubPlan::where('plan', "Six Month's")->first();
              $paid_postCount ='8';
          }elseif($planname=="Yearly"){
              $plan_title='yearly';
              $intervalLength = 365;
              $totalOccurrences = 1;
              $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
              $planData = SubPlan::where('plan', "Yearly")->first();
              $paid_postCount ='10';
          }
          $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
          //   $merchantAuthentication->setName('2BxyK457');
          //   $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
          $merchantAuthentication->setName('3zN8Wt8hY');
          $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
             
            $refId = 'ref' . time();
        
            // Subscription Type Info
            $subscription = new AnetAPI\ARBSubscriptionType();
            $subscription->setName($planData->plan);
        
            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength($intervalLength);
            $interval->setUnit("days");
        
        
            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            $paymentSchedule->setInterval($interval);
            $paymentSchedule->setStartDate(new DateTime($start_date));
            $paymentSchedule->setTotalOccurrences($totalOccurrences);
            $paymentSchedule->setTrialOccurrences("0");
        
            $subscription->setPaymentSchedule($paymentSchedule);
            $subscription->setAmount($planData->price);
            $subscription->setTrialAmount("0.00");
            
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardnumber);
            $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
        
            $payment = new AnetAPI\PaymentType();
            $payment->setCreditCard($creditCard);
            $subscription->setPayment($payment);
        
            $order = new AnetAPI\OrderType();
            $order->setInvoiceNumber($id);        
            $order->setDescription($planname); 
            $subscription->setOrder($order); 
            
            $billTo = new AnetAPI\NameAndAddressType();
            $billTo->setFirstName($userData->first_name);
            $billTo->setLastName($userData->first_name);
        
            $subscription->setBillTo($billTo);
            $request = new AnetAPI\ARBCreateSubscriptionRequest();
            $request->setmerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBCreateSubscriptionController($request);
        
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        
          //    DD($response);
            
             if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
          {
              // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
              DB::table('post_payments')->insert(
                  [
                      'user_id' => $user->id,
                      'payment_id' => $response->getSubscriptionId(),
                      'post_id' => null,
                      'payment_method' =>"Authorize/credit-debit-card",
                      'duration' => $intervalLength,
                      'type' => 'subscription',
                      'balance_transaction' =>$planData->price,
                      'start_date' => $start_date,
                      'end_date' => $end_date
                  ]
              );
  
              // Update User         
  
              
              // dd($featureUser);
              if ($userData->id) {
                  DB::table('users')
                      ->where('id',$userData->id)
                      ->limit(1)
                      ->update([
                          'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date, 'subscribedPlan' =>  $plan_title , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing, 'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,'paypal_subscriptionID' =>$response->getSubscriptionId(),'payment_type' =>'Authorize/credit-debit-card',
                      ]);
              }
  
  
              $new_post_count = (int) $userData->featured_post_count - 1;
              Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);
  
  
  
              DB::table('Entertainment')
                ->where('id', $id)
                ->limit(1)
                ->update([
                    'featured_post' => 'on',
                    'draft' => '1',
                ]);
  
              $notice = [
                  'from_id' => $userData->id,
                  'to_id' => 7,
                  'type' => 'post',
                  'url' =>route('UserProfileFrontend',$userData->slug),
                  'message' => 'New plan ' . $planname . ' subscribe by ' . $userData->first_name . '.',
                  ];
              Notification::create($notice); 
  
  
              $notice = [
                  'from_id' => UserAuth::getLoginId(),
                  'to_id' => $userData->id,
                  'type' => 'payment',
                  'message' => 'Thank you for your payment. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
              ];
              Notification::create($notice);
  
              $codes = [
                  '{name}' => $userData->first_name,
              ];
  
              General::sendTemplateEmail(
                  $userData->email,
                  'feature-post',
                  $codes
              );
              return redirect()
                      ->route('index_user')
                      ->with('success', 'Thank you for your payment.');
          }
          else
          {
          
              $errorMessages = $response->getMessages()->getMessage();
              // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
  
              return redirect()
                      ->back()
                      ->with('error', $response->getMessages()->getMessage()[0]->getCode().'--'.$errorMessages[0]->getText() ?? 'Something went wrong.');
          }
      
      // return $response;
    }


  function create_featured_Subscription(Request $request , $id ,$planname)
    {
    
        $start_date = Carbon::now();
        $name = $request->cardholdername;
        $cardnumber = $request->cardnumber;
        $cardcvc = $request->cardcvc;
        $cardexpirymonth = $request->cardexpirymonth;
        $cardexpiryyear = $request->cardexpiryyear;
        $userData = UserAuth::getLoginUser();
        $user = Auth::user();
        // dd($user);

        if($planname=='weekly'){
           
            $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Weekly')->first();
            $paid_postCount ='2';
            $intervalLength = 7;
            $totalOccurrences = 52;
        }elseif($planname=='month'){
            $intervalLength = 30;
            $totalOccurrences = 12;
            $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Monthly')->first();
            $paid_postCount ='4';
        }elseif($planname=="three-month"){
            $intervalLength = 90;
            $totalOccurrences = 4;
            $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Three Month's")->first();
            $paid_postCount ='6';
        }elseif($planname=="six-month"){
            $intervalLength = 180;
            $totalOccurrences = 2;
            $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Six Month's")->first();
            $paid_postCount ='8';
        }elseif($planname=="year"){
            $intervalLength = 365;
            $totalOccurrences = 1;
            $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Yearly")->first();
            $paid_postCount ='10';
        }
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        //   $merchantAuthentication->setName('2BxyK457');
        //   $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
        $merchantAuthentication->setName('3zN8Wt8hY');
        $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
           
          $refId = 'ref' . time();
      
          // Subscription Type Info
          $subscription = new AnetAPI\ARBSubscriptionType();
          $subscription->setName($planData->plan);
      
          $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
          $interval->setLength($intervalLength);
          $interval->setUnit("days");
      
      
          $paymentSchedule = new AnetAPI\PaymentScheduleType();
          $paymentSchedule->setInterval($interval);
          $paymentSchedule->setStartDate(new DateTime($start_date));
          $paymentSchedule->setTotalOccurrences($totalOccurrences);
          $paymentSchedule->setTrialOccurrences("0");
      
          $subscription->setPaymentSchedule($paymentSchedule);
          $subscription->setAmount($planData->price);
          $subscription->setTrialAmount("0.00");
          
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($cardnumber);
          $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
      
          $payment = new AnetAPI\PaymentType();
          $payment->setCreditCard($creditCard);
          $subscription->setPayment($payment);
      
          $order = new AnetAPI\OrderType();
          $order->setInvoiceNumber($id);        
          $order->setDescription($planname); 
          $subscription->setOrder($order); 
          
          $billTo = new AnetAPI\NameAndAddressType();
          $billTo->setFirstName($userData->first_name);
          $billTo->setLastName($userData->first_name);
      
          $subscription->setBillTo($billTo);
          $request = new AnetAPI\ARBCreateSubscriptionRequest();
          $request->setmerchantAuthentication($merchantAuthentication);
          $request->setRefId($refId);
          $request->setSubscription($subscription);
          $controller = new AnetController\ARBCreateSubscriptionController($request);
      
          $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
      
        //    DD($response);
          
           if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
            DB::table('post_payments')->insert(
                [
                    'user_id' => $user->id,
                    'payment_id' => $response->getSubscriptionId(),
                    'post_id' => null,
                    'payment_method' =>"Authorize/credit-debit-card",
                    'duration' => $intervalLength,
                    'type' => 'subscription',
                    'balance_transaction' =>$planData->price,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            );

            // Update User         

            
            // dd($featureUser);
            if ($userData->id) {
                DB::table('users')
                    ->where('id',$userData->id)
                    ->limit(1)
                    ->update([
                        'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date, 'subscribedPlan' =>  $planname , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing, 'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,'paypal_subscriptionID' =>$response->getSubscriptionId(),'payment_type' =>'Authorize/credit-debit-card',
                    ]);
            }

            $new_post_count = (int) $userData->featured_post_count - 1;
            Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);

            $notice = [
                'from_id' => $userData->id,
                'to_id' => 7,
                'type' => 'post',
                'url' =>route('UserProfileFrontend',$userData->slug),
                'message' => 'New plan ' . $planname . ' subscribe by ' . $userData->first_name . '.',
                ];
            Notification::create($notice); 


            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $userData->id,
                'type' => 'payment',
                'message' => 'Thank you for your payment. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
            ];
            Notification::create($notice);

            $codes = [
                '{name}' => $userData->first_name,
            ];

            General::sendTemplateEmail(
                $userData->email,
                'feature-post',
                $codes
            );
            return redirect()
                    ->route('index_user')
                    ->with('success', 'Thank you for your payment.');
        }
        else
        {
        
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";

            return redirect()
                    ->back()
                    ->with('error', $response->getMessages()->getMessage()[0]->getCode().'--'.$errorMessages[0]->getText() ?? 'Something went wrong.');
        }
        
        // return $response;
    }




  function create_featured_Subscription_blog(Request $request , $id)
  {
     
      $start_date = Carbon::now();
      $name = $request->cardholdername;
      $cardnumber = $request->cardnumber;
      $cardcvc = $request->cardcvc;
      $cardexpirymonth = $request->cardexpirymonth;
      $cardexpiryyear = $request->cardexpiryyear;
      $planname = $request->planname;
      $userData = UserAuth::getLoginUser();
      // dd($planname);
  
      if($planname=='Weekly'){
          $intervalLength = 7;
          $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
          $planData = SubPlan::where('plan', 'Weekly')->first();
          $paid_postCount ='2';
      }elseif($planname=='Monthly'){
          $intervalLength = 30;
          $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
          $planData = SubPlan::where('plan', 'Monthly')->first();
          $paid_postCount ='4';
      }elseif($planname=="Three Month's"){
          $intervalLength = 90;
          $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
          $planData = SubPlan::where('plan', "Three Month's")->first();
          $paid_postCount ='6';
      }elseif($planname=="Six Month's"){
          $intervalLength = 180;
          $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
          $planData = SubPlan::where('plan', "Six Month's")->first();
          $paid_postCount ='8';
      }elseif($planname=="Yearly"){
          $intervalLength = 365;
          $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
          $planData = SubPlan::where('plan', "Yearly")->first();
          $paid_postCount ='10';
      }
      $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    //   $merchantAuthentication->setName('2BxyK457');
    //   $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
    $merchantAuthentication->setName('3zN8Wt8hY');
    $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
       
      $refId = 'ref' . time();
  
      // Subscription Type Info
      $subscription = new AnetAPI\ARBSubscriptionType();
      $subscription->setName($planData->plan);
  
      $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
      $interval->setLength($intervalLength);
      $interval->setUnit("days");
  
  
      $paymentSchedule = new AnetAPI\PaymentScheduleType();
      $paymentSchedule->setInterval($interval);
      $paymentSchedule->setStartDate(new DateTime($start_date));
      $paymentSchedule->setTotalOccurrences("12");
      $paymentSchedule->setTrialOccurrences("1");
  
      $subscription->setPaymentSchedule($paymentSchedule);
      $subscription->setAmount($planData->price);
      $subscription->setTrialAmount("0.00");
      
      $creditCard = new AnetAPI\CreditCardType();
      $creditCard->setCardNumber($cardnumber);
      $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
  
      $payment = new AnetAPI\PaymentType();
      $payment->setCreditCard($creditCard);
      $subscription->setPayment($payment);
  
      $order = new AnetAPI\OrderType();
      $order->setInvoiceNumber($id);        
      $order->setDescription($planname); 
      $subscription->setOrder($order); 
      
      $billTo = new AnetAPI\NameAndAddressType();
      $billTo->setFirstName($userData->first_name);
      $billTo->setLastName($userData->first_name);
  
      $subscription->setBillTo($billTo);
      $request = new AnetAPI\ARBCreateSubscriptionRequest();
      $request->setmerchantAuthentication($merchantAuthentication);
      $request->setRefId($refId);
      $request->setSubscription($subscription);
      $controller = new AnetController\ARBCreateSubscriptionController($request);
  
      $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SENDBOX);
  
       
      
       if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
       {
          // echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
          DB::table('post_payments')->insert(
              [
                  'payment_id' => $response->getSubscriptionId(),
                  'duration' => $intervalLength,
                  'start_date' => $start_date,
                  'end_date' => $end_date
              ]
          );
  
          // Update User         
  
          
          // dd($featureUser);
          if ($userData->id) {
              DB::table('users')
                  ->where('id',$userData->id)
                  ->limit(1)
                  ->update([
                      'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date,'subscribedPlan' =>  $planname , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing,'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,
                  ]);
          }
  
          $new_post_count = (int) $userData->featured_post_count - 1;
          Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);
  
  
              DB::table('blogs')
              ->where('id', $id)
              ->limit(1)
              ->update([
                  'featured_post' => 'on',
                  'draft' => '1',
              ]);
          
  
  
  
          $notice = [
              'from_id' => $userData->id,
              'to_id' => 7,
              'type' => 'post',
              'message' => 'New plan ' . $planname . ' subscribe by ' . $userData->first_name . '.',
              ];
          Notification::create($notice); 

          $notice = [
            'from_id' => UserAuth::getLoginId(),
            'to_id' => $userData->id,
            'type' => 'payment',
            'message' => 'Thank you for your payment. You have successfully subscribed to the new plan: '.$planname.'. It will end on '.$end_date . '.',
        ];
        Notification::create($notice);
  
          $codes = [
              '{name}' => $userData->first_name,
          ];
  
          General::sendTemplateEmail(
              $userData->email,
              'feature-post',
              $codes
          );
          return redirect()
                  ->route('index_user')
                  ->with('success', 'Thank you for your payment.');
       }
      else
      {
         
          $errorMessages = $response->getMessages()->getMessage();
          // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
  
          return redirect()
                  ->back()
                  ->with('error', $response->getMessages()->getMessage()[0]->getCode().'--'.$errorMessages[0]->getText() ?? 'Something went wrong.');
      }
      
      // return $response;
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

    public function paid_listing_save(Request $request ,$postID,$type)
    {
    $price = $request->planprice;
    $name = $request->cardholdername;
    $cardnumber = $request->cardnumber;
    $cardcvc = $request->cardcvc;
    $cardexpirymonth = $request->cardexpirymonth;
    $cardexpiryyear = $request->cardexpiryyear;

    $user = UserAuth::getLoginUser();
    $featurepost = Blogs::where('id', $postID)->first();

    

    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    // $merchantAuthentication->setName('2BxyK457');
    // $merchantAuthentication->setTransactionKey('6s7u35G3unN8NvLm');
    $merchantAuthentication->setName('3zN8Wt8hY');
    $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate($cardexpiryyear."-".$cardexpirymonth);
    $creditCard->setCardCode($cardcvc);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($postID);
    $order->setDescription($featurepost->title);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId("$user->id");
    $customerData->setEmail($user->email);

    // Add values for transaction settings
    // $duplicateWindowSetting = new AnetAPI\SettingType();
    // $duplicateWindowSetting->setSettingName("duplicateWindow");
    // $duplicateWindowSetting->setSettingValue("60");

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($price);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    // $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);
    // $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
  
    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                DB::table('post_payments')->insert(
                [
                    'payment_id' => $tresponse->getTransId(),
                    'post_id' => $postID,
                    
                ]
            );

            
            $featureUser = Users::where('id', $user->id)->first();        
        
            if ($featurepost->id) {
                
                DB::table('blogs')
                    ->where('id', $postID)
                    ->limit(1)
                    ->update([
                        'post_type' => 'noNormal Post',
                        'draft' => '1',
                    ]);
            }
            if(empty($user->paid_post_count) || $user->paid_post_count== 0 ){
                $new_post_count = (int) $user->paid_post_count - 1;
                Users::where('id', $user->id)->update(['paid_post_count' => $new_post_count]);
            }
           

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'post',
                'message' => "A new listing \"{$featurepost->title}\" is created by {$user->username}.",
            ];
            Notification::create($notice);

            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $featureUser->id,
                'type' => 'payment',
                'message' => "Payment successful. You have successfully created a listing : \"{$featurepost->title}.\"",
            ];
            Notification::create($notice);
            if($price == 3){
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{URL}' => route('service_single',$featurepost->slug),
                ];
            }elseif($price == 4.98){
                $codes = [
                    '{first_name}' => $featureUser->first_name,
                    '{URL}' => route('jobpost',$featurepost->slug),
                ];
            }

            General::sendTemplateEmail(
                $featureUser->email,
                'Paid-Listing',
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
                    return redirect()
                    ->back()
                    ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
                }
            }
           
        } else {
           
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {

                 return redirect()
                ->back()
                ->with('error', $tresponse->getErrors()[0]->getErrorCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            } else {
                return redirect()
                ->back()
                ->with('error', $response->getMessages()->getMessage()[0]->getCode().' '.$tresponse->getErrors()[0]->getErrorText() ?? 'Something went wrong.');
            }
        }
    } else {
       return redirect()
        ->route('index_user')
        ->with('error','Something went wrong.');
    }
              
    }




    function cancelSubscription(Request $request)
    {
        // dd($request->all());
        $subscriptionId = $request->subid;
        $user =  UserAuth::getLoginUser();
        /* Create a merchantAuthenticationType object with authentication details
        retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        // $merchantAuthentication->setName('8Ar82A28Tvz');
        // $merchantAuthentication->setTransactionKey('39nWWAs28668jJUc');
        $merchantAuthentication->setName('3zN8Wt8hY');
        $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
        
        // Set the transaction's refId
        $refId = 'ref' . time();

        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);

        $controller = new AnetController\ARBCancelSubscriptionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {

            DB::table('users')
            ->where('id', $user->id)
            ->limit(1)
            ->update([
                'cancel_at' => 1 ,
                'paypal_subscriptionID' =>null,
                'payment_type' =>null,
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
            
            $successMessages = $response->getMessages()->getMessage();
            return response()->json(['success' => true, 'message' => $successMessages]);
            
        }
        else
        {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            
        }

    }
    function updateSubscription_form($id,$planname){

        return view('frontend.authorize.subscription_update',compact('id','planname'));
    }


    function updateSubscription_upgrade(Request $request,$subscriptionId,$planname)
    {
        // dd($subscriptionId);
        $start_date = Carbon::now();
        $name = $request->cardholdername;
        $cardnumber = $request->cardnumber;
        $cardcvc = $request->cardcvc;
        $cardexpirymonth = $request->cardexpirymonth;
        $cardexpiryyear = $request->cardexpiryyear;
        $userData = UserAuth::getLoginUser();
        $user = UserAuth::getLoginUser();
        if($planname=='weekly'){
           
            $end_date = Carbon::now()->addDay(7)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Weekly')->first();
            $paid_postCount ='2';
            $intervalLength = 7;
            $totalOccurrences = 52;
        }elseif($planname=='month'){
            $intervalLength = 30;
            $totalOccurrences = 12;
            $end_date = Carbon::now()->addDay(30)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', 'Monthly')->first();
            $paid_postCount ='4';
        }elseif($planname=="three-month"){
            $intervalLength = 90;
            $totalOccurrences = 4;
            $end_date = Carbon::now()->addDay(90)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Three Month's")->first();
            $paid_postCount ='6';
        }elseif($planname=="six-month"){
            $intervalLength = 180;
            $totalOccurrences = 2;
            $end_date = Carbon::now()->addDay(180)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Six Month's")->first();
            $paid_postCount ='8';
        }elseif($planname=="year"){
            $intervalLength = 365;
            $totalOccurrences = 1;
            $end_date = Carbon::now()->addDay(365)->format('Y-m-d H:i:s');
            $planData = SubPlan::where('plan', "Yearly")->first();
            $paid_postCount ='10';
        }
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    // $merchantAuthentication->setName('8Ar82A28Tvz');
        // $merchantAuthentication->setTransactionKey('39nWWAs28668jJUc');
        $merchantAuthentication->setName('3zN8Wt8hY');
        $merchantAuthentication->setTransactionKey('84p7HS5Xc9xNzu9C');
    
    // Set the transaction's refId
    $refId = 'ref' . time();

    $subscription = new AnetAPI\ARBSubscriptionType();
    $subscription->setName($planname);

     
     $schedule = new AnetAPI\PaymentScheduleType();
     
     $schedule->setStartDate(new \DateTime($start_date));
     $schedule->setTotalOccurrences($totalOccurrences);
     $subscription->setAmount($planData->price);
     $subscription->setPaymentSchedule($schedule);

    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($cardnumber);
    $creditCard->setExpirationDate("{$cardexpiryyear}-{$cardexpirymonth}");

    $payment = new AnetAPI\PaymentType();
    $payment->setCreditCard($creditCard);

    //set profile information
    // $profile = new AnetAPI\CustomerProfileIdType();
    // $profile->setCustomerProfileId("121212");
    // $profile->setCustomerPaymentProfileId("131313");
    // $profile->setCustomerAddressId("141414");

    $subscription->setPayment($payment);

    //set customer profile information
    //$subscription->setProfile($profile);
    
    $request = new AnetAPI\ARBUpdateSubscriptionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setSubscriptionId($subscriptionId);
    $request->setSubscription($subscription);

    $controller = new AnetController\ARBUpdateSubscriptionController($request);

    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    
    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
    {
        DB::table('post_payments')->insert(
            [
                'user_id' => $user->id,
                'payment_id' => $subscriptionId,
                'post_id' => null,
                'payment_method' =>"Authorize/credit-debit-card",
                'duration' => $intervalLength,
                'type' => 'subscription',
                'balance_transaction' =>$planData->price,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]
        );

        // Update User         

        
        // dd($featureUser);
        if ($userData->id) {
            DB::table('users')
                ->where('id',$userData->id)
                ->limit(1)
                ->update([
                    'isfeatured_user' => '1', 'feature_start_date' => $start_date, 'feature_end_date' => $end_date, 'subscribedPlan' =>  $planname , 'customer_id' => $response->getrefId() ,  'cancel_at' => 0 ,'featured_post_count' => $planData->feature_listing, 'slideshow_limit' => $planData->slideshow , 'paid_post_count'=> $paid_postCount,'paypal_subscriptionID' =>$subscriptionId,'payment_type' =>'Authorize/credit-debit-card',
                ]);
        }

        $new_post_count = (int) $userData->featured_post_count - 1;
        Users::where('id', $userData->id)->update(['featured_post_count' => $new_post_count]);

        $notice = [
            'from_id' => $userData->id,
            'to_id' => 7,
            'type' => 'post',
            'url' =>route('UserProfileFrontend',$userData->slug),
            'message' => 'New plan ' . $planname . ' upgrade by ' . $userData->first_name . '.',
            ];
        Notification::create($notice); 


        $notice = [
            'from_id' => UserAuth::getLoginId(),
            'to_id' => $userData->id,
            'type' => 'payment',
            'message' => 'Thank you for your payment. You have successfully upgrade to the new plan: '.$planname.'. It will end on '.$end_date . '.',
        ];
        Notification::create($notice);

        $codes = [
            '{name}' => $userData->first_name,
        ];

        General::sendTemplateEmail(
            $userData->email,
            'feature-post',
            $codes
        );
        return redirect()
                ->route('index_user')
                ->with('success', 'Thank you for your payment.');
        
    }
    else
    {
        $errorMessages = $response->getMessages()->getMessage();
        return redirect()->back()->with(['error' => $errorMessages]);
        // echo "ERROR :  Invalid response\n";
        
        // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
    }

    }
}
