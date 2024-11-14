<?php
use Illuminate\Support\Facades\Route;


Route::post('hours/save', '\App\Http\Controllers\Frontend\ServiceHourController@store')->name('hours.save');


Route::get('/get/followers/{id}', [\App\Http\Controllers\Frontend\ProfileController::class, 'getconnectedUser'])->name('get.followers');
//POSTBLOG //

Route::get('/blog-post-add', [\App\Http\Controllers\Frontend\PostBlogController::class, 'index'])->name('BlogPost.add');

//close post blog //
Route::post('user-search-result','\App\Http\Controllers\Frontend\JobpostController@user_Search_result')->name('user.search.result');

Route::post('request/accept', '\App\Http\Controllers\Frontend\FollowController@RequestAccept')->name('request.accept');

Route::post('user-search-result-home', '\App\Http\Controllers\Frontend\JobpostController@user_Search_result_home')->name('user.search.result.home');

Route::get('user-search-page', '\App\Http\Controllers\Frontend\JobpostController@userSearchPage')->name('user.search.page');
Route::get('new-pricing', '\App\Http\Controllers\Frontend\JobpostController@newpricing')->name('newpricing');

Route::post('pin-to-profile', [\App\Http\Controllers\Frontend\BlogpostController::class, 'pin_to_profile']);

// Route::get('update-all-slug', [\App\Http\Controllers\Frontend\BlogpostController::class, 'create_slug_for_blog']);

 Route::get('update-all-slug-post', [\App\Http\Controllers\Frontend\PostController::class, 'create_slug_for_Posts']);


Route::post('cron/video', [\App\Http\Controllers\Frontend\VideosController::class, 'CronVideo'])->name('cron.video');

Route::post('get/place/autocomplete', '\App\Http\Controllers\Frontend\HomeController@autocomplete')->name('get.Places/autocomplete');
Route::get('get/current/Location', '\App\Http\Controllers\Frontend\HomeController@getCurrentLocation')->name('getCurrentLocation');

Route::post('report/', '\App\Http\Controllers\Frontend\PostReportController@store')->name('post.report');
Route::post('fundraiser/report/', '\App\Http\Controllers\Frontend\PostReportController@fundraiser_report')->name('fundraiser.report');

Route::get('privacy/Activity', '\App\Http\Controllers\Frontend\HomeController@privacyActivity')->name('privacy.activity');

Route::get('profile/job/{id}', '\App\Http\Controllers\Frontend\JobpostController@profileJobpost')->name('profile.job');
Route::get('profile/real-estate/{id}', '\App\Http\Controllers\Frontend\JobpostController@profilerealestatepost')->name('profile.realestate');
Route::get('profile/community/{id}', '\App\Http\Controllers\Frontend\JobpostController@profilecommunitypost')->name('profile.community');
Route::get('profile/shopping/{id}', '\App\Http\Controllers\Frontend\JobpostController@profileshoppingpost')->name('profile.shopping');
Route::get('profile/services/{id}', '\App\Http\Controllers\Frontend\JobpostController@profileservicespost')->name('profile.services');


Route::get('/all-post', '\App\Http\Controllers\Frontend\JobpostController@getAllpost')->name('getAllpostpost');

Route::post('filter-data', '\App\Http\Controllers\Frontend\JobpostController@FilterData_popular')->name('filter.data');

Route::post('filter-data-category', '\App\Http\Controllers\Frontend\JobpostController@FilterData_popular_category')->name('filter.data.category');

Route::post('filter-data-uncategorized', '\App\Http\Controllers\Frontend\JobpostController@get_post_Uncategorized')->name('filter.data.uncategorized');

Route::get('/all-Featured-post', '\App\Http\Controllers\Frontend\HomeController@AllFeaturedpost')->name('getAllfeaturedpost');

Route::get('dashboard/video', [\App\Http\Controllers\Frontend\VideosController::class, 'DashboardIndex'])->name('dashboard.video');


Route::get('/video', [\App\Http\Controllers\Frontend\VideosController::class, 'index'])->name('video');
Route::get('/single/video/{id}', [\App\Http\Controllers\Frontend\VideosController::class, 'create'])->name('single.video');

Route::get('/single/test/video/{id}', [\App\Http\Controllers\Frontend\VideosController::class, 'testlisting'])->name('single.test.video');

Route::get('/list/video', [\App\Http\Controllers\Frontend\VideosController::class, 'listing'])->name('listing.video');
Route::get('/delete/video/{id}', [\App\Http\Controllers\Frontend\VideosController::class, 'destroy'])->name('delete.video');
Route::get('/edit/video/{id}', [\App\Http\Controllers\Frontend\VideosController::class, 'edit'])->name('edit.video');
Route::post('/save/video', [\App\Http\Controllers\Frontend\VideosController::class, 'store'])->name('save.video');
Route::post('/update/video/{id}', [\App\Http\Controllers\Frontend\VideosController::class, 'update'])->name('update.video');

Route::post('/get/video/hashtag', [\App\Http\Controllers\Frontend\VideosController::class, 'getHasTag'])->name('get.hashtag');

Route::post('/video/reply', [\App\Http\Controllers\Frontend\VideosController::class, 'video_comment_reply'])->name('video.reply');

Route::post('/getchildcat', [App\Http\Controllers\Frontend\AppController::class, 'getchildcat'])->withoutMiddleware(['csrf']);

Route::post('/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'filter'])->name('filter');

Route::post('/fundraiser-filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'fundraiser_filter'])->name('fundraiser_filter');

Route::post('/realestate/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'realEstate_filter'])->name('realEstate_filter');

Route::post('/service/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'service_filter'])->name('service_filter');

Route::post('/shop/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'shopping_filter'])->name('shopping_filter');

Route::post('/Event/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'event_filter'])->name('event_filter');

Route::post('/community/filter', [\App\Http\Controllers\Frontend\JobpostController::class, 'Coummunity_filter'])->name('Coummunity_filter');

Route::get('/service-listing', '\App\Http\Controllers\Frontend\JobpostController@service_listing')->name('service_listing');

Route::get('/service-single/{slug}', '\App\Http\Controllers\Frontend\JobpostController@service_single')->name('service_single')->middleware('get_listing_view');

Route::get('/job-listing', '\App\Http\Controllers\Frontend\JobpostController@listingPage')->name('job_listing');

Route::get('/realestate-listing', '\App\Http\Controllers\Frontend\JobpostController@listing_realestate')->name('listing_realestate');

Route::get('/job-post/{slug}', '\App\Http\Controllers\Frontend\JobpostController@index')->name('jobpost')->middleware('get_listing_view');

Route::get('/real_esate-post/{slug}', '\App\Http\Controllers\Frontend\JobpostController@realestate_single')->name('real_esate_post')->middleware('get_listing_view');

Route::get('/blog-category/{id}', '\App\Http\Controllers\Frontend\JobpostController@blogCategory')->name('blog_category');

Route::get('/shopping-post', '\App\Http\Controllers\Frontend\JobpostController@shopping_list')->name('shopping_post');

Route::get('/shopping-post-single/{slug}', '\App\Http\Controllers\Frontend\JobpostController@shopping_single')->name('shopping_post_single')->middleware('get_listing_view');

Route::get('/community-post', '\App\Http\Controllers\Frontend\JobpostController@ourcommunity_listing')->name('community_post');

Route::get('/community-single-post/{slug}', '\App\Http\Controllers\Frontend\JobpostController@ourcommunity_single')->name('community_single_post')->middleware('get_listing_view');

Route::get('/business/Form', '\App\Http\Controllers\Frontend\JobpostController@businessForm')->name('businessForm');

Route::get('/select', '\App\Http\Controllers\Frontend\HomeController@select_rule')->name('select');


Route::get('/about-brenda', '\App\Http\Controllers\Frontend\PostController@about_brenda')->name('about_brenda');

Route::get('/user-profile/{id}', '\App\Http\Controllers\Frontend\ProfileController@index')->name('user_profile');

Route::get('/edit-profile/{id}', '\App\Http\Controllers\Frontend\ProfileController@edit_profile')->name('edit_user_profile_das');

Route::post('/update-profile/{id}', '\App\Http\Controllers\Frontend\ProfileController@updateProfile')->name('update_user_profile_das');

// Route::post('/user-profile-image', '\App\Http\Controllers\Frontend\ProfileController@profile_image')->name('user_profile_image');

Route::post('/user-profile-image', [\App\Http\Controllers\Frontend\ProfileController::class, 'profile_image']);
Route::post('/user-cover-image', [\App\Http\Controllers\Frontend\ProfileController::class, 'profile_cover_image']);
Route::post('/filter/state', [\App\Http\Controllers\Frontend\ProfileController::class, 'fetch_state']);
Route::post('/filter/city', [\App\Http\Controllers\Frontend\ProfileController::class, 'fetch_city']);

Route::post('/search-posts', '\App\Http\Controllers\Frontend\HomeController@search')->name('search');

Route::post('/search-all', '\App\Http\Controllers\Frontend\HomeController@search_posts')->name('search_posts');

Route::post('search-popular', '\App\Http\Controllers\Frontend\HomeController@search_popular')->name('search_popular');

Route::post('search-location', '\App\Http\Controllers\Frontend\HomeController@getLocationSearch')->name('getLocationSearch');

Route::post('search-all-posts', '\App\Http\Controllers\Frontend\HomeController@getAllSearches')->name('getAllSearches');

Route::get('/event', '\App\Http\Controllers\Frontend\JobpostController@eventListing')->name('event');
Route::get('/event/single/{id}', '\App\Http\Controllers\Frontend\JobpostController@eventSingle')->name('event_single');

Route::get('/Bump/post', '\App\Http\Controllers\Frontend\JobpostController@listingBumpPost')->name('Bump_post');

Route::get('/saved/post', '\App\Http\Controllers\Frontend\JobpostController@SavePostListing')->name('saved_post');

Route::get('/resume', '\App\Http\Controllers\Frontend\ResumeController@index')->name('resume');
Route::get('/resume-list', '\App\Http\Controllers\Frontend\ResumeController@create')->name('resume.list');
Route::get('/resume-edit/{id}', '\App\Http\Controllers\Frontend\ResumeController@edit')->name('resume.edit');
Route::get('/resume-delete/{id}', '\App\Http\Controllers\Frontend\ResumeController@destroy')->name('resume.delete');
Route::post('/resume-store', '\App\Http\Controllers\Frontend\ResumeController@store')->name('resume.store');
Route::post('/resume-update/{id}', '\App\Http\Controllers\Frontend\ResumeController@update')->name('resume.update');
Route::get('/resume-single/{id}', '\App\Http\Controllers\Frontend\ResumeController@show')->name('resume.single-post');
Route::get('/resume-listing', '\App\Http\Controllers\Frontend\ResumeController@listingResume')->name('listingResume');
Route::post('/resume-filter', '\App\Http\Controllers\Frontend\ResumeController@FilterResume')->name('FilterResume');


Route::post('/fetch-state', '\App\Http\Controllers\Frontend\ResumeController@fetch_state')->name('fetch.state');
Route::post('/fetch-city', '\App\Http\Controllers\Frontend\ResumeController@fetch_city')->name('fetch.city');


Route::post('/check-saved-post', '\App\Http\Controllers\Frontend\ResumeController@CheckSavedpost')->name('saved_post_check');

Route::post('/like_video', '\App\Http\Controllers\Frontend\VideosController@video_like')->name('video_like');
Route::post('/dislike_video', '\App\Http\Controllers\Frontend\VideosController@video_dislike')->name('video_dislike');
Route::post('/video_comment', '\App\Http\Controllers\Frontend\VideosController@video_comment')->name('video_comment');
Route::post('/video_save', '\App\Http\Controllers\Frontend\VideosController@video_save')->name('video_saves');

Route::post('/getfollower', '\App\Http\Controllers\Frontend\VideosController@getfollower')->name('getfollower');

Route::post('/video_comment_update/{comment_id}', 'App\Http\Controllers\Frontend\VideosController@video_comment_update')->name('video_comment_update');
Route::delete('/video_comment_delete/{comment_id}', 'App\Http\Controllers\Frontend\VideosController@video_comment_delete')->name('video_comment_delete');

Route::post('/video-comment-hide', '\App\Http\Controllers\Frontend\VideosController@video_comment_hide')->name('video.comment.hide');



//Entertainment//
Route::get('Entertainment/', '\App\Http\Controllers\Frontend\EntertainmentController@index')->name('Entertainment');
Route::get('Entertainment/listing', '\App\Http\Controllers\Frontend\EntertainmentController@listing')->name('Entertainment.listing');

Route::get('Entertainment/single/listing/{slug}', '\App\Http\Controllers\Frontend\EntertainmentController@single_listing')->name('Entertainment.single.listing')->middleware('get_listing_view');
Route::post('Entertainment/save', '\App\Http\Controllers\Frontend\EntertainmentController@store')->name('Entertainment.save');

Route::get('Entertainment/d-listing', '\App\Http\Controllers\Frontend\EntertainmentController@listing_D_Entertainment')->name('Entertainment.d-list')->middleware('update_outdated_entertainment_post');
Route::get('Entertainment/edit/{slug}', '\App\Http\Controllers\Frontend\EntertainmentController@edit')->name('Entertainment.d_edit');

Route::post('Entertainment/update/{slug}', '\App\Http\Controllers\Frontend\EntertainmentController@update')->name('Entertainment.d_update');

Route::get('Entertainment/delete/{id}', '\App\Http\Controllers\Frontend\EntertainmentController@destroy')->name('Entertainment.delete');

Route::post('shopping/cate', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add_shopping_cate')->name('shopping_cate');

Route::post('apply/job', '\App\Http\Controllers\Frontend\JobApplyController@store')->name('apply.job');
Route::get('apply/list/{job_id}', '\App\Http\Controllers\Frontend\JobApplyController@create')->name('apply.list');
Route::get('apply/edit/{id}', '\App\Http\Controllers\Frontend\JobApplyController@edit')->name('apply.edit');
Route::post('apply/update/{id}', '\App\Http\Controllers\Frontend\JobApplyController@update')->name('apply.update');
Route::get('apply/destroy/{id}', '\App\Http\Controllers\Frontend\JobApplyController@destroy')->name('apply.destroy');


Route::get('apply/byUser', '\App\Http\Controllers\Frontend\JobApplyController@index')->name('apply.byUser');

Route::get('blogs/{slug}', '\App\Http\Controllers\Frontend\JobpostController@blog_single_page')->name('blogPostSingle')->middleware('record_post_view');

Route::get('blogs', '\App\Http\Controllers\Frontend\JobpostController@blog_listing_page')->name('blogPostlisting');

Route::get('blog/sa-admin', '\App\Http\Controllers\Frontend\JobpostController@blog_SA_admin_listing_page')->name('blog.admin.blog');

Route::post('blog/listing/filter', '\App\Http\Controllers\Frontend\BlogpostController@Blog_data_request')->name('blogPost_filter');

//frontend//
Route::get('blog/add', '\App\Http\Controllers\Frontend\BlogpostController@index')->name('blog.add');
Route::post('blog/save', '\App\Http\Controllers\Frontend\BlogpostController@blogFormsave')->name('blogpost.save');
Route::get('blog/list', '\App\Http\Controllers\Frontend\BlogpostController@blogList')->name('blog.list');
Route::get('blog/edit/{slug}', '\App\Http\Controllers\Frontend\BlogpostController@blogedit')->name('blog.edit');
Route::post('blog/update/{slug}', '\App\Http\Controllers\Frontend\BlogpostController@blogupdate')->name('blogpost.update');
Route::get('blog/delete/{id}', '\App\Http\Controllers\Frontend\BlogpostController@blogdelete')->name('blogpost.delete');

Route::get('new/blogs-form', '\App\Http\Controllers\Frontend\PostController@new_blog_layouts')->name('new.blogs.form');
Route::post('new/blogs-form-save', '\App\Http\Controllers\Frontend\PostController@new_blog_layouts')->name('new.blogs.form.save');


Route::get('business/Feature/post', '\App\Http\Controllers\Frontend\HomeController@business_Featured_post')->name('business.Feature');

Route::get('job/Feature/post', '\App\Http\Controllers\Frontend\HomeController@job_Featured_post')->name('job.Feature');

Route::get('realesate/Feature/post', '\App\Http\Controllers\Frontend\HomeController@realEstate_Featured_post')->name('realestate.Feature');

Route::get('community/Feature/post', '\App\Http\Controllers\Frontend\HomeController@community_Featured_post')->name('community.Feature');

Route::get('service/Feature/post', '\App\Http\Controllers\Frontend\HomeController@Service_Featured_post')->name('service.Feature');

Route::get('fundraiser/Feature/post', '\App\Http\Controllers\Frontend\HomeController@fundraiser_Featured_post')->name('fundraiser.Feature');

Route::get('entertainment/Feature/post', '\App\Http\Controllers\Frontend\HomeController@Entertainment_Featured_post')->name('entertainment.Feature');


//blog Comments//

Route::post('blog/hide', '\App\Http\Controllers\Frontend\BlogCommentController@Hide_Comments')->name('blogcomment.hide')->middleware('auth');

Route::post('blog/comment', '\App\Http\Controllers\Frontend\BlogCommentController@store')->name('blogcomment.save')->middleware('auth');

Route::post('blog/comment/reply', '\App\Http\Controllers\Frontend\BlogCommentController@Replystore')->name('blogcomment.save.reply')->middleware('auth');

Route::post('/fundraiser/comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser')->name('fundraisercomment.save');

Route::post('fundraiser/comment_reply', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_reply')->name('fundraisercomment.reply');

Route::post('fundraiser/hide_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_hide_comment')->name('fundraisercomment.hide');

Route::post('fundraiser/unhide_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_unhide_comment')->name('fundraisercomment.unhide');

// Route::post('fundraiser/show_hidden', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_show_hidden')->name('fundraisercomment.hidden');

Route::post('fundraiser/update_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_update_comment')->name('fundraisercomment.update');

// Route::match(['get', 'post'],'fundraiser/delete_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_delete_comment')->name('fundraisercomment.delete');

Route::post('fundraiser/likes', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_likes')->name('fundraiser.likes');

Route::post('listing-like', '\App\Http\Controllers\Frontend\LikeController@listing_likes')->name('listing.likes');

Route::post('fundraiser/pin_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_pin_comment')->name('fundraiser.comment.pin');

Route::post('fundraiser/unpin_comment', '\App\Http\Controllers\Frontend\BlogCommentController@fundraiser_unpin_comment')->name('fundraiser.comment.unpin');

Route::get('/comments/{id}/likes', '\App\Http\Controllers\Frontend\BlogCommentController@getCommentLikes')->name('comments.likes');

Route::get('/likes/{id}/likes', '\App\Http\Controllers\Frontend\LikeController@getLikes')->name('get.likes');

Route::post('shop\question', '\App\Http\Controllers\Frontend\ShopQuestionController@store')->name('shop.question.save');

Route::post('shop\answer', '\App\Http\Controllers\Frontend\ShopQuestionController@Answer_store')->name('shop.answer.save');

Route::get('user/notification', '\App\Http\Controllers\Frontend\BlogpostController@userNotification')->name('user.notification');

Route::post('/notification/mark-as-read/{id}', '\App\Http\Controllers\Admin\NotificationController@markAsRead')
    ->name('markAsRead');

Route::post('/hide-notification/{id}', '\App\Http\Controllers\Admin\NotificationController@hide_notification')
    ->name('hide_notification');

Route::post('/block-notification/{id}', '\App\Http\Controllers\Admin\NotificationController@block_notification')
    ->name('block_notification');
    
Route::post('/notification/show-hidden/{id}', '\App\Http\Controllers\Admin\NotificationController@show_hidden')->name('show_hide');

Route::post('/notification/show-blocked/{id}', '\App\Http\Controllers\Admin\NotificationController@show_blocked')->name('show_blocked');

Route::post('/unhide-notification/{id}', '\App\Http\Controllers\Admin\NotificationController@unhide_notification')
    ->name('unhide_notification');

Route::post('/unblock-notification/{id}', '\App\Http\Controllers\Admin\NotificationController@unblock_notification')
    ->name('block_notification');

Route::get('notification/clear/{id}', '\App\Http\Controllers\Admin\NotificationController@ClearNotification')->name('notification.clear');

// longvideo //

Route::get('long-video', '\App\Http\Controllers\Frontend\LongvideoController@index')->name('long.video');
Route::get('test-profile/{user_id}', '\App\Http\Controllers\Frontend\PostController@testUserProfile')->name('test.profile');
Route::post('/update/{comment_id}', '\App\Http\Controllers\Frontend\BlogCommentController@update')->name('updateComment');
Route::delete('/delete-comment/{comment_id}', '\App\Http\Controllers\Frontend\BlogCommentController@destroy')->name('deleteComment');

Route::get('/job-View-All', '\App\Http\Controllers\Frontend\JobpostController@blogs_html')->name('jobAll');

Route::get('/shopping-featured', '\App\Http\Controllers\Frontend\JobpostController@shoppingViewAll')->name('shoppingViewAll');

Route::get('/business-featured', '\App\Http\Controllers\Frontend\JobpostController@businessViewAll')->name('businessViewAll');

Route::get('/job-featured', '\App\Http\Controllers\Frontend\JobpostController@jobViewAll')->name('jobViewAll');

Route::get('/realestate-featured', '\App\Http\Controllers\Frontend\JobpostController@realesteteViewAll')->name('realesteteViewAll');

Route::get('/community-featured', '\App\Http\Controllers\Frontend\JobpostController@communityViewAll')->name('communityViewAll');

Route::get('/service-featured', '\App\Http\Controllers\Frontend\JobpostController@servicViewAll')->name('servicViewAll');

Route::get('/fundraiser-featured', '\App\Http\Controllers\Frontend\JobpostController@fundraiserViewAll')->name('fundraiserViewAll');

Route::get('/entertainment-featured', '\App\Http\Controllers\Frontend\JobpostController@entertainmentViewAll')->name('entertainmentViewAll');

Route::get('/video-featured', '\App\Http\Controllers\Frontend\JobpostController@videoViewAll')->name('videoViewAll');

Route::get('/Blogs-featured', '\App\Http\Controllers\Frontend\JobpostController@BlogsViewAll')->name('blogsViewAll');

Route::post('/payment-update', '\App\Http\Controllers\Frontend\HomeController@paymentUpdateUser')->name('payment.update');



Route::get('/update-all-video', [\App\Http\Controllers\Frontend\VideosController::class, 'UpdatevideoScript'])->name('update-all-video');

Route::get('checkCormFUnct', '\App\Http\Controllers\Frontend\JobpostController@checkCormFUnct')->name('checkCormFUnct');


Route::post('save/product/review', '\App\Http\Controllers\Frontend\ProductReviewController@store')->name('save.product.review');

Route::post('add/product/report/{id}', '\App\Http\Controllers\Frontend\ProductReviewController@add')->name('add.product.report');

Route::post('update/product/review/{id}', '\App\Http\Controllers\Frontend\ProductReviewController@update')->name('update.product.review');

Route::delete('/delete-review/{review_id}', '\App\Http\Controllers\Frontend\ProductReviewController@destroy')->name('deleteReview');

Route::post('update/available/now', '\App\Http\Controllers\Frontend\JobpostController@update_available_now')->name('update_available_now');
Route::post('update/available/now/business', '\App\Http\Controllers\Frontend\JobpostController@update_available_now_business')->name('update_available_now_business');

Route::post('remove_image_db/', '\App\Http\Controllers\Frontend\JobpostController@remove_image_db')->name('remove_image_db');
Route::post('remove_image_db_blog/', '\App\Http\Controllers\Frontend\JobpostController@remove_image_db_blog')->name('remove_image_db_blog');
Route::post('remove_image_db_entertainment/', '\App\Http\Controllers\Frontend\JobpostController@remove_image_db_entertainment')->name('remove_image_db_entertainment');

Route::post('get_blog_image_location/', '\App\Http\Controllers\Frontend\JobpostController@get_blog_image_location')->name('get_blog_image_location');


Route::get('/test-500', function () {
    abort(500);
});

Route::post('get-posts-by-location', '\App\Http\Controllers\Frontend\JobpostController@getPostsByLocation')->name('getPostsByLocation');

Route::get('restore-listing/{id}', '\App\Http\Controllers\Frontend\JobpostController@GetdeletedlisttingData')->name('getPostsdeleted');

Route::get('restore-single-listing/{category_id}', '\App\Http\Controllers\Frontend\JobpostController@GetdeletedSinglelistting')->name('getSinglePostsdeleted');

Route::get('restore-listing-data/{id}/{type}', '\App\Http\Controllers\Frontend\JobpostController@restoreDeletedData')->name('getPostsdeleted.restore');

Route::get('delete-listing-data/{id}/{type}', '\App\Http\Controllers\Frontend\JobpostController@DeletedDataPermanently')->name('deleted.restore.data');

Route::post('update/imagedata/listing', '\App\Http\Controllers\Frontend\JobpostController@updateimageData')->name('update.imagedata');

Route::post('update/imagedata/blog', '\App\Http\Controllers\Frontend\JobpostController@updateimageData_blogpost')->name('update.imagedata.blogs');

Route::post('update/imagedata/entertainment', '\App\Http\Controllers\Frontend\JobpostController@updateimageData_entertainment')->name('update.imagedata.entertainment');

Route::get('Check-function', '\App\Http\Controllers\Frontend\JobpostController@CheckFunction')->name('Check.function');
