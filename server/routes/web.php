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

/**
 * auth
 */
Route::view('/', 'auth.auth', ['form' => '']);
Route::view('/signup', 'auth.auth', ['form' => 'signup']);
Route::view('/login', 'auth.auth', ['form' => 'login']);
