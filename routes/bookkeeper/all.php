<?php

Route::group(['middleware' => [
    'set-theme:' . config('themes.active')
]], function ()
{
    require 'auth.php';
});

require 'common.php';

// Authenticated
Route::group(['middleware' => [
    'auth',
    'set-theme:' . config('themes.active')
]], function ()
{
    require 'accounts.php';
    require 'companies.php';
    require 'jobs.php';
    require 'lists.php';
    require 'overview.php';
    require 'people.php';
    require 'profile.php';
    require 'settings.php';
    require 'tags.php';
    require 'transactions.php';
    require 'update.php';
    require 'users.php';
});
