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

use App\User;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['namespace' => 'Post'], function () {
    Route::resource('/post', 'PostController');
});

Route::group(['namespace' => 'Comment'], function () {
    Route::resource('/comment', 'CommentController', ['only' => 'store']);
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'User'], function () {
    Route::resource('/user', 'UserController');
});

Route::get('/test', function () {
    // return App\Comment::where('parent_id', '!=', null)->get();
    // return App\Comment::find(1)->parent;
});
