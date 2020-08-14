<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'CategoryController@welcome')->name('startpage');

Route::get('/category={category}','CategoryController@viewCategory');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/adminpanel', 'AdminPanelController@index')->name('adminpanel')->middleware('auth');

Route::put('user/deactivate', 'UserManagmentController@deactivate')->name('user.deactivate')->middleware('auth');

Route::resource('posts', 'PostController');

Route::put('/category/deactivate', 'CategoryController@deactivate')->name('category.deactivate')->middleware('auth');

Route::put('/category/post/deactivate', 'PostController@deactivate')->name('posts.deactivate')->middleware('auth');

Route::resource('comment', 'CommentController')->middleware('auth')->middleware('web');

Route::get('/category/post/view', 'PostController@show')->name('posts.show');

Route::resource('user', 'UserManagmentController')->middleware('auth'); // verifica se o user está logged in antes de efetuar o request

