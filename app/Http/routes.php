<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


Route::get('/', function () {
    return view('layout');
});

/**
 * Respond to the incoming access token requests.
 */
Route::post('oauth/access_token', function(Request $request) {
    return Response::json(Authorizer::issueAccessToken());
});

/**
 * Grouped routes on OAuth
 */
Route::group(['middleware' => 'oauth'], function() {

    Route::resource('apps', 'ApplicationController', ['except' => ['create', 'edit']]);

    Route::resource('apps.versions', 'ApplicationVersionController', ['except' => ['create', 'edit']]);
    Route::resource('apps.versions.files', 'FileController', ['except' => ['create', 'edit', 'update']]);
});