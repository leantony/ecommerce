<?php namespace App\Http\Middleware;

use Closure;

class AgeFilter {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(!is_null($request->user())){

            if($request->has('dob')){
                // check their age
                if($request->user()->checkAge($request->get('dob'))){

                    return $next($request);
                }

                if($request->ajax()){

                    return response()->json(['message' => ["Your age should be between {$request->user()->minAge} and {$request->user()->maxAge}"]], 422);
                }

                flash()->warning("Your age should be between {$request->user()->minAge} and {$request->user()->maxAge}");

                return redirect()->back()->withInput($request->all());
            }
            return $next($request);
        }

        return redirect()->guest('account/login');

	}

}
