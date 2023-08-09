<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('home', 'HomeController');

Route::resource('reminders', 'ReminderController');

Route::resource('events', 'EventController');

Route::resource('user', 'UserController');

Route::put('/user/updateName', 'UserController@updateName')->name('user.updateName');
Route::put('/user/updateEmail', 'UserController@updateEmail')->name('user.updateEmail');
Route::put('/user/updatePassword', 'UserController@updatePassword')->name('user.updatePassword');