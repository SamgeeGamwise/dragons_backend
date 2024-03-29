<?php

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

Route::get('/test', 'ChatController@test');

Route::group([
    'middleware' =>  ['api'],
    'prefix' => 'user'
], function () {
    Route::post('register', 'UserController@register');

    Route::group([
        'middleware' => ['jwt.verify'],
    ], function () {
        Route::get('/', 'UserController@profile');
        Route::put('password', 'UserController@updatePassword');
        Route::put('profile', 'UserController@updateProfile');
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
    'middleware' => ['api'],
    'prefix' => 'spells'
], function () {
    Route::get('/', 'SpellsController@search');
    Route::post('/', 'SpellsController@addSpell');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'character'
], function () {
    Route::get('/', 'CharacterController@all');
    Route::get('/{id}', 'CharacterController@getById');

    Route::post('/', 'CharacterController@create');

    Route::delete('/', 'CharacterController@deleteCharacter');

    Route::put('/abilities', 'CharacterController@updateAbilities');
    Route::put('/summary', 'CharacterController@updateSummary');
    Route::put('/summary/hp', 'CharacterController@updateHP');
    Route::put('/summary/ac', 'CharacterController@updateAC');
    Route::put('/summary/base-attack', 'CharacterController@updateBaseAttack');
    Route::put('/summary/grapple', 'CharacterController@updateGrapple');
    Route::put('/summary/initiative', 'CharacterController@updateInitiative');
    Route::put('/saving-throws', 'CharacterController@updateSavingThrows');

    Route::post('/skills', 'SkillController@addSkill');
    Route::put('/skills', 'SkillController@updateSkills');
    Route::delete('/skills', 'SkillController@deleteSkills');

    Route::post('/weapons', 'WeaponController@addWeapon');
    Route::put('/weapons', 'WeaponController@updateWeapon');
    Route::delete('/weapons', 'WeaponController@deleteWeapon');

    Route::post('/armor', 'ArmorController@addArmor');
    Route::put('/armor', 'ArmorController@updateArmor');
    Route::delete('/armor', 'ArmorController@deleteArmor');

    Route::post('/notes/section', 'NoteController@addSection');
    Route::post('/notes/note', 'NoteController@addNote');
    Route::put('/notes', 'NoteController@updateNoteAndSection');
    Route::delete('/notes/section', 'NoteController@deleteSection');
    Route::delete('/notes/note', 'NoteController@deleteNote');
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'campaign'
], function () {
    Route::get('/', 'CampaignController@all');
    Route::post('/', 'CampaignController@addCampaign');
    Route::post('/join', 'CampaignController@joinCampaign');
    Route::put('/', 'CampaignController@updateCampaign');
    Route::delete('/', 'CampaignController@deleteCampaign');
});
