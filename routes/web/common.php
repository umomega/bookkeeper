<?php

// Installation complete
Route::get('install/complete', [
    'as' => 'install-complete',
    'uses' => 'InstallController@getComplete',
    'middleware' => ['set-theme:' . config('themes.active_install')]]);
