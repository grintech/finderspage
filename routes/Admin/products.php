<?php
Route::get('/products', '\App\Http\Controllers\Admin\Products\ProductsController@index')
    ->name('admin.products');

Route::get('/products/add', '\App\Http\Controllers\Admin\Products\ProductsController@add')
    ->name('admin.products.add');

Route::post('/products/add', '\App\Http\Controllers\Admin\Products\ProductsController@add')
    ->name('admin.products.add');

Route::get('/products/{id}/view', '\App\Http\Controllers\Admin\Products\ProductsController@view')
    ->name('admin.products.view');

Route::get('/products/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductsController@edit')
    ->name('admin.products.edit');

Route::post('/products/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductsController@edit')
    ->name('admin.products.edit');

Route::post('/products/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductsController@bulkActions')
    ->name('admin.products.bulkActions');

Route::get('/products/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductsController@delete')
    ->name('admin.products.delete');

/*** Main Categories **/
Route::get('/products/main-categories', '\App\Http\Controllers\Admin\Products\MainCategoriesController@index')
    ->name('admin.products.mainCategories');

Route::get('/products/main-categories/add', '\App\Http\Controllers\Admin\Products\MainCategoriesController@add')
    ->name('admin.products.mainCategories.add');

Route::post('/products/main-categories/add', '\App\Http\Controllers\Admin\Products\MainCategoriesController@add')
    ->name('admin.products.mainCategories.add');

Route::get('/products/main-categories/{id}/edit', '\App\Http\Controllers\Admin\Products\MainCategoriesController@edit')
    ->name('admin.products.mainCategories.edit');

Route::post('/products/main-categories/{id}/edit', '\App\Http\Controllers\Admin\Products\MainCategoriesController@edit')
    ->name('admin.products.mainCategories.edit');

Route::post('/products/main-categories/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@bulkActions')
    ->name('admin.products.mainCategories.bulkActions');

Route::get('/products/main-categories/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@delete')
    ->name('admin.products.mainCategories.delete');


/*** Categories **/
Route::get('/products/categories', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@index')
    ->name('admin.products.categories');

Route::get('/products/categories/add', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@add')
    ->name('admin.products.categories.add');

Route::post('/products/categories/add', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@add')
    ->name('admin.products.categories.add');

Route::get('/products/categories/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@edit')
    ->name('admin.products.categories.edit');

Route::post('/products/categories/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@edit')
    ->name('admin.products.categories.edit');

Route::post('/products/categories/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@bulkActions')
    ->name('admin.products.categories.bulkActions');

Route::get('/products/categories/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductCategoriesController@delete')
    ->name('admin.products.categories.delete');


/*** Sub Categories **/
Route::get('/products/sub-categories', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@index')
    ->name('admin.products.subCategories');

Route::get('/products/sub-categories/find', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@findChildren')
    ->name('admin.products.subCategories.findChildren');

Route::get('/products/sub-categories/add', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@add')
    ->name('admin.products.subCategories.add');

Route::post('/products/sub-categories/add', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@add')
    ->name('admin.products.subCategories.add');

Route::get('/products/sub-categories/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@edit')
    ->name('admin.products.subCategories.edit');

Route::post('/products/sub-categories/{id}/edit', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@edit')
    ->name('admin.products.subCategories.edit');

Route::post('/products/sub-categories/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@bulkActions')
    ->name('admin.products.subCategories.bulkActions');

Route::get('/products/sub-categories/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductSubCategoriesController@delete')
    ->name('admin.products.subCategories.delete');


/** Orders  **/
Route::get('/products/orders', '\App\Http\Controllers\Admin\Products\ProductOrdersController@index')
    ->name('admin.products.orders');
Route::get('/products/orders/{id}/view', '\App\Http\Controllers\Admin\Products\ProductOrdersController@view')
    ->name('admin.products.orders.view');
Route::post('/products/orders/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductOrdersController@bulkActions')
    ->name('admin.products.orders.bulkActions');
Route::get('/products/orders/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductOrdersController@delete')
    ->name('admin.products.orders.delete');

/** Queries  **/
Route::get('/products/queries', '\App\Http\Controllers\Admin\Products\ProductQueriesController@index')
    ->name('admin.products.queries');
Route::get('/products/queries/{id}/view', '\App\Http\Controllers\Admin\Products\ProductQueriesController@view')
    ->name('admin.products.queries.view');
Route::post('/products/queries/bulkActions/{action}', '\App\Http\Controllers\Admin\Products\ProductQueriesController@bulkActions')
    ->name('admin.products.queries.bulkActions');
Route::get('/products/queries/{id}/delete', '\App\Http\Controllers\Admin\Products\ProductQueriesController@delete')
    ->name('admin.products.queries.delete');