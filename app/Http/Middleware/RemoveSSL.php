<?php namespace App\Http\Middleware;

use Closure;

class RemoveSSL
{

    /**
     * Removes the secure attribute from a request
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isSecure()) {
            return redirect()->to($request->path(), 302, [], false);
        }

        return $next($request);
    }

}
