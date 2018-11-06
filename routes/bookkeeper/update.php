<?php

Route::group([
    'prefix' => 'update'
], function ()
{

    Route::get('/', [
        'uses' => 'UpdateController@index',
        'as' => 'bookkeeper.update.index']);

    Route::get('start', [
        'uses' => 'UpdateController@start',
        'as' => 'bookkeeper.update.start']);

    Route::post('download', [
        'as' => 'bookkeeper.update.download',
        'uses' => 'UpdateController@download']);

    Route::post('extract', [
        'as' => 'bookkeeper.update.extract',
        'uses' => 'UpdateController@extract']);

    Route::post('empty', [
        'as' => 'bookkeeper.update.empty',
        'uses' => 'UpdateController@emptyTrash'
    ]);

    Route::post('move/vendor', [
        'as' => 'bookkeeper.update.move.vendor',
        'uses' => 'UpdateController@moveVendor']);

    Route::post('move', [
        'as' => 'bookkeeper.update.move',
        'uses' => 'UpdateController@move']);

    Route::post('finalize', [
        'as' => 'bookkeeper.update.finalize',
        'uses' => 'UpdateController@finalize']);

});