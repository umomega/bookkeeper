<?php

return [
    'accounts' => [
        'create' => [
            'name' => ['type' => 'text'],
            'currency' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies()],
            'balance' => ['type' => 'amount'],
            'default' => ['type' => 'checkbox'],
            'notes' => ['type' => 'textarea'],
        ],
        'edit' => [
            'name' => ['type' => 'text'],
            'currency' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies()],
            'default' => ['type' => 'checkbox'],
            'notes' => ['type' => 'textarea'],
        ]
    ],
    'clients' => [
        'create' => [
            'name' => ['type' => 'text'],
            'tax_administration' => ['type' => 'text'],
            'tax_number' => ['type' => 'text'],
            'email' => ['type' => 'email'],
            'tel' => ['type' => 'text'],
            'fax' => ['type' => 'text'],
            'address' => ['type' => 'textarea'],
            'notes' => ['type' => 'textarea']
        ]
    ],
    'jobs' => [
        'create' => [
            'name' => ['type' => 'text'],
            'notes' => ['type' => 'textarea']
        ]
    ],
    'lists' => [
        'create' => [
            'name' => ['type' => 'text'],
            'notes' => ['type' => 'textarea']
        ]
    ],
    'people' => [
        'create' => [
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text'],
            'company' => ['type' => 'text'],
            'job_title' => ['type' => 'text'],
            'nationality' => ['type' => 'text'],
            'national_id' => ['type' => 'text'],
            'section_contact' => ['type' => 'separator', 'label' => 'people.contact_info'],
            'email' => ['type' => 'email'],
            'tel' => ['type' => 'text'],
            'tel_mobile' => ['type' => 'text'],
            'fax' => ['type' => 'text'],
            'section_address' => ['type' => 'separator', 'label' => 'people.address_info'],
            'address' => ['type' => 'textarea'],
            'city' => ['type' => 'text'],
            'state' => ['type' => 'text'],
            'country' => ['type' => 'text'],
            'postal_code' => ['type' => 'text'],
            'section_additional' => ['type' => 'separator', 'label' => 'people.additional_info'],
            'notes' => ['type' => 'textarea'],
        ]
    ],
    'settings' => [
        'edit' => [
            'APP_LOCALE' => ['type' => 'select', 'choices' => Bookkeeper\Support\Install\InstallHelper::$locales, 'label' => 'validation.attributes.locale'],
            'DEFAULT_CURRENCY' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(), 'label' => 'currencies.default_currency']
        ]
    ],
    'tags' => [
        'create' => [
            'name' => ['type' => 'text']
        ]
    ],
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
    ]
];
