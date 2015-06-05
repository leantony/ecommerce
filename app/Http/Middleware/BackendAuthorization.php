<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class BackendAuthorization
{

    /**
     * Handle an incoming request.
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
