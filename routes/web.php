<?php

use Illuminate\Support\Facades\Route;
// use App\Post;
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

Route::middleware('auth:sanctum')->get('/posts', 'PostController@showPosts')->name('posts');
Route::middleware('auth:sanctum')->post('/postSubmit', 'PostController@postSubmit')->name('postSubmit');
Route::middleware('auth:sanctum')->post('/deletePost', 'PostController@deletePost')->name('deletePost');

Route::middleware('auth:sanctum')->get('/getPosts', 'PostController@getPosts')->name('getPosts');


Route::middleware('auth:sanctum')->get('/test', 'PostController@test')->name('test');
