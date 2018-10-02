<?php

// Authentication
Route::get('auth/login', [
    'uses' => 'Auth\LoginController@showLoginForm',
    'as'   => 'bookkeeper.auth.login']);
Route::post('auth/login', [
    'uses' => 'Auth\LoginController@login',
    'as'   => 'bookkeeper.auth.login.post']);
Route::get('auth/logout', [
    'uses' => 'Auth\LoginController@logout',
    'as'   => 'bookkeeper.auth.logout']);

// Password Reset
Route::get('password/email', [
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm',
    'as'   => 'bookkeeper.password.email']);
Route::post('password/email', [
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
    'as'   => 'bookkeeper.password.email.post']);

Route::get('password/reset/{token}', [
    'uses' => 'Auth\ResetPasswordController@showResetForm',
    'as'   => 'bookkeeper.password.reset']);
Route::post('password/reset', [
    'uses' => 'Auth\ResetPasswordController@reset',
    'as'   => 'bookkeeper.password.reset.post']);
