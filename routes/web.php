<?php

use Illuminate\Support\Facades\Route;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'zip-code'], function () {
        Route::get('/{zipCode}', 'ZipCodeController@zipCode');
        Route::get('/id/{id}', 'ZipCodeController@show');
    });
    Route::group(['prefix' => 'county'], function () {
        Route::get('/{id}', 'CountyController@show');
        Route::get('', 'CountyController@search');
    });
    Route::group(['prefix' => 'district'], function () {
        Route::get('/{id}', 'DistrictController@show');
        Route::get('', 'DistrictController@search');
    });
});
