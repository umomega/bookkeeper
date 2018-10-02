<?php

Route::group([
    'prefix' => 'install',
    'middleware' => ['set-theme:' . config('themes.active_install')]
], function ()
{

    Route::get('welcome', [
        'as' => 'install-welcome',
        'uses' => 'InstallController@getWelcome'
    ]);

    Route::post('welcome', [
        'as' => 'install-welcome-post',
        'uses' => 'InstallController@postWelcome'
    ]);

    Route::get('database', [
        'as' => 'install-database',
        'uses' => 'InstallController@getDatabase'
    ]);

    Route::post('database', [
        'as' => 'install-database-post',
        'uses' => 'InstallController@postDatabase'
    ]);

    Route::get('user', [
        'as' => 'install-user',
        'uses' => 'InstallController@getUser'
    ]);

    Route::post('user', [
        'as' => 'install-user-post',
        'uses' => 'InstallerController@postUser'
    ]);

    Route::get('settings', [
        'as' => 'install-settings',
        'uses' => 'InstallerController@getSettings'
    ]);

    Route::post('settings', [
        'as' => 'install-settings-post',
        'uses' => 'InstallerController@postSettings'
    ]);

});
