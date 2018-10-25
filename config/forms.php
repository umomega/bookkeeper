<?php

return [
    'users' => [
        'create' => [
            'email' => ['type' => 'email', 'hint' => 'email'],
            'first_name' => ['type' => 'text'],
            'last_name' => ['type' => 'text'],
            'password' => ['type' => 'password'],
            'password_confirmation' => ['type' => 'password']
        ]
    ]
];
