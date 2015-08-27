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
use Illuminate\Http\Response;

Route::get('/', function () {
    return view('layout');
});






Route::post('/login', function () {

    $request = [
        'url' => URL::to('/') . '/oauth/access_token',
        'params' => [
            'client_id' => 1,
            'client_secret' => 'secret',
            'grant_type' => 'password',
            'username' => Input::get('username'),
            'password' => Input::get('password'),
        ]
    ];

    $response = HttpClient::post($request);

    $res = json_decode($response->content());

    if(array_key_exists('error', $res)) {
        $statusCode = 403;
    } else {
        $statusCode = 200;
    }

    return (new Response($response->content(), $statusCode))
        ->header('Content-Type', 'application/json');

});


/**
 * Respond to the incoming access token requests.
 */
Route::post('oauth/access_token', function(Request $request) {
    return \Response::json(Authorizer::issueAccessToken());
});

/**
 * Grouped routes on OAuth
 */

Route::get('apps/{applicationId}/versions/{applicationVersionId}/files/{id}/download', function($applicationId, $applicationVersionId, $id){

    if(Authorizer::validateAccessToken(false, Input::get('token'))) {
        $fileRow = \App\File::find($id);
        $file = Storage::disk('local')->get($fileRow->filename);

        return (new Response($file, 200))
            ->header('Content-Type', $fileRow->mime);
    }
});


Route::post('/register', [
    'as' => 'register', 'uses' => 'UserController@store'
]);

Route::group(['middleware' => 'oauth'], function() {

    Route::resource('apps', 'ApplicationController', ['except' => ['create', 'edit']]);

    Route::resource('apps.versions', 'ApplicationVersionController', ['except' => ['create', 'edit']]);

    Route::resource('apps.versions.files', 'FileController', ['except' => ['create', 'edit', 'update']]);
});