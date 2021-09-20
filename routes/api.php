<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');

Route::group(['middleware' => 'loginauth'], function () {
	Route::get('logout', 'LoginController@logout');

	Route::get('products', 'ProductController@getAllProduct');
	Route::post('product-save', 'ProductController@store');
	Route::get('get-product/{id}', 'ProductController@edit');
	Route::get('delete-product/{id}', 'ProductController@delete');
});