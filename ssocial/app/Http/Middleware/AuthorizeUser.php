<?php

namespace App\Http\Middleware;

use Closure;
use Core\Exception\RestException;

class AuthorizeUser
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
        $numArgs = func_num_args();
        $types = array();

        for ($i=2; $i < $numArgs ; $i++)
        {
            array_push($types, func_get_arg($i));
        }
        
        $userSys = \App::make('UserSys');

        $search = array_search($userSys -> type, $types);

        if ( !is_int($search) )
            throw new RestException(__FILE__, "Sin autorización.", 403, ['message' => 'Sin autorización.']);

        return $next($request);
    }
}
