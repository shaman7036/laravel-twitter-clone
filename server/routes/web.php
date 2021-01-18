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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /**
     * auth
     */
    Route::view('/', 'auth.auth', ['form' => '']);
    Route::view('/signup', 'auth.auth', ['form' => 'signup']);
    Route::view('/login', 'auth.auth', ['form' => 'login']);
    Route::post('/signup', 'AuthController@signUp');
    Route::post('/login', 'AuthController@logIn');
    Route::get('/logout', 'AuthController@logout');

    /**
     * routes with auth id
     */
    Route::group(['middleware' => 'auth_id'], function () {
        /**
         * routes with pagination object
         */
        Route::group(['middleware' => 'pagination'], function () {
            /**
             * navigation
             */
            Route::get('/home/hashtag/{hashtag}', 'HomeController@getTimelineForHashtag');
            Route::get('/home', 'HomeController@getTimeline');
            Route::view('/moments', 'moments');
            Route::view('/notifications', 'notifications');
            Route::view('/messages', 'messages');
            Route::get('/search', 'SearchController@search');
            /**
             * profile
             */
            Route::get('/profile/edit/{username}', 'ProfileController@edit');
            Route::post('/profile/edit/{username}', 'ProfileController@update');
            Route::get('/profile/tweets/{username}', 'ProfileController@getTweets');
            Route::get('/profile/with_replies/{username}', 'ProfileController@getTweets');
            Route::get('/profile/following/{username}', 'ProfileController@getFollowing');
            Route::get('/profile/followers/{username}', 'ProfileController@getFollowers');
            Route::get('/profile/likes/{username}', 'ProfileController@getLikes');
        });
        /**
         * follows
         */
        Route::resource('/follows', 'FollowController', ['only' => ['index', 'store']]);
        /**
         * tweets
         */
        Route::resource('/tweets', 'TweetController', ['only' => ['show', 'store', 'destroy']]);
        /**
         * likes
         */
        Route::resource('/likes', 'LikeController', ['only' => ['index', 'store']]);
        /**
         * retweets
         */
        Route::resource('/retweets', 'RetweetController', ['only' => ['index', 'store']]);
        /**
         * replies
         */
        Route::resource('/replies', 'ReplyController', ['only' => ['index', 'store']]);
        /**
         * pins
         */
        Route::resource('/pins', 'PinController', ['only' => ['store']]);
    });
});
