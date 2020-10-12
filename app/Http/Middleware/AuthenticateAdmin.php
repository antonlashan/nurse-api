<?php

/**
 * Description of AuthenticateAdmin.
 *
 * @author lashanfernando
 */

namespace App\Http\Middleware;

use App\Models\User;

class AuthenticateAdmin extends Authenticate
{
    protected function getRole()
    {
        return User::ROLE_ADMIN;
    }
}
