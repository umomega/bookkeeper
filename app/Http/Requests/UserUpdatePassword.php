<?php

namespace Bookkeeper\Http\Requests;

class UserUpdatePassword extends BookkeeperRequest
{
    /* @var string */
    protected $configKey = 'users.password';
}
