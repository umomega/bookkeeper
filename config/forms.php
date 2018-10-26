<?php

return [
    'users' => [
        'create' => [
            'email' => ['type' => 'email', 'hint' => 'email'],
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text'],
            'password' => ['type' => 'password', 'hint' => 'password', 'meter' => true],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation']
        ],
        'edit' => [
            'email' => ['type' => 'email', 'hint' => 'email'],
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text']
        ],
        'password' => [
            'password' => ['type' => 'password', 'hint' => 'password', 'meter' => true],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation']
        ]
    ],
    'settings' => [
        'edit' => [
            'APP_LOCALE' => ['type' => 'select', 'choices' => Bookkeeper\Support\Install\InstallHelper::$locales, 'label' => 'validation.attributes.locale'],
            'DEFAULT_CURRENCY' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(), 'label' => 'currencies.default_currency']
        ]
    ]
];
