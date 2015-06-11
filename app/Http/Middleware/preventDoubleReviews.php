<?php namespace App\Http\Middleware;

use Closure;

class preventDoubleReviews
{

    /**
     * This will attempt to prevent a user from reviewing a product more than once. At least if they try to
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check if the authenticated user has already reviewed this product

        if ($request->user()->hasMadeProductReview($request->get('_product_id'))) {

            if ($request->ajax()) {
                return response()->json(['message' => 'You\'ve already rated this product. Thank you']);
            }
            flash('You\'ve already rated this product. Thank you');

            return redirect()->back();
        } else {
            return $next($request);
        }

    }

}
