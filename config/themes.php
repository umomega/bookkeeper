<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Switch this package on/off. Useful for testing...
    |--------------------------------------------------------------------------
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | File path where themes will be located.
    | Can be outside default views path EG: resources/themes
    | Leave it null if you place your themes in the default views folder
    | (as defined in config\views.php)
    |--------------------------------------------------------------------------
    */

    'themes_path' => null, // eg: realpath(base_path('resources/themes'))

    /*
    |--------------------------------------------------------------------------
    | Set behavior if an asset is not found in a Theme hierarcy.
    | Available options: THROW_EXCEPTION | LOG_ERROR | ASSUME_EXISTS | IGNORE
    |--------------------------------------------------------------------------
    */

    'asset_not_found' => 'LOG_ERROR',

    /*
    |--------------------------------------------------------------------------
    | Set the Active Theme. Can be set at runtime with:
    |  Themes::set('theme-name');
    |--------------------------------------------------------------------------
    */

    'active'          => 'bookkeeper',
    'active_install'  => 'install',

    /*
    |--------------------------------------------------------------------------
    | Define available themes. Format:
    |--------------------------------------------------------------------------
    */

    'themes' => [
        'bookkeeper'  => [
            'extends'    => null,
            'views-path' => 'bookkeeper',
            'asset-path' => 'assets/bookkeeper',
        ],
        'install'  => [
            'extends'    => null,
            'views-path' => 'install',
            'asset-path' => 'assets/bookkeeper'
        ]
    ],

];
