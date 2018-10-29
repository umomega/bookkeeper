<?php

Route::resource('people', 'PeopleController', ['except' => ['show'], 'names' => [
    'index'   => 'bookkeeper.people.index',
    'create'   => 'bookkeeper.people.create',
    'store'   => 'bookkeeper.people.store',
    'edit'    => 'bookkeeper.people.edit',
    'update'  => 'bookkeeper.people.update',
    'destroy' => 'bookkeeper.people.destroy',
]]);

Route::get('people/{id}/lists', [
    'uses' => 'PeopleController@lists',
    'as'   => 'bookkeeper.people.lists']);
Route::put('people/{id}/lists', [
    'uses' => 'PeopleController@associateList',
    'as'   => 'bookkeeper.people.lists.associate']);
Route::delete('people/{id}/lists/{list}', [
    'uses' => 'PeopleController@dissociateList',
    'as'   => 'bookkeeper.people.lists.dissociate']);

Route::post('people/search', [
    'uses' => 'PeopleController@searchJson',
    'as'   => 'bookkeeper.people.search.json']);
Route::put('people/{id}/clients/{client}', [
    'uses' => 'PeopleController@associateClient',
    'as'   => 'bookkeeper.people.clients.associate']);
Route::delete('people/{id}/clients/{client}', [
    'uses' => 'PeopleController@dissociateClient',
    'as'   => 'bookkeeper.people.clients.dissociate']);
