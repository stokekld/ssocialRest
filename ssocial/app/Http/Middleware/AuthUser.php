<?php

namespace App\Http\Middleware;

use Closure;
use Core\User;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization']))
            throw new \Exception("Error de Authorization", 1);

        $token = $headers['Authorization'];

        $user = User\UserFromToken::getUser($token);

        var_dump($user);

        $tokenRefresh = User\AuthUser::verify($user);

        if (!$tokenRefresh)
            throw new \Exception("Error de Authorization", 1);
        // return response()->json(compact("verify"));
        return $next($request);
    }
}
