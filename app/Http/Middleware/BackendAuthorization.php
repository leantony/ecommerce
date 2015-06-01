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
        // check if the user has some role
        if ($request->user()->hasRole([config('site.backend.allowedRoles', 'Administrator')])) {
            return $next($request);
        }
        return new Response("Error code: 401 => You are not allowed to view this page. Contact the system administrator", 401);
    }

}
