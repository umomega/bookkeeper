<?php

// Authentication
Route::get('auth/login', [
    'uses' => 'Auth\AuthController@showLoginForm',
    'as'   => 'bookkeeper.auth.login']);
Route::post('auth/login', [
    'uses' => 'Auth\AuthController@login',
    'as'   => 'bookkeeper.auth.login.post']);
Route::get('auth/logout', [
    'uses' => 'Auth\AuthController@logout',
    'as'   => 'bookkeeper.auth.logout']);

// Password Reset
Route::get('password/email', [
    'uses' => 'Auth\PasswordController@showLinkRequestForm',
    'as'   => 'bookkeeper.password.email']);
Route::post('password/email', [
    'uses' => 'Auth\PasswordController@sendResetLinkEmail',
    'as'   => 'bookkeeper.password.email.post']);

Route::get('password/reset/{token}', [
    'uses' => 'Auth\PasswordController@showResetForm',
    'as'   => 'bookkeeper.password.reset']);
Route::post('password/reset', [
    'uses' => 'Auth\PasswordController@reset',
    'as'   => 'bookkeeper.password.reset.post']);