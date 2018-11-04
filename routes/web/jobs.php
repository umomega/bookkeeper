<?php

Route::prefix('clients/{client}')->group(function() {
    Route::resource('jobs', 'JobsController', ['except' => ['index'], 'names' => [
        'show'    => 'bookkeeper.jobs.show',
        'store'   => 'bookkeeper.jobs.store',
        'create'  => 'bookkeeper.jobs.create',
        'edit'    => 'bookkeeper.jobs.edit',
        'update'  => 'bookkeeper.jobs.update',
        'destroy' => 'bookkeeper.jobs.destroy',
    ]]);
});

Route::post('jobs/search', [
    'uses' => 'JobsController@searchJson',
    'as'   => 'bookkeeper.jobs.search.json']);
