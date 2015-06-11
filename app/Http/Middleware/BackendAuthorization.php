<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class BackendAuthorization
{

    /**
     * This middleware checks that the user accessing the backend has at least one of the roles specified
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if the user can access the backend
        if ($request->user()->canAccessBackend()) {
            return $next($request);
        }
        return new Response("Error code: 401 => You are not authorized to view this page. Contact the system administrator", 401);
    }

}
