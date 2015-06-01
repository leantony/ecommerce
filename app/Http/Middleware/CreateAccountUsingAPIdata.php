<?php namespace App\Http\Middleware;

use Closure;

class CreateAccountUsingAPIdata
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getSession()->has('api_user_data')) {
            return $next($request);
        }
        return redirect()->route('login');
    }

}
