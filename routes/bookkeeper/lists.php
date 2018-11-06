<?php

Route::resource('lists', 'ListsController', ['names' => [
    'index'   => 'bookkeeper.lists.index',
    'show'    => 'bookkeeper.lists.show',
    'create'  => 'bookkeeper.lists.create',
    'store'   => 'bookkeeper.lists.store',
    'edit'    => 'bookkeeper.lists.edit',
    'update'  => 'bookkeeper.lists.update',
    'destroy' => 'bookkeeper.lists.destroy',
]]);
