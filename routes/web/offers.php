<?php

Route::resource('offers', 'OffersController', ['names' => [
    'index'   => 'bookkeeper.offers.index',
    'show'    => 'bookkeeper.offers.show',
    'store'   => 'bookkeeper.offers.store',
    'create'   => 'bookkeeper.offers.create',
    'edit'    => 'bookkeeper.offers.edit',
    'update'  => 'bookkeeper.offers.update',
    'destroy' => 'bookkeeper.offers.destroy',
]]);

Route::get('offers/search', [
    'uses' => 'OffersController@search',
    'as'   => 'bookkeeper.offers.search']);
