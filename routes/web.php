<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => [
    'set-theme:' . config('themes.active')
]], function ()
{
    require 'web/auth.php';
});

require 'web/common.php';

// Authenticated
Route::group(['middleware' => [
    'auth',
    'set-theme:' . config('themes.active')
]], function ()
{
    //require 'web/accounts.php';
    //require 'web/clients.php';
    //require 'web/jobs.php';
    //require 'web/lists.php';
    require 'web/overview.php';
    //require 'web/people.php';
    //require 'web/profile.php';
    //require 'web/settings.php';
    //require 'web/tags.php';
    //require 'web/transactions.php';
    //require 'web/update.php';
    //require 'web/users.php';
});
