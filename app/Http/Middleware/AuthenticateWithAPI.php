<?php namespace App\Http\Middleware;

use Closure;

class AuthenticateWithAPI {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        // check if a request param is one of our registered providers
        if(in_array($request->get('provider'), config('site.account.authentication.OAUTH2.apis'), true)){
            return $next($request);
        }
		return redirect()->back();
	}

}
