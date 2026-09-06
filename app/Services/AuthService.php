<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function register(array $data)
    {
        return User::create($data);
    }
}