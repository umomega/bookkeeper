<?php

Route::group(['prefix' => 'profile'], function ()
{

    Route::get('/', [
        'uses' => 'ProfileController@edit',
        'as'   => 'bookkeeper.profile.edit']);
    Route::put('/', [
        'uses' => 'ProfileController@update',
        'as'   => 'bookkeeper.profile.update']);

    Route::get('password', [
        'uses' => 'ProfileController@password',
        'as'   => 'bookkeeper.profile.password']);
    Route::put('password', [
        'uses' => 'ProfileController@updatePassword',
        'as'   => 'bookkeeper.profile.password.post']);

});