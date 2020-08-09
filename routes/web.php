<?php

use App\Http\Controllers\PostController;
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

Auth::routes();

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/posts', 'PostController@showPosts')->name('posts');
    Route::post('/postSubmit', 'PostController@postSubmit')->name('postSubmit');
    Route::post('/deletePost', 'PostController@deletePost')->name('deletePost');
    Route::get('/getPosts', 'PostController@getPosts')->name('getPosts');
    Route::get('/test', 'PostController@test')->name('test');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/post/{id}/{slug}', 'PostController@showPost')->name('showPost');
Route::get('/paginationResults', 'PostController@paginationResults')->name('paginationResults');
Route::get('/getPost/{id}', 'PostController@getPost')->name('getPost');
Route::get('/currentUser', function () {
    return auth()->user();
});
