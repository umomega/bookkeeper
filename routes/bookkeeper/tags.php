<?php

Route::resource('tags', 'TagsController', ['names' => [
    'index'   => 'bookkeeper.tags.index',
    'show'    => 'bookkeeper.tags.show',
    'create'  => 'bookkeeper.tags.create',
    'store'   => 'bookkeeper.tags.store',
    'edit'    => 'bookkeeper.tags.edit',
    'update'  => 'bookkeeper.tags.update',
    'destroy' => 'bookkeeper.tags.destroy',
]]);

Route::get('tags/{id}/transactions', [
    'uses' => 'TagsController@transactions',
    'as' => 'bookkeeper.tags.transactions']);

Route::post('tags/search', [
    'uses' => 'TagsController@searchJson',
    'as'   => 'bookkeeper.tags.search.json']);

Route::put('tags/{id}/transactions/{transaction}', [
    'uses' => 'TagsController@associateTransaction',
    'as'   => 'bookkeeper.tags.transactions.associate']);
Route::delete('tags/{id}/transactions/{transaction}', [
    'uses' => 'TagsController@dissociateTransaction',
    'as'   => 'bookkeeper.tags.transactions.dissociate']);

Route::get('tags/{id}/export', [
    'as' => 'bookkeeper.tags.export',
    'uses' => 'TagsController@export']);
