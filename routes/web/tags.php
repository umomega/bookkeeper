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

Route::post('tags/search', [
    'uses' => 'TagsController@searchJson',
    'as'   => 'bookkeeper.tags.search.json']);
