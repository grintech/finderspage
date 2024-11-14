<?php
Route::get('/checkemail_cc','\App\Http\Controllers\Admin\Blogs\BlogsController@checkemail_cc')->name('checkemail_cc');

Route::get('/blog/admin/review/{id}','\App\Http\Controllers\Admin\Blogs\BlogsController@get_productReview')->name('blog.admin.review');

Route::get('/blog/admin/review/del/{id}','\App\Http\Controllers\Admin\Blogs\BlogsController@delete_productReview')->name('blog.admin.review.del');

Route::get('/delete/reported_post/{id}','\App\Http\Controllers\Admin\Blogs\BlogsController@DeleteReportedPost')->name('delete.reported_post');

Route::get('/admin/review','\App\Http\Controllers\Admin\Blogs\BlogsController@getUserReviews')->name('admin.reviews');
Route::post('/review/status','\App\Http\Controllers\Admin\Blogs\BlogsController@UpdateUserReviews')->name('review.status');

Route::get('/review/delete/{id}','\App\Http\Controllers\Admin\Blogs\BlogsController@DeleteUserReviews')->name('review.delete');

Route::post('/admin/update_blog/status','\App\Http\Controllers\Admin\Blogs\BlogsController@blogUpdate_status')->name('update_blog.status');

Route::get('/support/ticket','\App\Http\Controllers\Admin\Blogs\BlogsController@getSupportTicket')->name('admin.support.ticket');

Route::post('/support/ticket/status','\App\Http\Controllers\Admin\Blogs\BlogsController@update_SupportTicket_status')->name('support.ticket.status');

Route::post('/video/status','\App\Http\Controllers\Admin\Blogs\BlogsController@update_video_status')->name('video.status');

Route::post('/support/ticket/email','\App\Http\Controllers\Admin\Blogs\BlogsController@EmailSupportTicket')->name('support.ticket.email');
 
Route::get('/admin/reported/post','\App\Http\Controllers\Admin\Blogs\BlogsController@getReportedPost')->name('admin.rep.post');

Route::get('/blogs/post','\App\Http\Controllers\Admin\Blogs\BlogsController@blogForm')->name('blog_post');
Route::post('/blogs/post/save','\App\Http\Controllers\Admin\Blogs\BlogsController@blogFormsave')->name('blog_post_save');
Route::post('/blogs/post/update/{slug}','\App\Http\Controllers\Admin\Blogs\BlogsController@blogupdate')->name('blog_post_update');
Route::get('/blogs/post/list','\App\Http\Controllers\Admin\Blogs\BlogsController@blogList')->name('blog_post_list');
Route::get('/blogs/post/edit/{slug}','\App\Http\Controllers\Admin\Blogs\BlogsController@blogedit')->name('blog_post_edit');
Route::get('/blogs/post/delete/{id}','\App\Http\Controllers\Admin\Blogs\BlogsController@blogdelete')->name('blog_post_delete');


Route::get('/featured-list', '\App\Http\Controllers\Admin\Blogs\FeaturedpostController@index')
    ->name('featured_list');

Route::get('/blogs', '\App\Http\Controllers\Admin\Blogs\BlogsController@index')->name('admin.blogs');

Route::get('/event', '\App\Http\Controllers\Admin\Blogs\BlogsController@event_add')->name('event_post');

Route::post('/event/post', '\App\Http\Controllers\Admin\Blogs\BlogsController@event_add')->name('event.blogs');

Route::get('edit/event/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit_event_post')->name('editEvent');

Route::post('update/event/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit_event_post')->name('updateEvent');


Route::get('/blogs/add', '\App\Http\Controllers\Admin\Blogs\BlogsController@add')

    ->name('admin.blogs.add');



Route::post('/blogs/add', '\App\Http\Controllers\Admin\Blogs\BlogsController@add')

    ->name('admin.blogs.add');



Route::get('/blogs/{id}/view', '\App\Http\Controllers\Admin\Blogs\BlogsController@view')

    ->name('admin.blogs.view');



Route::get('/blogs/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit')

    ->name('admin.blogs.edit');



Route::post('/blogs/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit')->name('admin.blogs.edit');


Route::get('/realestate/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit_realestate')->name('admin.realestate.edit');

Route::post('/realestate/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@edit_realestate')->name('admin.realestate.edit');


Route::get('/shopping/add/', '\App\Http\Controllers\Admin\Blogs\BlogsController@shopping')->name('admin.shopping');
Route::post('/shopping/add/', '\App\Http\Controllers\Admin\Blogs\BlogsController@shopping')->name('admin.shopping');

Route::get('/shopping/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@shopping_edit')->name('shopping.edit');
Route::post('/shopping/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@shopping_edit')->name('shopping.edit');


Route::get('/service/add/', '\App\Http\Controllers\Admin\Blogs\BlogsController@services')->name('admin.service');
Route::post('/service/add/', '\App\Http\Controllers\Admin\Blogs\BlogsController@services')->name('admin.service');

Route::get('/service/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@Service_edit')->name('service.edit');
Route::post('/service/edit/{id}', '\App\Http\Controllers\Admin\Blogs\BlogsController@Service_edit')->name('service.edit');


Route::post('/blogs/bulkActions/{action}', '\App\Http\Controllers\Admin\Blogs\BlogsController@bulkActions')

    ->name('admin.blogs.bulkActions');



Route::get('/blogs/{id}/delete', '\App\Http\Controllers\Admin\Blogs\BlogsController@delete')

    ->name('admin.blogs.delete');





/*** Categories **/

Route::get('/blogs/categories', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@index')

    ->name('admin.blogs.categories');



Route::get('/blogs/categories/add', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add')

    ->name('admin.blogs.categories.add');


// Route::post('/blogs/categories/getchild', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add')

//     ->name('admin.blogs.categories.getchild');

Route::post('/blogs/categories/getchild', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@getchild');

Route::post('/blogs/categories/add', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@add')

    ->name('admin.blogs.categories.add');



Route::get('/blogs/categories/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@edit')

    ->name('admin.blogs.categories.edit');



Route::post('/blogs/categories/{id}/edit', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@edit')

    ->name('admin.blogs.categories.edit');



Route::post('/blogs/categories/bulkActions/{action}', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@bulkActions')

    ->name('admin.blogs.categories.bulkActions');



Route::get('/blogs/categories/{id}/delete', '\App\Http\Controllers\Admin\Blogs\BlogCategoriesController@delete')
    ->name('admin.blogs.categories.delete');

Route::get('/entertainment/listing', '\App\Http\Controllers\Admin\EntertainmentController@index')
    ->name('admin.entertainment');

Route::post('/update/status/ent','\App\Http\Controllers\Admin\Blogs\BlogsController@update_status_entertainment')->name('updatestatus_ent');

Route::post('/updatestatus','\App\Http\Controllers\Admin\Blogs\BlogsController@update_status')->name('updatestatus');


Route::get('/realEstate/post','\App\Http\Controllers\Admin\Blogs\BlogsController@realestae_post')->name('realEstate_post');
Route::post('/realEstate/post','\App\Http\Controllers\Admin\Blogs\BlogsController@realestae_post')->name('realEstate_post');


Route::post('/fetch/state/job','\App\Http\Controllers\Admin\Blogs\BlogsController@fetch_state_job');

Route::post('/fetch/city/job','\App\Http\Controllers\Admin\Blogs\BlogsController@fetch_city_job');


Route::get('/post/payment','\App\Http\Controllers\Admin\Blogs\BlogsController@payment_get')->name('payment.post');

Route::get('/video','\App\Http\Controllers\Admin\VideoController@superAdminlisting')->name('video.list');
Route::get('/video/delete/{id}','\App\Http\Controllers\Admin\VideoController@deleteVideo')->name('video.Delete');

Route::post('/video/getuser','\App\Http\Controllers\Admin\VideoController@getalluser')->name('video.getuser');
Route::get('/video/add','\App\Http\Controllers\Admin\VideoController@add_video')->name('video.add');
Route::post('/video/save','\App\Http\Controllers\Admin\VideoController@store')->name('video.save');
Route::get('/video/edit/{id}','\App\Http\Controllers\Admin\VideoController@edit')->name('video.edit');
Route::post('/video/update/admin/{id}','\App\Http\Controllers\Admin\VideoController@update')->name('video.update.admin');


Route::get('/blog/admin/delete/{id}','\App\Http\Controllers\Admin\Blog\BlogsController@DeleteReportedPost')->name('blog.admin.delete');




Route::get('/sub-plan/list','\App\Http\Controllers\Admin\SubPlanController@index')->name('sub-plan.list');
Route::get('/sub-plan/add','\App\Http\Controllers\Admin\SubPlanController@create')->name('sub-plan.add');
Route::post('/sub-plan/save','\App\Http\Controllers\Admin\SubPlanController@store')->name('sub-plan.save');
Route::get('/sub-plan/edit/{id}','\App\Http\Controllers\Admin\SubPlanController@edit')->name('sub-plan.edit');
Route::post('/sub-plan/update/{id}','\App\Http\Controllers\Admin\SubPlanController@update')->name('sub-plan.update');
Route::post('/sub-plan/update/{id}','\App\Http\Controllers\Admin\SubPlanController@update')->name('sub-plan.update');


Route::get('/term-of-use/add','\App\Http\Controllers\Admin\TermofuseController@index')->name('term-of-use.add');
Route::post('/term-of-use/save','\App\Http\Controllers\Admin\TermofuseController@store')->name('term-of-use.save');






//business pages//
Route::get('business/list','\App\Http\Controllers\Admin\BusinessController@index')->name('admin.business.list');
Route::get('business/delete/{id}','\App\Http\Controllers\Admin\BusinessController@destroy')->name('admin.business.delete');
Route::post('business/status/update','\App\Http\Controllers\Admin\BusinessController@business_Update_status')->name('admin.business.status');











