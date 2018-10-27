<?php

Route::resource('users', 'UsersController', ['except' => ['show'], 'names' => [
    'index'   => 'bookkeeper.users.index',
    'create'  => 'bookkeeper.users.create',
    'store'   => 'bookkeeper.users.store',
    'edit'    => 'bookkeeper.users.edit',
    'update'  => 'bookkeeper.users.update',
    'destroy' => 'bookkeeper.users.destroy',
]]);

Route::get('users/{id}/password', [
    'uses' => 'UsersController@password',
    'as'   => 'bookkeeper.users.password']);
Route::put('users/{id}/password', [
    'uses' => 'UsersController@updatePassword',
    'as'   => 'bookkeeper.users.password.put']);
