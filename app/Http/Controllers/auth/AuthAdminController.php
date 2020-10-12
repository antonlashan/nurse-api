<?php

/**
 * Description of AuthAdminController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;

class AuthAdminController extends AuthController
{
    protected function getRole()
    {
        return User::ROLE_ADMIN;
    }

    /**
     * Admin user Authenticate.
     *
     * @bodyParam email email required Email address
     * @bodyParam password string required Password
     *
     * @response {
     *  "success": true,
     *  "message": "Token retrieved successfully",
     *  "data": {
     *     "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *  }
     * }
     * @response 400 {
     *  "success": false,
     *  "message": "Email does not exist.",
     *  "data": null
     * }
     *
     * @group Auth
     */
    public function authenticate(Request $request)
    {
        return parent::authenticate($request);
    }

    /**
     * Admin user deauthenticate.
     *
     * @param Request $request
     *
     * @group Auth
     */
    public function deauthenticate(Request $request)
    {
        return parent::deauthenticate($request);
    }
}
