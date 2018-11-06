<?php

Route::get('settings', [
    'as' => 'bookkeeper.settings.edit',
    'uses' => 'SettingsController@edit'
]);

Route::put('settings', [
    'as' => 'bookkeeper.settings.update',
    'uses' => 'SettingsController@update'
]);

Route::get('settings/flush', [
    'as' => 'bookkeeper.settings.flush',
    'uses' => 'SettingsController@flush']);
