<?php namespace App\Http\Middleware;

use Closure;

class AuthenticateWithAPI
{

    /**
     * This middleware checks that the oauth provider param in the url is among the ones we provide
     * The url to be checked looks like ... /oauth2?api=google
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if a request param is one of our registered providers
        if (in_array($request->get('provider'), config('site.account.authentication.OAUTH2.apis'), true)) {
            return $next($request);
        }
        return redirect()->back();
    }

}
