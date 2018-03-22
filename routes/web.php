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

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.delete');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscriptionsController@store')
    ->name('threads_subscriptions.store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscriptionsController@destroy')
    ->name('threads_subscriptions.delete');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::get('/threads/{channel}', 'ThreadsController@index')->name('threads.channel');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.delete');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('favorites.store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('favorites.delete');
Route::get('/profile/{user}', 'ProfileController@show')->name('profile.show');
Route::get('/profile/{user}/notifications', 'UserNotificationsController@index')->name('user_notifications.index');
Route::delete('/profile/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('user_notifications.delete');
Route::post('/replies/{reply}/best', 'BestReplyController@store')->name('replies.best');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/{user}/avatar', 'AvatarsController@store')->name('avatars.store');
Route::get('/register/confirm', 'Api\UsersController@confirm')->name('user.confirm');