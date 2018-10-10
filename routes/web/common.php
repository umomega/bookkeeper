<?php

// Installation complete
Route::get('install/complete', [
    'as' => 'install-complete',
    'uses' => 'InstallController@getComplete',
]);
