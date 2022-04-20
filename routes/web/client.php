<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'LoginController@show')->name('login');
Route::post('/', 'LoginController@login');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth', 'userCheck']);

Route::resource('posts', 'PostController')->except('show')->middleware(['auth', 'userCheck']);
//Route::resource('posts.images', 'ImageController')->except('show')->middleware(['auth', 'userCheck', 'can:view,post']);

Route::delete('posts/{post}/images/{image}', 'ImageController@destroy')->name('post.image.delete')->middleware(['auth', 'userCheck', 'can:view,post']);
