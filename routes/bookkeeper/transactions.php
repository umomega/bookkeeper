<?php

Route::resource('transactions', 'TransactionsController', ['except' => ['show'], 'names' => [
    'index'   => 'bookkeeper.transactions.index',
    'create'  => 'bookkeeper.transactions.create',
    'store'   => 'bookkeeper.transactions.store',
    'edit'    => 'bookkeeper.transactions.edit',
    'update'  => 'bookkeeper.transactions.update',
    'destroy' => 'bookkeeper.transactions.destroy',
]]);

Route::get('transactions/{id}/repeat', [
    'uses' => 'TransactionsController@repeat',
    'as' => 'bookkeeper.transactions.repeat']);

Route::get('transactions/{id}/invoice', [
    'uses' => 'TransactionsController@downloadInvoice',
    'as' => 'bookkeeper.transactions.invoice.download']);

Route::delete('transactions/{id}/invoice', [
    'uses' => 'TransactionsController@deleteInvoice',
    'as' => 'bookkeeper.transactions.invoice.delete']);
