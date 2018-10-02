<?php

Route::get('/', [
    'as' => 'bookkeeper.overview',
    'uses' => 'OverviewController@index'
]);