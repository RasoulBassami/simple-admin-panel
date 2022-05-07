<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard')->middleware(['auth', 'adminCheck']);

Route::resource('posts', 'PostController')->except(['show', 'create', 'store'])->middleware(['auth', 'adminCheck']);
Route::resource('users', 'UserController')->except(['show'])->middleware(['auth', 'adminCheck']);
