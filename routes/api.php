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

Route::get('film/find/{title}', 'FilmController@find');

Route::get('film/', 'FilmController@index');
Route::get('film/{film}', 'FilmController@show');
Route::delete('film/{film}', 'FilmController@delete');
Route::put('film/{film}', 'FilmController@update');
Route::post('film/', 'FilmController@created');
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});