<?php

namespace App\Http\Controllers\Frontend\Checkout;

use app\Antony\DomainLogic\Modules\Checkout\AuthUser\PaymentStep;
use app\Antony\DomainLogic\Modules\Checkout\Guest\CreateAccount;
use app\Antony\DomainLogic\Modules\Checkout\Guest\GuestBillingAddress;
use app\Antony\DomainLogic\Modules\Checkout\Guest\ShippingStep;
use App\Antony\DomainLogic\Modules\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\GuestCheckoutRequest;
use App\Http\Requests\Checkout\GuestCreateAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuestCheckoutController extends Controller
{

    /**
     * @var GuestBillingAddress
     */
    private $guest;

    /**
     * @var ShippingStep
     */
    private $shippingStep;

    /**
     * @var PaymentStep
     */
    private $paymentStep;

    /**
     * @param GuestBillingAddress $guestBegin
     * @param ShippingStep $shippingStep
     */
    public function __construct(GuestBillingAddress $guestBegin, ShippingStep $shippingStep, PaymentStep $paymentStep)
    {

        $this->guest = $guestBegin;
        $this->shippingStep = $shippingStep;
        $this->paymentStep = $paymentStep;
    }

    /**
     * checkout authentication
     *
     * @return Response
     */
    public function auth()
    {
        return view('frontend.checkout.auth');
    }

    /**
     * Step 1 of 4
     *
     * Allow guest users to submit their personal info
     *
     * @return Response
     */
    public function guestInfo()
    {
        return $this->guest->displayGuestForm();
    }


    /**
     * @param GuestCheckoutRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postGuestInfo(GuestCheckoutRequest $request)
    {
        return $this->guest->processCurrentStep($request->all())->getStepDoneResponse($request);
    }

    /**
     * Step 2 of 4
     *
     * Displays the shipping information form for a guest user
     *
     * @return Response
     */
    public function shipping()
    {
        // fetch the guest user
        $guest = $this->guest->getGuestDetails();

        if (is_null($guest)) {
            return redirect()->back();
        }
        return view('frontend.checkout.shipping', compact('guest'));
    }

    /**
     * Allows guests to edit their shipping information
     *
     * @param GuestCheckoutRequest $request
     *
     * @return mixed
     */
    public function editShippingAddress(GuestCheckoutRequest $request)
    {
        return $this->shippingStep->processCurrentStep($request->all())->getStepDoneResponse($request);
    }

    /**
     * Step 3 of 4
     *
     * Displays the payment form
     *
     * @return \Illuminate\View\View
     */
    public function payment()
    {
        return $this->paymentStep->displayPaymentForm();
    }

    /**
     * Allows a user to review their order
     *
     * @return \Illuminate\View\View
     */
    public function reviewOrder()
    {
        return view('frontend.checkout.reviewOrder');
    }

    /**
     * Displays the account creation form for a guest user
     *
     * @return \Illuminate\View\View
     */
    public function getCreateAccount(Request $request)
    {
        // save target url in session
        $request->getSession()->set('after_account_create', $request->get('proceedTo'));
        // check if a usr has done previous steps
        // ------
        return view('frontend.checkout.create_account');
    }


    /**
     * This will allow users to optionally create an account before making an order
     *
     * @param GuestCreateAccount $guestCreateAccount
     * @param CreateAccount $user
     *
     * @param UserRepository $registerUser
     * @return mixed
     */
    public function createAccount(GuestCreateAccount $guestCreateAccount, CreateAccount $user, UserRepository $registerUser)
    {
        // check the email
        $email = $this->guest->getGuestDetails()->email;

        $result = $registerUser->getFirstBy('email', '=', $email);

        if (!is_null($result)) {

            flash()->warning('Your email address is already in use. Please change it');

            return redirect()->back();
        }
        return $user->createAccount($guestCreateAccount, $registerUser)->handleRedirect($guestCreateAccount);
    }
}
