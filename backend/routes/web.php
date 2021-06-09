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
Route::get('/', 'PostsController@index');
Route::resource('/posts', 'PostsController',['except' => ['show', 'index', 'destroy']]);
Route::get('/home', 'HomeController@index')->name('home');

//カレンダー
Route::get('/get/calendar', 'PostsController@getAllEvent');
Route::get('/calendar', 'PostsController@showCalendar')->name('calendar.index');
Route::post('/delete','PostsController@deleteEvent');

//マッチング
Route::post('/joins', 'JoinController@store')->name('joins.store');
Route::delete('/joins/delete', 'JoinController@destroy')->name('joins.destroy');

//ビデオチャット
Route::get('/video_chat', 'VideoChatController@index')->name('video_chat.index');



