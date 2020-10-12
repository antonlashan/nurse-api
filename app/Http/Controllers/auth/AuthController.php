<?php

/**
 * Description of AuthController.
 *
 * @author lashanfernando
 */

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\DashboardImage;
use App\Models\PushNotificationDevice;

const EXPIRE_TIME = 60 * 60;

class AuthController extends Controller
{
    private $expirationTime;

    public function __construct()
    {
        $this->expirationTime = time() + EXPIRE_TIME;
    }

    /**
     * Auth get token.
     *
     * @param \App\User $user
     *
     * @return string
     */
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => 'lumen-jwt', // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
//            'exp' => $this->expirationTime, // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * User Authenticate.
     *
     * @bodyParam email email required Email address
     * @bodyParam password string required Password
     * @bodyParam oauth_provider string required '' or facebook or google.
     * @bodyParam oauth_uid string required Auth ID.
     * @bodyParam type string required Platform (ios or android).
     * @bodyParam device_id string required Device ID.
     *
     * @response {
     *  "success": true,
     *  "message": "Token retrieved successfully",
     *  "data": {
     *     "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
     *     "dashboard_img": "http://api.icm.lk/thumb/w2000/images/dashboard/232323.jpg"
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
        $this->validate($request, [
            'email' => 'required_if:oauth_provider,|email',
            'password' => 'required_if:oauth_provider,',
            'oauth_provider' => 'required_if:password,',
            'oauth_uid' => 'required_if:password,',
            'type' => 'required|in:ios,android,web',
            'device_id' => 'required',
        ]);
        $provider = $request->input('oauth_provider');
        if ($provider) {
            // Find the user by provider
            $user = User::where('oauth_provider', $provider)
                    ->where('oauth_uid', $request->input('oauth_uid'))
                    ->first();

            if (!$user) {
                return $this->responseBadRequest('Provider does not exist.');
            }

            if (!$user->is_active) {
                $res['success'] = false;
                $res['message'] = 'User not active';

                return response($res, 423);
            }

            return $this->updateToken($user, $request);
        } else {
            // Find the user by email
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return $this->responseBadRequest('Email does not exist.');
            }

            if (!$user->is_active) {
                $res['success'] = false;
                $res['message'] = 'User not active';

                return response($res, 423);
            }

            // Verify the password and generate the token
            if (Hash::check($request->input('password'), $user->password)) {
                return $this->updateToken($user, $request);
            }
        }

        // Bad Request response
        return $this->responseBadRequest('Email or password is wrong.');
    }

    protected function getRole()
    {
        return User::ROLE_CLIENT;
    }

    private function updateToken($user, $request)
    {
        if ($user->role !== $this->getRole()) {
            return $this->responseBadRequest('Invalid user');
        }

        $token = $this->jwt($user);
        $user->api_key = $token;
        $user->save();

        $res = ['token' => $token];
        $res['dashboard_img'] = null;
        $dashImg = DashboardImage::first();
        if ($dashImg) {
            $res['dashboard_img'] = $dashImg->image;
        }

        $this->addDevice($request, $user->id);

        return $this->responseSuccess($res, 'Token retrieved successfully');
    }

    private function addDevice(Request $request, $userId)
    {
        $type = $request->input('type');
        $deviceId = $request->input('device_id');

        $device = PushNotificationDevice::where('token', $deviceId)->first();
        if (!$device) {
            $device = new PushNotificationDevice();
            $device->type = $type;
            $device->token = $deviceId;
            $device->user_id = $userId;
            $device->save();
        }
    }

    /**
     * User deauthenticate.
     *
     * @param Request $request
     *
     * @group Auth
     */
    public function deauthenticate(Request $request)
    {
        $user = User::where('api_key', $request->user()->api_key)->first();

        if ($user) {
            $user->api_key = null;
            $user->save();

            return $this->responseSuccess(null, 'Logout successfully');
        }
        // Bad Request response
        return $this->responseBadRequest('Cannot find token.');
    }
}
