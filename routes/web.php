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

Auth::routes(['verify' => true]);

Route::group(['namespace' => 'Post'], function () {
    Route::resource('/post', 'PostController');
});

Route::group(['namespace' => 'Category'], function () {
    Route::resource('/category', 'CategoryController', ['only' => 'store']);
});

Route::group(['namespace' => 'Tag'], function () {
    Route::resource('/tag', 'TagController', ['only' => 'store']);
});

Route::group(['namespace' => 'Comment'], function () {
    Route::resource('/comment', 'CommentController', ['only' => 'store']);
});

Route::group(['namespace' => 'User'], function () {
    Route::resource('/user', 'UserController', ['only' => ['show', 'update']]);
});

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/test', function () {
//     // return App\Comment::where('parent_id', '!=', null)->get();
//     // return App\Comment::find(1)->parent;
// });
