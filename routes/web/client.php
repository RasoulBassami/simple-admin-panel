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
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('posts', 'PostController')->except('show');
Route::resource('posts.images', 'ImageController')->except('show')->middleware('can:view,post');
