<?php

namespace Bookkeeper\Http\Requests;

class ProfileUpdatePassword extends BookkeeperRequest
{
    /* @var string */
    protected $configKey = 'users.password';
}
