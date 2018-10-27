<?php

Route::resource('jobs', 'JobsController', ['names' => [
    'index'   => 'bookkeeper.jobs.index',
    'show'    => 'bookkeeper.jobs.show',
    'store'   => 'bookkeeper.jobs.store',
    'create'  => 'bookkeeper.jobs.create',
    'edit'    => 'bookkeeper.jobs.edit',
    'update'  => 'bookkeeper.jobs.update',
    'destroy' => 'bookkeeper.jobs.destroy',
]]);
