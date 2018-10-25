<?php

return [
    'users' => [
        'create' => [
            'email' => ['type' => 'email', 'hint' => 'email'],
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text'],
            'password' => ['type' => 'password', 'hint' => 'password'],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation']
        ],
        'edit' => [
            'email' => ['type' => 'email', 'hint' => 'email'],
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text']
        ],
        'password' => [
            'password' => ['type' => 'password', 'hint' => 'password'],
            'password_confirmation' => ['type' => 'password', 'hint' => 'password_confirmation']
        ]
    ]
];
