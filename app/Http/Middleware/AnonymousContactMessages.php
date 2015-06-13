<?php namespace App\Http\Middleware;

use Closure;

class AnonymousContactMessages
{

    /**
     * This middleware prevents the user from sending more than 1 contact message, in the same session
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if the current user has already sent a contact message
        $status = session('message.sent');

        if (is_null($status)) {
            return $next($request);
        } else {

            if ($request->ajax()) {
                return response()->json(['message' => 'Your message has already been sent'], 422);
            } else {
                flash()->warning('Your message has already been sent');
                return redirect()->back();
            }

        }


    }

}
