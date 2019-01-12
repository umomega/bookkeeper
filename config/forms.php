<?php

return [
    'accounts' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255|unique:accounts,name'],
            'currency' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(), 'default' => env('DEFAULT_CURRENCY'), 'rules' => 'required'],
            'balance' => ['type' => 'amount', 'rules' => 'required|integer'],
            'default' => ['type' => 'checkbox', 'rules' => 'required|integer'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
        ],
        'edit' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255|unique:accounts,name,[!ROUTE>account!]'],
            'currency' => ['type' => 'select', 'choices' => Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(), 'rules' => 'required'],
            'default' => ['type' => 'checkbox', 'rules' => 'required'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
        ]
    ],
    'clients' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'tax_administration' => ['type' => 'text', 'rules' => 'max:64'],
            'tax_number' => ['type' => 'text', 'rules' => 'max:64'],
            'email' => ['type' => 'email', 'rules' => 'nullable|email|max:255'],
            'tel' => ['type' => 'text', 'rules' => 'max:64'],
            'fax' => ['type' => 'text', 'rules' => 'max:64'],
            'address' => ['type' => 'textarea', 'rules' => 'max:65535'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535']
        ]
    ],
    'jobs' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'offer' => ['type' => 'file','rules' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
            'client_id' => ['type' => 'hidden', 'rules' => 'required|integer']
        ],
        'edit' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'offer' => ['type' => 'file','rules' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535']
        ]
    ],
    'lists' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535']
        ]
    ],
    'people' => [
        'create' => [
            'first_name' => ['type' => 'text', 'rules' => 'required|max:64'],
            'last_name' => ['type' => 'text', 'rules' => 'max:64'],
            'company' => ['type' => 'text', 'rules' => 'max:128'],
            'job_title' => ['type' => 'text', 'rules' => 'max:64'],
            'nationality' => ['type' => 'text', 'rules' => 'max:32'],
            'national_id' => ['type' => 'text', 'rules' => 'max:32'],
            'section_contact' => ['type' => 'separator', 'label' => 'people.contact_info'],
            'email' => ['type' => 'email', 'rules' => 'nullable|email|max:255'],
            'tel' => ['type' => 'text', 'rules' => 'max:64'],
            'tel_mobile' => ['type' => 'text', 'rules' => 'max:64'],
            'fax' => ['type' => 'text', 'rules' => 'max:64'],
            'section_address' => ['type' => 'separator', 'label' => 'people.address_info'],
            'address' => ['type' => 'textarea', 'rules' => 'max:255'],
            'city' => ['type' => 'text', 'rules' => 'max:64'],
            'state' => ['type' => 'text', 'rules' => 'max:64'],
            'country' => ['type' => 'text', 'rules' => 'max:64'],
            'postal_code' => ['type' => 'text', 'rules' => 'max:16'],
            'section_additional' => ['type' => 'separator', 'label' => 'people.additional_info'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
        ]
    ],
    'profile' => [
        'edit' => [
            'email' => ['rules' => 'required|email|max:255|unique:users,email,[!AUTH!]'],
            'first_name' => ['rules' => 'required|max:50'],
            'last_name' => ['rules' => 'required|max:50']
        ]
    ],
    'settings' => [
        'edit' => [
            'APP_LOCALE' => ['type' => 'select', 'choices' => \Bookkeeper\Support\Install\InstallHelper::$locales, 'label' => 'validation.attributes.locale', 'rules' => 'required|in:' . \Bookkeeper\Support\Install\InstallHelper::$localesImploded],
            'DEFAULT_VAT' => ['type' => 'number', 'label' => 'settings.default_vat_percentage', 'icon' => 'percentage', 'rules' => 'required|numeric'],
            'DEFAULT_CURRENCY' => ['type' => 'select', 'choices' => \Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(), 'label' => 'currencies.default_currency', 'rules' => 'required|in:' . \Bookkeeper\Support\Currencies\CurrencyHelper::currenciesImploded()]
        ]
    ],
    'tags' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255|unique:tags,name']
        ],
        'edit' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255|unique:tags,name,[!ROUTE>tag!]']
        ]
    ],
    'transactions' => [
        'create' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'type' => ['type' => 'select', 'choices' => [], 'rules' => 'required|in:income,expense'],
            'amount' => ['type' => 'amount', 'rules' => 'required|integer'],
            'vat_percentage' => ['type' => 'number', 'icon' => 'percentage', 'default' => env('DEFAULT_VAT'), 'rules' => 'required|numeric'],
            'account_id' => ['type' => 'select', 'choices' => [], 'label' => 'accounts.self', 'rules' => 'required|integer'],
            'job_id' => ['type' => 'relation', 'search' => 'bookkeeper.jobs.search.json', 'relation_key' => 'job', 'label' => 'jobs.self', 'rules' => 'nullable|integer'],
            'created_at' => ['type' => 'datetime', 'label' => 'validation.attributes.billing_date', 'rules' => 'required|date'],
            'received_at' => ['type' => 'datetime', 'label' => 'validation.attributes.received_date', 'rules' => 'required|date'],
            'received' => ['type' => 'checkbox', 'checked' => true, 'rules' => 'required|boolean'],
            'excluded' => ['type' => 'checkbox', 'rules' => 'required|boolean'],
            'invoice' => ['type' => 'file', 'rules' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
            'tags' => ['type' => 'hidden']
        ],
        'edit' => [
            'name' => ['type' => 'text', 'rules' => 'required|max:255'],
            'type' => ['type' => 'select', 'choices' => [], 'rules' => 'required|in:income,expense'],
            'amount' => ['type' => 'amount', 'rules' => 'required|integer'],
            'vat_percentage' => ['type' => 'number', 'icon' => 'percentage', 'rules' => 'required|numeric'],
            'account_id' => ['type' => 'select', 'choices' => [], 'label' => 'accounts.self', 'rules' => 'required|integer'],
            'job_id' => ['type' => 'relation', 'search' => 'bookkeeper.jobs.search.json', 'relation_key' => 'job', 'label' => 'jobs.self', 'rules' => 'nullable|integer'],
            'created_at' => ['type' => 'datetime', 'label' => 'validation.attributes.billing_date', 'rules' => 'required|date'],
            'received_at' => ['type' => 'datetime', 'label' => 'validation.attributes.received_date', 'rules' => 'required|date'],
            'received' => ['type' => 'checkbox', 'rules' => 'required|boolean'],
            'excluded' => ['type' => 'checkbox', 'rules' => 'required|boolean'],
            'invoice' => ['type' => 'file', 'rules' => 'nullable|file|mimes:jpeg,png,gif,bmp,pdf,doc,docx'],
            'notes' => ['type' => 'textarea', 'rules' => 'max:65535'],
        ]
    ],
    'users' => [
        'create' => [
            'email' => ['type' => 'email', 'hint' => 'email', 'rules' => 'required|email|max:255|unique:users,email'],
            'first_name' => ['type' => 'text', 'rules' => 'required|max:50'],
            'last_name' => ['type' => 'text', 'rules' => 'required|max:50'],
            'password' => ['type' => 'password', 'hint' => 'password', 'meter' => true, 'rules' => 'required|min:8'],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation', 'rules' => 'required|min:8|same:password']
        ],
        'edit' => [
            'email' => ['type' => 'email', 'hint' => 'email', 'rules' =>  'required|email|max:255|unique:users,email,[!ROUTE>user!]'],
            'first_name' => ['type' => 'text', 'rules' => 'required|max:50'],
            'last_name' => ['type' => 'text', 'rules' => 'required|max:50']
        ],
        'password' => [
            'password' => ['type' => 'password', 'hint' => 'password', 'meter' => true, 'rules' => 'required|min:8'],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation', 'rules' => 'required|min:8|same:password']
        ]
    ]
];
