<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\Site\HomeController@index')->name('home');
Route::get('/product/{product}', 'App\Http\Controllers\Site\HomeController@show')->name('products.show');
Route::post('/get-order-form', 'App\Http\Controllers\Site\HomeController@getOrderForm')->name('products.getOrderForm');
Route::post('/order-create', 'App\Http\Controllers\Site\HomeController@orderCreate')->name('order.create');
Route::get('/order-show/{order}', 'App\Http\Controllers\Site\HomeController@orderShow')->name('order.show');

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'App\Http\Controllers\Admin',
    ],
    function () {
        Route::get('/', 'App\Http\Controllers\Admin\HomeController@index')->name('home');
        Route::post('/orders/set-status/{order}', 'App\Http\Controllers\Admin\OrderController@setStatus')->name('order.set-status');
        Route::resource('products', 'ProductController');

        Route::get('/orders', 'App\Http\Controllers\Admin\OrderController@index')->name('orders.index');
        Route::get('/orders/{order}', 'App\Http\Controllers\Admin\OrderController@show')->name('orders.show');
    });
