<?php

//user
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::post('logout', 'UserController@logout');
    Route::post('refresh', 'UserController@refresh');
    Route::get('/profile', 'UserController@profile');
});

Route::group([
    'prefix' => 'admin'
], function ($router) {

    Route::post('login', 'AdminController@login');
    Route::post('register', 'AdminController@register');
    Route::post('logout', 'AdminController@logout');
    Route::post('refresh', 'AdminController@refresh');
    Route::get('/profile', 'AdminController@profile');

});

//landing page
Route::get('/product/landingpage', [
    'uses' => 'LandingPageController@index'
]);

//coupon check
Route::get('/coupon/check', [
    'uses' => 'CouponController@check',
    'as' => 'coupon.check'
]);

Route::get('/product/get/{category_slug?}', [
    'uses' => 'LandingPageController@shop'
]);

Route::post('/wishlist/{id}', [
    'uses' => 'UserController@wishlist',
    'as' => 'user.wishlist'
]);

Route::get('/wishlists', [
    'uses' => 'UserController@display_wishlist',
    'as' => 'user.wishlist.get'
]);

//user
Route::get('/user/notification', [
    'uses' => 'UserController@notification'
]);

Route::get('/user/markAsRead/{id}', [
    'uses' => 'UserController@markAsRead'
]);
//order
Route::get('order/status/{status?}', [
    'uses' => 'OrderController@status',
    'as' => 'order.get.status'
]);
//apis that are related to models
Route::post('/blogs/image_upload', [
    'uses' => 'BlogController@blog_image',
    'as' => 'blog.images'
]);

Route::apiResources([
    'products' => 'ProductController',
    'categories' => 'CategoryController',
    'brands' => 'BrandController',
    'coupons' => 'CouponController',
    'sliders' => 'SliderController',
    'orders' => "OrderController",
    'blogs' => 'BlogController',
]);
