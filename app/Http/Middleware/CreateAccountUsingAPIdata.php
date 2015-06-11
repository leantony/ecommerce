<?php namespace App\Http\Middleware;

use Closure;

class CreateAccountUsingAPIdata
{

    /**
     * Checks if a user has attempted to create their account using any OAUTH API's
     * This is useful, so that afterwards we can display the mini form where they can just enter their password
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
