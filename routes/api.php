<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return response()->json(['message' => 'Invalid Character!'], 401);
});


Route::group([
    'middleware' =>  ['api'],
    'prefix' => 'user'
], function ($router) {
    Route::post('register', 'UserController@register');

    Route::group([
        'middleware' => ['jwt.verify'],
    ], function () {
        Route::get('/', 'UserController@profile');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'character'
], function () {
    Route::get('/', 'CharacterController@all');
    Route::get('/{id}', 'CharacterController@getById');

    Route::post('/', 'CharacterController@create');
    Route::post('/skills', 'CharacterController@addSkill');

    Route::put('/abilities', 'CharacterController@updateAbilities');
    Route::put('/skills', 'CharacterController@updateSkills');
    Route::put('/summary', 'CharacterController@updateSummary');
    Route::put('/saving-throws', 'CharacterController@updateSavingThrows');

    Route::delete('/skills', 'CharacterController@deleteSkills');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'campaign'
], function () {
    Route::get('/', 'CampaignController@all');
});
