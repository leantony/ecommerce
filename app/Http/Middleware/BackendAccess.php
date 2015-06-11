<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class BackendAccess
{

    /**
     * This middleware checks that the user accessing the backend of our site,
     * is doing so from an allowed IP address
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check the ip address
        if (in_array($request->getClientIp(), config('site.backend.allowedIPS'))) {
            return $next($request);
        }

        return new Response("Error code: 403 => You are not allowed to access this page from your ip address of {$request->getClientIp()}", 403);
    }

}
