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

$controllers = 'App\Http\Controllers\\';

/**
 * auth
 */
Route::view('/', 'auth.auth', ['form' => '']);
Route::view('/signup', 'auth.auth', ['form' => 'signup']);
Route::view('/login', 'auth.auth', ['form' => 'login']);
Route::post('/signup', $controllers . 'AuthController@signUp');
Route::post('/login', $controllers . 'AuthController@logIn');
Route::get('/logout', $controllers . 'AuthController@logout');

/**
 * profile
 */
Route::get('/profile/tweets/{username}', $controllers . 'ProfileController@getTweets');
Route::get('/profile/following/{username}', $controllers . 'ProfileController@getFollowing');
Route::get('/profile/followers/{username}', $controllers . 'ProfileController@getFollowers');
Route::get('/profile/likes/{username}', $controllers . 'ProfileController@getLikes');
Route::get('/profile/edit/{username}', $controllers . 'ProfileController@edit');
Route::post('/profile/edit/{username}', $controllers . 'ProfileController@update');

/**
 * navigation
 */
Route::get('/home/hashtag/{hashtag}', $controllers . 'HomeController@getTimelineForHashtag');
Route::get('/home', $controllers . 'HomeController@getTimeline');
Route::view('/moments', 'moments');
Route::view('/notifications', 'notifications');
Route::view('/messages', 'messages');

/**
 * tweets
 */
Route::resource('/tweets', $controllers . 'TweetController', ['only' => ['show', 'store', 'destroy']]);

/**
 * likes
 */
Route::resource('/likes', $controllers . 'LikeController', ['only' => ['index', 'store']]);

/**
 * retweets
 */
Route::resource('/retweets', $controllers . 'RetweetController', ['only' => ['index', 'store']]);

/**
 * follows
 */
Route::resource('/follows', $controllers . 'FollowController', ['only' => ['index', 'store']]);

/**
 * replies
 */
Route::resource('/replies', $controllers . 'ReplyController', ['only' => ['index', 'store']]);

/**
 * search
 */
Route::get('/search', $controllers . 'SearchController@search');
