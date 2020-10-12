<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        if (!$token) {
            $res['success'] = false;
            $res['message'] = 'Token not found, please login!';

            return response($res, 401);
        }

        try {
            JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            $res['success'] = false;
            $res['message'] = 'Expired token';

            return response($res, 401);
        } catch (Exception $e) {
            $res['success'] = false;
            $res['message'] = $e->getMessage();

            return response($res, 400);
        }

        if ($this->auth->guard($guard)->guest()) {
            $res['success'] = false;
            $res['message'] = 'Invalid token';

            return response($res, 401);
        }

        if ($this->getRole() !== $request->user()->role) {
            $res['success'] = false;
            $res['message'] = 'Invalid user';

            return response($res, 401);
        }

        return $next($request);
    }

    protected function getRole()
    {
        return User::ROLE_CLIENT;
    }
}
