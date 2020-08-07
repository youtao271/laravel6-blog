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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts/{page?}', 'Api\BlogController@index')->name('api.posts');
Route::get('/post/{id}', 'Api\BlogController@post')->name('api.post');
/* Route::get('/posts', function(){
    return 123;
}); */
