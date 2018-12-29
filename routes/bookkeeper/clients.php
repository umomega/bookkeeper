<?php

Route::resource('clients', 'ClientsController', ['names' => [
    'index'   => 'bookkeeper.clients.index',
    'show'    => 'bookkeeper.clients.show',
    'store'   => 'bookkeeper.clients.store',
    'create'   => 'bookkeeper.clients.create',
    'edit'    => 'bookkeeper.clients.edit',
    'update'  => 'bookkeeper.clients.update',
    'destroy' => 'bookkeeper.clients.destroy',
]]);

Route::get('clients/export', [
    'as' => 'bookkeeper.clients.export',
    'uses' => 'ClientsController@export']);
