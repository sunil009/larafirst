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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as' => 'admin.', 'middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
	Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
	Route::get('category/{category}/remove', 'CategoryController@remove')->name('category.remove');
	Route::get('category/trash', 'CategoryController@trash')->name('category.trash');
	Route::get('category/recover/{id}', 'CategoryController@recoverCat')->name('category.recover');

	Route::view('product/extras', 'admin.partials.extras')->name('product.extras');

	Route::resource('product', 'ProductController');
	Route::resource('category', 'CategoryController');

});