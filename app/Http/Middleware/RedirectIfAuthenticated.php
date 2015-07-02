<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Redirects a user if they are logged in, and attempt to access pages that aren't for authenticated users
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            return redirect()->back();
        }

        // handle backend authentication redirects
        if ($this->auth->check() & $request->segment(2) === 'backend') {
            return redirect()->route('backend');
        }
        return $next($request);
    }

}
