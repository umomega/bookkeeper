<?php

Route::resource('transactions', 'TransactionsController', ['except' => ['show', 'create'], 'names' => [
    'index'   => 'bookkeeper.transactions.index',
    'store'   => 'bookkeeper.transactions.store',
    'edit'    => 'bookkeeper.transactions.edit',
    'update'  => 'bookkeeper.transactions.update',
    'destroy' => 'bookkeeper.transactions.destroy',
]]);
