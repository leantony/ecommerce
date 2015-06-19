<?php namespace app\Antony\DomainLogic\Modules\Checkout\Guest;

use app\Antony\DomainLogic\Modules\Checkout\AbstractCheckoutProcessor;
use app\Antony\DomainLogic\Modules\Checkout\CheckoutRedirector;
use App\Models\Guest;

class GuestBillingAddress extends AbstractCheckoutProcessor
{
    use CheckoutRedirector;

    /**
     * Step identifier
     *
     * @var int
     */
    const STEP_ID = 1;

    /**
     * Route to previous step
     *
     * @var null
     */
    protected $previousRoute = null;

    /**
     * Route to next step
     *
     * @var string
     */
    protected $nextStepRoute = 'checkout.step2';

    /**
     * @return \Illuminate\View\View
     */
    public function displayGuestForm()
    {
        $state = $this->getCookieData('step');

        if (!is_null($state)) {
            if ($this->getCookieData() instanceof Guest) {

                return view('frontend.checkout.guest')->with('guest', $this->cookieData);
            }
            return view('frontend.checkout.guest');

        }
        return view('frontend.checkout.guest');
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function processCurrentStep($data)
    {
        if (empty($this->getCookieData())) {

            // this step has not yet been initialized, so we create the guest user
            $this->guest = $this->guestRepository->addGuest($data, null);

            if ($this->guest !== null) {

                $this->setStepStatus(static::STEP_COMPLETE);

                $this->createCheckoutCookie(static::STEP_ID, $this->guest);

                return $this;
            } else {

                // fail
                $this->setStepStatus(static::STEP_INCOMPLETE);

                return $this;
            }
        }

        $this->guest = $this->cookieData;

        $this->setStepStatus(static::STEP_ALREADY_DONE);

        return $this;
    }
}