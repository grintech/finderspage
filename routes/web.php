<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\ContactusController;
use App\Http\Controllers\Frontend\StripePaymentController;
use App\Http\Controllers\Frontend\AuthorizeController;
use App\Http\Controllers\Frontend\VotingController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\AppController;
use App\Http\Controllers\Frontend\PayPalPaymentController;
use App\Http\Controllers\Frontend\LogController;
use App\Libraries\General;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('config:cache');
	return redirect()->back()->with(['success' =>'Cache cleard successfully.']);
	// return what you want
});
Route::middleware(['guest', 'xss'])->group(function () {

	//Admin public
	include "Frontend/jobpost.php";
	include "Admin/auth.php";
	include "Frontend/auth.php";
	include "Frontend/home.php";
	include "Frontend/actions.php";
	
});

Route::prefix('admin')->middleware(['adminAuth', 'xss'])->group(function () {

	include "Admin/dashboard.php";
	include "Admin/notification.php";
	include "Admin/blogs.php";
	include "Admin/admins.php";
	include "Admin/products.php";
	include "Admin/pages.php";
	include "Admin/profile.php";
	include "Admin/emailTemplates.php";
	include "Admin/actions.php";
	include "Admin/activities.php";
	include "Admin/settings.php";
	include "Admin/homeSettings.php";
	include "Admin/faq.php";
	include "Admin/testimonials.php";
	include "Admin/newsletter.php";
	include "Admin/slider.php";
	include "Admin/feedback.php";
	include "Admin/contactus.php";
	include "Admin/testimonials.php";
	include "Admin/users.php";
	include "Admin/aboutusSettings.php";
});



Route::get('/business-registration/{token}/{id}', '\App\Http\Controllers\Frontend\BusinessRegistrationController@businessRegistration')
	->name('businessRegistration');
// Route::post('/business-registration/{token}/{id}', '\App\Http\Controllers\Frontend\BusinessRegistrationController@businessRegistration')
// 	->name('businessRegistration');

Route::get('/checking', '\App\Http\Controllers\Frontend\BusinessRegistrationController@getBusinessCategory');
// User Profile
Route::get('/business-user-profile/{id}', [UserProfileController::class, 'businessUserProfile'])->name('businessUserProfile');

Route::get('/user/profile/{id}', [UserProfileController::class, 'UserProfile'])->name('UserProfile');

Route::get('/edit-user-profile/{id}', [UserProfileController::class, 'editUserProfile'])->name('edit_user_profile');


Route::post('/update-user-profile/{id}', [UserProfileController::class, 'updateUserProfile'])->name('update_user_profile');

// Business Profile
Route::get('/edit-business-profile/{id}', [UserProfileController::class, 'editBusinessProfile'])->name('edit_business_profile');
Route::post('/update-business-profile/{id}', [UserProfileController::class, 'updatebusinessProfile'])->name('update_business_profile');

// Contact Us (enquiry)
Route::get('/contact-us/{post_id}', [ContactusController::class, 'index'])->name('contact-us');
Route::post('/submit-enquiry/', [ContactusController::class, 'sendEnquiry'])->name('submit-enquiry');

// Stripe/Payment
Route::controller(StripePaymentController::class)->group(function () {
	Route::get('/stripe/{post_id}', 'stripe')->name('stripe.createstripe');
	Route::post('/stripe', 'stripePost')->name('stripe.post');

	Route::get('/stripe/bump/{post_id}', 'stripe_bump')->name('stripe.createstripe.bump');
	Route::post('/stripe/bump', 'stripePost_bump')->name('stripe.bump.post');

	Route::get('/stripe/blog/{post_id}', 'stripe_blog_bump')->name('stripe.createstripe.blog');
	Route::post('/stripe/bump/blog', 'stripeBlog_bump')->name('stripe.bump.blog');

	Route::get('/stripe/blog/feature/{post_id}', 'stripe_blog_feature')->name('stripe.feature.blog');
	Route::post('/stripe/blog_feature', 'stripeBlog_feature')->name('stripe.feature_blog');

	Route::get('/stripe/Entertainment/{post_id}', 'stripe_entertainment_bump')->name('stripe.createstripe.Entertainment');
	Route::post('/stripe/Entertainment/bump', 'stripeEntertainment_bump')->name('stripe.bump.entertainment.save');

	Route::get('/stripe/Entertainment/feature/{post_id}', 'stripe_blog_feature')->name('stripe.feature.Entertainment');
	Route::post('/stripe/Entertainment_feature', 'stripeBlog_feature')->name('stripe.feature_Entertainment');

	Route::get('/stripe/Entertainment/update/{post_id}', 'stripe_Entertainment_feature')->name('stripe.feature.Entertainment_update');
	Route::post('/stripe/Entertainment_update', 'stripeEntertainment_feature')->name('stripe.feature_Entertainment_update');

	Route::get('/stripe/video/{post_id}', 'stripe_video_feature')->name('stripe.feature.video');
	Route::post('/stripe/feature_video', 'stripe_video_feature_payment')->name('stripe.feature_video');

	Route::get('/stripe/video/bump/{post_id}', 'stripe_video_bump')->name('stripe.bump.video');
	Route::post('/stripe/bump_video', 'stripeVideo_bump')->name('stripe.bump_video');

	Route::get('/stripe/subscription/{id}/{planname}', 'stripe_subscription')->name('stripe.subscription');
	Route::get('/subscription/cancel/{id}/{planname}', 'cancelSubscription')->name('subscription.cancel');
	Route::post('/stripe/subscription/save', 'stripe_subscription_save')->name('stripe.subscription.save');
	


	Route::get('/stripe/normal-services/{post_id}', 'stripe_services_normal')->name('stripe.normal.services');
	Route::post('/stripe/normal-services/save', 'stripe_job_Normal_Save')->name('stripe.normal-services.save');


	Route::get('/stripe/normal-job/{post_id}', 'stripe_job_normal')->name('stripe.normal.job');
	Route::post('/stripe/normal-job/save', 'stripe_savre_NormalService')->name('stripe.normal-job.save');

	Route::get('/stripe/normal-realestate/{post_id}', 'stripe_realestate_normal')->name('stripe.normal.realestate');
	Route::post('/stripe/normal-realestate/save/{id}', 'stripe_realestate_Normal_Save')->name('stripe.normal-realestate.save');


	Route::get('/stripe/normal-shopping/{post_id}', 'stripe_shopping_normal')->name('stripe.normal.shopping');
	Route::post('/stripe/normal-shopping/save', 'stripe_shopping_Normal_Save')->name('stripe.normal-shopping.save');
	
});


Route::post('/save/voting/response', [VotingController::class, 'store'])->name('save_vote');

Route::get('/checking/mail', function () {
	// $d = Blogs::get(93);
	// dd($d->user_id);

	// $codes = [
	// 	'{name}' => 'Gourav',
	// ];

	// General::sendTemplateEmail(
	// 	'gourav@yopmail.com',
	// 	'feature-post',
	// 	$codes
	// );
});


// Delete  MY  account

Route::get('/delete-account/{id}', [UserProfileController::class, 'delete'])->name('Delete_account');

//checkout

Route::get('/checkout/{post_id}', [App\Http\Controllers\Frontend\HomeController::class, 'showCheckoutPage'])->name('checkout');

Route::get('/comming-soon/business', [App\Http\Controllers\Frontend\HomeController::class, 'commingSoon_bussiness'])->name('commingSoon_bussiness');


// Authorize Payment route 
Route::get('/pay/{id}', [AuthorizeController::class, 'index'])->name('pay.auth');
Route::get('/pay-bump/{id}', [AuthorizeController::class, 'create'])->name('pay.auth.bump');
Route::get('/pay-bump-business/{id}', [AuthorizeController::class, 'create_business_bump'])->name('pay.auth.bump.business');
Route::get('/pay-bump-entertainment/{id}', [AuthorizeController::class, 'entertainment_bump'])->name('pay.auth.entertainment');
Route::get('/pay-reccuring_billing/{id}/{planname}', [AuthorizeController::class, 'reccuring_billing'])->name('pay.auth.reccuring_billing');
Route::get('/pay-reccuring_featured/{post_id}', [AuthorizeController::class, 'reccuring_featured'])->name('pay.auth.reccuring_featured');

Route::get('/pay-paid-listing/{post_id}/{type}', [AuthorizeController::class, 'paid_Post'])->name('pay.auth.paid_Post');

Route::post('/subscription/cancel/auth', [AuthorizeController::class, 'cancelSubscription'])->name('subscription.cancel.auth');
Route::get('/update/Subscription/form/{id}/{planname}', [AuthorizeController::class, 'updateSubscription_form'])->name('updateSubscription_form');
Route::post('/update/Subscription/upgrade/{subscriptionId}/{planname}', [AuthorizeController::class, 'updateSubscription_upgrade'])->name('updateSubscription_form_upgrade');

Route::post('/pay-save/{id}', [AuthorizeController::class, 'store'])->name('pay.auth.save');
Route::post('/pay-save-entertainment/{id}', [AuthorizeController::class, 'bump_entertainment_post'])->name('pay.auth.save.entertainment');
Route::post('/pay-save-blogs/{id}', [AuthorizeController::class, 'bump_blog_post'])->name('pay.auth.save.blogs');
Route::post('/pay-reccuring-save/{id}', [AuthorizeController::class, 'createSubscription'])->name('pay.auth.reccurring.save');

Route::post('/pay-paid-listing-save/{postID}/{type}', [AuthorizeController::class, 'paid_listing_save'])->name('pay.paid-listing.save');

Route::post('/pay-business-listing-bump/{postID}', [AuthorizeController::class, 'business_bump_listing'])->name('pay.business.bump');

Route::post('/pay-reccuring-featured-save/{id}/{planname}', [AuthorizeController::class, 'create_featured_Subscription'])->name('pay.auth.reccurring.featured.save');

Route::get('paypal-bump/{post_id}', [PayPalPaymentController::class, 'bumpPayment'])->name('paypal.bump');
Route::get('paypal/payment/{id}/{amt}', [PayPalPaymentController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success/{id}', [PayPalPaymentController::class, 'paymentSuccess_bump'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PayPalPaymentController::class, 'paymentCancel'])->name('paypal.payment.cancel');

//new blog_bump //
Route::get('paypal/blog/payment/{id}/{amt}', [PayPalPaymentController::class, 'Blog_payment'])->name('paypal.blog.payment');
Route::get('paypal/blog/payment/success/{id}', [PayPalPaymentController::class, 'Blog_paymentSuccess_bump'])->name('paypal.blog.payment.success');
Route::get('paypal/blog/payment/cancel', [PayPalPaymentController::class, 'Blog_paymentCancel'])->name('paypal.blog.payment.cancel');


//new Entertainment_bump //
Route::get('paypal/entertainment/payment/{id}/{amt}', [PayPalPaymentController::class, 'Entertainment_payment'])->name('paypal.entertainment.payment');
Route::get('paypal/entertainment/payment/success/{id}', [PayPalPaymentController::class, 'Entertainment_paymentSuccess_bump'])->name('paypal.entertainment.payment.success');
Route::get('paypal/entertainment/payment/cancel', [PayPalPaymentController::class, 'Entertainment_paymentCancel'])->name('paypal.entertainment.payment.cancel');

//bump for blogs
Route::get('paypal-bump-blog/{post_id}', [PayPalPaymentController::class, 'bumpPayment_blogs'])->name('paypal.bump.blogs');
Route::get('paypal/payment/blogs/{id}', [PayPalPaymentController::class, 'new_payment_blogs'])->name('paypal.payment.blogs');
Route::get('paypal/payment/blog/success/{id}', [PayPalPaymentController::class, 'payment_Success_bump_blogs'])->name('paypal.payment.blog.success');

Route::get('paypal/payment/cancel/blogs', [PayPalPaymentController::class, 'payment_Cancel_blogs'])->name('paypal.payment.cancel.blogs');


// subscription payment
Route::get('paypal/subscription/{id}/{planname}', [PayPalPaymentController::class, 'paypal_subscription'])->name('paypal.subscription_form');

Route::post('paypal/subscription/payment/{planname}', [PayPalPaymentController::class, 'createSubscription'])->name('paypal.subscription.payment');


Route::group(['middleware' => 'cors'], function () {

    Route::post('/paypal/subscription_code/{planname}', [PayPalPaymentController::class, 'SubscriptionCode'])->name('paypal.subscription_code');
});

 Route::post('/cancel-subscription/',[PayPalPaymentController::class, 'CancelSubscription'])->name('paypal.cancel_subscription');

// featured post
 Route::get('paypal/featured/{post_id}/', [PayPalPaymentController::class, 'featuredForm'])->name('paypal.featured_post');

 Route::post('/paypal/featured_save', [PayPalPaymentController::class, 'createfeaturedPost'])->name('paypal.featured_save');

 // featured post for blogs
 Route::get('paypal/featured/blogs/{post_id}/', [PayPalPaymentController::class, 'featured_blog_Form'])->name('paypal.featured_post.blogs');

 Route::post('/paypal/featured_save/blogs', [PayPalPaymentController::class, 'createfeatured_blog_Post'])->name('paypal.featured_save.blogs');


 // featured post for business
 Route::get('paypal/featured/business/{post_id}/', [PayPalPaymentController::class, 'featured_business'])->name('paypal.featured_post.business');

 Route::post('/paypal/featured_save/business', [PayPalPaymentController::class, 'createfeatured_business_Post'])->name('paypal.featured_save.business');

 Route::post('/auth/featured_save/business/{post_id}', [AuthorizeController::class, 'create_business_featured_Subscription'])->name('auth.featured_save.business');

 Route::post('/auth/featured_save/entertainment/{post_id}', [AuthorizeController::class, 'create_entertainment_featured_Subscription'])->name('auth.featured_save.entertainment');

 // featured post for Entertainment
 Route::get('paypal/featured/entertainment/{post_id}/', [PayPalPaymentController::class, 'featured_entertainment_Form'])->name('paypal.featured_post.entertainment');
 Route::post('/paypal/featured_save/entertainment', [PayPalPaymentController::class, 'createfeatured_entertainment_Post'])->name('paypal.featured_save.entertainment');



 //paid post  for jobs   
Route::get('paypal-paid/{post_id}', [PayPalPaymentController::class, 'paid_post_Payment'])->name('paypal.paid');
Route::get('paypal/payment/paid/{id}', [PayPalPaymentController::class, 'paid_post_payment_save'])->name('paypal.payment.paid');
Route::get('paypal/payment/paid/success/{id}', [PayPalPaymentController::class, 'payment_paid_post_Success'])->name('paypal.payment.paid.success');

Route::get('paypal/payment/cancel/paid', [PayPalPaymentController::class, 'payment_paid_post_Cancel'])->name('paypal.payment.cancel.paid');



//paid post  for   services 
Route::get('paypal-paid_service_post/{post_id}', [PayPalPaymentController::class, 'service_paid_post_Payment'])->name('paypal.paid_service_post');
Route::get('paypal/payment/paid_service_post/{id}', [PayPalPaymentController::class, 'service_paid_post_payment_save'])->name('paypal.payment.paid_service_post');
Route::get('paypal/payment/paid_service_post/success/{id}', [PayPalPaymentController::class, 'service_payment_paid_post_Success'])->name('paypal.payment.paid_service_post.success');

Route::get('paypal/payment/cancel/paid_service_post', [PayPalPaymentController::class, 'service_payment_paid_post_Cancel'])->name('paypal.payment.cancel.paid_service_post');



Route::post('paypal/sub_payment', [PayPalPaymentController::class, 'subscribe_plan'])->name('subscribe_plan_test');

// recurly payment api //


Route::post('recurly/payment', [PayPalPaymentController::class, 'recurly_plan'])->name('recurly.recurly_plan');
Route::post('recurly/payment', [PayPalPaymentController::class, 'recurly_plan'])->name('recurly.recurly_plan');


Route::post('/share/whatsapp', 'ShareController@showid');


Route::post('/paypal/applepay', [PayPalPaymentController::class, 'paypal_applepay'])->name('paypal.applepay');



Route::post('/log', [LogController::class, 'store']);


Route::get('paypal/entertainment/payment/{id}/{amt}', [PayPalPaymentController::class, 'Entertainment_payment'])->name('paypal.entertainment.payment');


Route::get('/pay-payPal', [App\Http\Controllers\PayPalPaymentController::class, 'payWithPayPal']);
Route::get('/status-paypal', [App\Http\Controllers\PayPalPaymentController::class, 'getPaymentStatus']);
Route::get('/payment-options', [App\Http\Controllers\PayPalPaymentController::class, 'showPaymentOptions']);



Route::post('/payment-checkout-all', [PayPalPaymentController::class, 'payment_bump_Success_bump']);
Route::post('/payment-checkout-all-blog', [PayPalPaymentController::class, 'payment_bump_Success_blog_bump']);
Route::post('/payment-checkout-all-business', [PayPalPaymentController::class, 'payment_bump_Success_business_bump']);
Route::post('/payment-checkout-all-entertainment', [PayPalPaymentController::class, 'payment_bump_Success_entertainment_bump']);
Route::post('/payment-checkout-all-paidpost', [PayPalPaymentController::class, 'payment_for_paid_listing']);


Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a test email body', function ($message) {
            $message->to('wasim.grintech@gmail.com')->subject('Test Email');
        });

        return 'Test email sent successfully';

    } catch (Exception $e) {
        // Optionally, return the error message to the browser
        return 'Mail sending failed: ' . $e->getMessage();
    }
});





















