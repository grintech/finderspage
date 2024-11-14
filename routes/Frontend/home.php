<?php
use Illuminate\Support\Facades\Route;

Route::post('/review/form', [\App\Http\Controllers\Frontend\reviewController::class, 'reviewRegister'])->name('review.save');

Route::get('/bump/free/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_is_free'])->name('bump.free.success');

Route::get('/bump/free/blogs/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_is_free_blogs'])->name('bump.free.success.blogs');

Route::get('/bump/free/entertainment/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_is_free_entertainment'])->name('bump.free.success.entertainment');

Route::get('/setting', [\App\Http\Controllers\Frontend\SettingController::class, 'index'])->name('setting');
Route::post('/tag/update/{id}', [\App\Http\Controllers\Frontend\SettingController::class, 'update_tag_at'])->name('update_tag_at');

Route::post('/views/update/{id}', [\App\Http\Controllers\Frontend\SettingController::class, 'Views_setting'])->name('update_no_of_views');

Route::post('/coment/option', [\App\Http\Controllers\Frontend\SettingController::class, 'comment_setting'])->name('comment_setting');

Route::post('/setting/option', [\App\Http\Controllers\Frontend\SettingController::class, 'updateSetting'])->name('update_setting');

Route::post('/zodiac_update', [\App\Http\Controllers\Frontend\SettingController::class, 'Zodiac_setting'])->name('zodiac_update');

Route::post('/share_btn_setting', [\App\Http\Controllers\Frontend\SettingController::class, 'share_btn_setting'])->name('share_btn_setting');

Route::post('/account/setting', [\App\Http\Controllers\Frontend\SettingController::class, 'account_type'])->name('account_type');

Route::get('/video/homepage', [\App\Http\Controllers\Frontend\HomeController::class, 'video_homepage'])->name('video_homepage');

Route::post('/resume/setting', [\App\Http\Controllers\Frontend\ProfileController::class, 'resume_setting'])->name('resume_setting');

Route::get('/hiring', [\App\Http\Controllers\Frontend\HomeController::class, 'hiring'])->name('hiring');

Route::get('/user/{slug}', [\App\Http\Controllers\Frontend\PostController::class, 'UserProfileforntend'])->name('UserProfileFrontend')->middleware('web');

Route::get('/user/for/admin/{slug}', [\App\Http\Controllers\Frontend\PostController::class, 'UserProfileforntend_admin'])->name('UserProfileFrontend.admin');

Route::get('/faq', [\App\Http\Controllers\Frontend\HomeController::class, 'FAQ'])->name('faq');

Route::get('/cart', [\App\Http\Controllers\Frontend\HomeController::class, 'cart'])->name('cart');



Route::get('/thankyou', [App\Http\Controllers\Frontend\HomeController::class, 'showThankYouPage'])->name('thankyou');

Route::get('/coming-soon', [\App\Http\Controllers\Frontend\HomeController::class, 'comingSoonPage'])->name('comingSoon');

// ajax Routes
Route::get('/bump-post-data', [\App\Http\Controllers\Frontend\HomeController::class, 'bump_post_data_request'])->name('bumpPostData');
Route::get('/shop-post-data', [\App\Http\Controllers\Frontend\HomeController::class, 'shop_post_data_request'])->name('shopPostData');
Route::get('/latest-post-data', [\App\Http\Controllers\Frontend\HomeController::class, 'latest_post_data_request'])->name('latestPostData');

Route::get('/admin-video', [\App\Http\Controllers\Frontend\VideosController::class, 'Admin_video_listing'])->name('admin-video');

Route::post('/process-video', [\App\Http\Controllers\Frontend\VideosController::class, 'download_video'])->name('process-video');

Route::post('/process-video', [\App\Http\Controllers\Frontend\VideosController::class, 'download_video'])->name('process-video');


Route::get('/support', '\App\Http\Controllers\Frontend\SupportController@index')->name('support');
Route::get('/support/add', '\App\Http\Controllers\Frontend\SupportController@create')->name('support.add');
Route::post('/support/save', '\App\Http\Controllers\Frontend\SupportController@store')->name('support.save');
Route::get('/support/edit/{id}', '\App\Http\Controllers\Frontend\SupportController@edit')->name('support.edit');
Route::get('/support/delete/{id}', '\App\Http\Controllers\Frontend\SupportController@destroy')->name('support.delete');
Route::post('/support/update/{id}', '\App\Http\Controllers\Frontend\SupportController@update')->name('support.update');

Route::get('/pricing', '\App\Http\Controllers\Frontend\PricingController@index')->name('pricing');
Route::get('/single-pricing', '\App\Http\Controllers\Frontend\PricingController@create')->name('single.pricing');

Route::get('/user-index', '\App\Http\Controllers\Frontend\UserdashboardController@index')->name('index_user');

Route::get('/user-business', '\App\Http\Controllers\Frontend\UserdashboardController@business_page')->name('business_page');
Route::post('/user-business-save', '\App\Http\Controllers\Frontend\UserdashboardController@store_business_page')->name('business_page.save');
Route::get('/business-listing', '\App\Http\Controllers\Frontend\UserdashboardController@business_page_list')->name('business_page.list');
Route::get('/business-edit/{slug}', '\App\Http\Controllers\Frontend\UserdashboardController@edit_business_page')->name('business_page.edit');
Route::post('/business-update/{id}', '\App\Http\Controllers\Frontend\UserdashboardController@update_business_page')->name('business_page.update');
Route::get('/business-delete/{id}', '\App\Http\Controllers\Frontend\UserdashboardController@destroy')->name('business_page.delete');


Route::post('/business-invite', '\App\Http\Controllers\Frontend\UserdashboardController@Invite')->name('business_page.invite');
Route::post('/business-invite-accept', '\App\Http\Controllers\Frontend\UserdashboardController@accept_invitation')->name('business_page.invite.accept');



//business frontend  listing //
Route::get('/business-list', '\App\Http\Controllers\Frontend\UserdashboardController@business_listing')->name('business_page.front.listing');
Route::get('/business-single-list/{slug}', '\App\Http\Controllers\Frontend\UserdashboardController@business_single_listing')->name('business_page.front.single.listing')->middleware('get_listing_view');
//end business listing //

Route::post('/add-business-review', '\App\Http\Controllers\Frontend\ProductReviewController@store_business_review')->name('business_review.save');

Route::post('/update-business-review/{id}', '\App\Http\Controllers\Frontend\ProductReviewController@update_business_review')->name('business_review.update');

Route::post('/reviews/delete-file', '\App\Http\Controllers\Frontend\ProductReviewController@deleteFile')->name('reviews.deleteFile');

Route::get('/Privacypolicy', '\App\Http\Controllers\Frontend\PrivasypolicyController@index');

Route::get('/term-of-use', '\App\Http\Controllers\Frontend\TermofuseController@index')->name('term_of_use');

Route::get('/', '\App\Http\Controllers\Frontend\HomeController@index')
    ->name('homepage.index')->middleware('checkAvailable');

Route::post('/contact-us', '\App\Http\Controllers\Frontend\HomeController@contactUs')
    ->name('homepage.contactUs');

Route::get('/contact', '\App\Http\Controllers\Frontend\HomeController@contact')
    ->name('homepage.contact.form');

Route::get('/privacy-policy', '\App\Http\Controllers\Frontend\HomeController@privacyPolicy')
    ->name('homepage.privacyPolicy');

Route::get('/terms-conditions', '\App\Http\Controllers\Frontend\HomeController@termsCondition')
    ->name('homepage.termsCondition');

Route::get('/about-us', '\App\Http\Controllers\Frontend\HomeController@aboutUs')
    ->name('homepage.about');

Route::match(['get', 'post'], '/create-a-post', '\App\Http\Controllers\Frontend\PostController@create')
    ->name('post.create');

Route::match(['get', 'post'], '/create-a-post_old', '\App\Http\Controllers\Frontend\PostController@create_old')
    ->name('post.create_old');

Route::match(['get', 'post'], '/create-a-post_realestate', '\App\Http\Controllers\Frontend\PostController@realestate')
    ->name('create_realestate');

Route::match(['get', 'post'], '/community', '\App\Http\Controllers\Frontend\PostController@our_community')
    ->name('community');
Route::match(['get', 'post'], 'edit/community/{slug}', '\App\Http\Controllers\Frontend\PostController@our_community_edit')
    ->name('our_community_edit');

Route::match(['get', 'post'], '/add/services', '\App\Http\Controllers\Frontend\PostController@services')
    ->name('add_services');
Route::match(['get', 'post'], '/add/event', '\App\Http\Controllers\Frontend\PostController@event_add')
    ->name('add_event');

Route::match(['get', 'post'], '/edit/event/{id}', '\App\Http\Controllers\Frontend\PostController@edit_event_post')
    ->name('update_event');

Route::match(['get', 'post'], '/edit/services/{slug}', '\App\Http\Controllers\Frontend\PostController@Service_edit')
    ->name('edit_services');

Route::match(['get', 'post'], '/edit/job/{slug}', '\App\Http\Controllers\Frontend\PostController@job_edit')
    ->name('job_edit');

Route::match(['get', 'post'], '/edit/realestate/{slug}', '\App\Http\Controllers\Frontend\PostController@edit_realestate')
    ->name('realestate_edit');

Route::get('/delete/services/{id}', '\App\Http\Controllers\Frontend\PostController@delete')
    ->name('delete_services');

Route::get('/my_post', '\App\Http\Controllers\Frontend\PostController@my_post')->name('my_post');

Route::get('/job/post/list', '\App\Http\Controllers\Frontend\PostController@job_post_list')->name('job_post_list')->middleware('update_outdated_post');

Route::get('/event/post/list', '\App\Http\Controllers\Frontend\PostController@event_post_list')->name('event_post_list');

Route::get('/realEstate_post_list', '\App\Http\Controllers\Frontend\PostController@realEstate_post_list')->name('realEstate_post_list')->middleware('update_outdated_post');

Route::get('/community/post/list', '\App\Http\Controllers\Frontend\PostController@community_post_list')->name('community_post_list')->middleware('update_outdated_post');

Route::get('/shopping/post/list', '\App\Http\Controllers\Frontend\PostController@shopping_post_list')->name('shopping_post_list')->middleware('update_outdated_post');

Route::match(['get', 'post'], '/shopping', '\App\Http\Controllers\Frontend\PostController@shopping')
    ->name('shopping');

Route::match(['get', 'post'], '/shopping/edit/{slug}', '\App\Http\Controllers\Frontend\PostController@shopping_edit')
    ->name('shoppingEdit');

Route::get('/posts/{id?}', '\App\Http\Controllers\Frontend\PostController@getPosts')
    ->name('post.posts');

Route::get('/my-posts', '\App\Http\Controllers\Frontend\PostController@myPosts')
    ->name('post.my_posts')->middleware('update_outdated_post');

Route::get('/post/{id}', '\App\Http\Controllers\Frontend\PostController@view')
    ->name('post.view');

Route::get('/post/{id}/edit', '\App\Http\Controllers\Frontend\PostController@edit')
    ->name('post.edit');

Route::post('/post/{id}/edit', '\App\Http\Controllers\Frontend\PostController@edit')
    ->name('post.edit');

Route::get('/search-sub-categories', '\App\Http\Controllers\Frontend\PostController@searchSubCategories')
    ->name('post.searchSubCategories');

// Route::get('/{slug}', '\App\Http\Controllers\Frontend\HomeController@services')
//     ->name('homepage.services');

Route::get('/search-state/{id}', '\App\Http\Controllers\Frontend\PostController@getState');
Route::get('/search-city/{id}', '\App\Http\Controllers\Frontend\PostController@getCity');

Route::match(['get', 'post'], '/createaposttest', '\App\Http\Controllers\Frontend\PostController@createTest');



Route::get('/post/category/{id}', '\App\Http\Controllers\Frontend\PostController@getCategories')->name('post.post_category');
Route::post('/get/follow', '\App\Http\Controllers\Frontend\FollowController@doFollow');
Route::post('/get/unfollow', '\App\Http\Controllers\Frontend\FollowController@unFollow');

Route::post('/newslatter', '\App\Http\Controllers\Frontend\HomeController@HomeNewslatter')->name('newslatter');

Route::post('/filter/job/state', [\App\Http\Controllers\Frontend\PostController::class, 'fetch_state_job']);
Route::post('/filter/job/city', [\App\Http\Controllers\Frontend\PostController::class, 'fetch_city_job']);

Route::post('/edit/filter/state', [\App\Http\Controllers\Frontend\PostController::class, 'fetch_state']);
Route::post('/edit/filter/city', [\App\Http\Controllers\Frontend\PostController::class, 'fetch_city']);

Route::get('/avoid/scam', [\App\Http\Controllers\Frontend\HomeController::class, 'scams'])->name('avoid_scam');

Route::post('/saved/post', [\App\Http\Controllers\Frontend\PostController::class, 'Savedpost'])->name('save_post');

Route::post('/unsaved/post', [\App\Http\Controllers\Frontend\PostController::class, 'unSavedpost'])->name('unsave_post');

Route::post('/user/dnd_status', [\App\Http\Controllers\Frontend\ProfileController::class, 'Do_Not_Disturb'])->name('user_dnd_status');

Route::post('/user-content', [\App\Http\Controllers\Frontend\PostController::class, 'show_current_user_blogs'])->name('show_current_user_blogs');


Route::fallback([\App\Http\Controllers\Frontend\NotFoundController::class, 'index']); 


Route::get('/bump/post_count/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_post_count'])->name('bump.post_count.success');

Route::get('/bump/post_count/blogs/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_post_count_blogs'])->name('bump.post_count.success.blogs');

Route::get('/bump/post_count/business/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_post_count_business'])->name('bump.post_count.success.business');

Route::get('/bump/post_count/entertainment/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_post_count_entertainment'])->name('bump.post_count.success.entertainment');

//featured 
Route::get('/featured/post_count/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'is_post_is_feature'])->name('featured.post_count.success');
Route::get('/featured/post_count/blog/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'is_post_is_feature_blog'])->name('featured.post_count.success.blog');
Route::get('/featured/post_count/business/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'is_post_is_feature_business'])->name('featured.post_count.success.business');
Route::get('/bump/business/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'if_bump_is_free_business'])->name('bump.success.business');

Route::get('/featured/post_count/entertainment/{post_id}', [\App\Http\Controllers\Frontend\reviewController::class, 'is_post_is_feature_entertainment'])->name('featured.post_count.success.entertainment');

Route::post('/search-listing', [\App\Http\Controllers\Frontend\PostController::class, 'search_listing'])->name('search_listing');

Route::post('/search-members', [\App\Http\Controllers\Frontend\PostController::class, 'search_members'])->name('search_members');


// Route::get('/user/listing/{id}', [\App\Http\Controllers\Frontend\PostController::class, 'user_profile_forntend'])->name('UserProfile')->middleware('web');

// Route::get('/user/listing/for/admin/{id}', [\App\Http\Controllers\Frontend\PostController::class, 'user_profile_forntend_admin'])->name('UserProfile.admin');

Route::match(['get', 'post'], '/fundraisers', '\App\Http\Controllers\Frontend\PostController@fundraisers')->name('fundraisers');

Route::post('/create-a-fundraisers', '\App\Http\Controllers\Frontend\PostController@add_fundraisers')->name('add.fundraisers');

Route::get('/fundraiser/post/list', '\App\Http\Controllers\Frontend\PostController@Fundraiser_post_list')->name('list.fundraisers')->middleware('update_outdated_post');

Route::get('/fundraiser/post/edit/{slug}', '\App\Http\Controllers\Frontend\PostController@edit_fundraisers')->name('edit.fundraisers');

Route::post('/fundraiser/post/update/{slug}', '\App\Http\Controllers\Frontend\PostController@update_fundraisers')->name('update.fundraisers');

Route::get('/fundraiser/listing', '\App\Http\Controllers\Frontend\JobpostController@fundraiser_listing')->name('listing.fundraisers');

Route::get('/fundraiser/single/{slug}', '\App\Http\Controllers\Frontend\JobpostController@fundraiser_single_listing')->name('single.fundraisers');


Route::get('/latest-post/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'All_latest_post'])->name('latestPostuser');

Route::post('/latest-status', [\App\Http\Controllers\Frontend\HomeController::class, 'latestStatusClick'])->name('latest.status.click');
