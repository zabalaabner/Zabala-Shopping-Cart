<?php

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
use App\Product;

Route::get('/', function () {
	$products = Product::all();
    return view('welcome',compact('products'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/addtocart/{product_id}','HomeController@addtocart');
Route::get('/checkoutprocess','HomeController@checkoutprocess');
Route::get('/checkout','HomeController@checkout');
