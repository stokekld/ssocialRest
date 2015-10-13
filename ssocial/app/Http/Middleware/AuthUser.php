<?php

namespace App\Http\Middleware;

use Closure;
use Core\User\Auth;
use Core\Exception;

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
            throw new Exception\RestException(__FILE__, "Falta token de autorización.", 401, ['message' => 'Falta token de autorización.']);

        $token = $headers['Authorization'];

        $user = Auth\UserFromToken::getUser($token);

        if (!$user)
            throw new Exception\RestException(__FILE__, "Token no válido.", 401, ["message" => "Token no válido."]);

        $tokenRefresh = Auth\AuthUser::verify($user);

        if (!$tokenRefresh)
            throw new Exception\RestException(__FILE__, "Token obsoleto.", 401, ["message" => "Token obsoleto."]);


        $userSys = \App::make('UserSys');
        $userSys -> load($user);
        $userSys -> token = $tokenRefresh;

        return $next($request);
    }
}
