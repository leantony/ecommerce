<?php namespace App\Http\Middleware;

use Closure;

class AgeFilter
{

    /**
     * This middleware prevents a user from entering an invalid date of birth in their account editing process
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if the user is authenticated. which would be obvious anyway...
        if (!is_null($request->user())) {

            if ($request->has('dob')) {
                // check their age
                if ($request->user()->checkAge($request->get('dob'))) {

                    return $next($request);
                }

                if ($request->ajax()) {

                    return response()->json(['message' => ["Your age should be between {$request->user()->minAge} and {$request->user()->maxAge} years"]], 422);
                }

                flash()->warning("Your age should be between {$request->user()->minAge} and {$request->user()->maxAge}");

                return redirect()->back()->withInput($request->all());
            }
            return $next($request);
        }

        return redirect()->guest('account/login');

    }

}
