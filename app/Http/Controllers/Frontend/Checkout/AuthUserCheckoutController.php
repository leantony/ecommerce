<?php

namespace App\Http\Controllers\Frontend\Checkout;

use app\Antony\DomainLogic\Modules\Checkout\AuthUser\ShippingStep;
use App\Http\Controllers\Controller;
use App\Http\Request\Accounts\updateShippingInfo;

class AuthUserCheckoutController extends Controller
{
    /**
     * @var ShippingStep
     */
    private $shippingStep;

    /**
     * @param ShippingStep $shippingStep
     */
    public function __construct(ShippingStep $shippingStep)
    {

        $this->shippingStep = $shippingStep;
    }

    /**
     * Displays the shipping info edit form
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->shippingStep->retrieveUserDetails();

        return view('frontend.checkout.shipping', compact('user'));
    }

    /**
     * This will process user shipping details, if they decide to edit them
     *
     * @param updateShippingInfo $request
     *
     * @return mixed
     */
    public function shipping(updateShippingInfo $request)
    {
        return $this->shippingStep->processCurrentStep($request->all())->getStepDoneResponse($request);
    }

    /**
     * Displays the payment form
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment()
    {
        return view('frontend.checkout.payment');
    }

    public function postPayment()
    {
        // process user payment details
    }

    /**
     * Displays the order review form
     *
     * @return \Illuminate\View\View
     */
    public function reviewOrder()
    {

        return view('frontend.checkout.reviewOrder');
    }
}
