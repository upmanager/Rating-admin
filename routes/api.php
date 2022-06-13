<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');
Route::get('facilities', 'API\BaseController@facilities');
Route::get('questions', 'API\BaseController@questions');
Route::post('addRating', 'API\BaseController@addRating');
Route::post('upload', 'API\BaseController@upload');

Route::group(['middleware' => 'auth:api'], function () {
});