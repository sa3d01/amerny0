<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckApiToken;

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
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: form-data; charset=UTF-8");
header('Access-Control-Max-Age: 1000');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1'], function () {
    Route::post('user/login', 'Api\UserController@login');
    Route::post('user/resend_code', 'Api\UserController@resend_code');

    Route::post('user/activate', 'Api\UserController@activate')->middleware(CheckApiToken::class);
    Route::post('user/update', 'Api\UserController@update_profile')->middleware(CheckApiToken::class);
    Route::post('user/save_place', 'Api\UserController@save_place')->middleware(CheckApiToken::class);
    Route::get('user/{id}', 'Api\UserController@show')->middleware(CheckApiToken::class);

    Route::get('shift', 'Api\OrderController@shifts');

    Route::get('category/{id}/services', 'Api\CategoryController@services');
    Route::post('category/{id}/search', 'Api\CategoryController@search');
    Route::resource('category', 'Api\CategoryController');

    Route::get('setting', 'Api\SettingController@setting');

});
