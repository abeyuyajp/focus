<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

//ユーザー
Auth::routes();
Route::get('/user/edit', 'UserController@edit')->name('user.edit');
Route::put('/user/{user}', 'UserController@update')->name('user.update');
Route::get('/user/{user}', 'UserController@show')->name('user.show');


//投稿
Route::get('/', 'PostsController@index');
Route::resource('/posts', 'PostsController',['except' => [ 'index', 'destroy']]);
Route::get('/home', 'HomeController@index')->name('home');

//カレンダー
Route::get('/get/calendar', 'PostsController@getAllEvent');
Route::get('/calendar', 'PostsController@showCalendar')->name('calendar.index');
Route::post('/delete','PostsController@deleteEvent');
Route::get('/get/calendar/join', 'PostsController@getJoinEvent');

//マッチング
Route::post('/joins', 'JoinController@store')->name('joins.store');
Route::delete('/joins/delete', 'JoinController@destroy')->name('joins.destroy');

//ビデオチャット
Route::get('/video_chat', 'VideoChatController@index')->name('video_chat.index');

//リアルタイムweb通知
Route::get('/user/{user}/notice_get', 'UserController@notice_get')->name('notice_get');
Route::put('/user/{user}/notice_checked', 'UserController@notice_checked')->name('notice_checked');
Route::get('/user/{user}/notice_index', 'UserController@notice_index')->name('notice_index');
Route::get('/user/{user}/notice_all_get', 'UserController@notice_all_get')->name('notice_all_get');


//検索機能
Route::get('/search', 'PostsController@search')->name('posts.search');





