<?php namespace app\Antony\DomainLogic\Modules\Checkout\AuthUser;

use app\Antony\DomainLogic\Modules\Checkout\AbstractCheckoutProcessor;

class PaymentStep extends AbstractCheckoutProcessor
{
    const STEP_ID = 3;

    /**
     * @return \Illuminate\View\View
     */
    public function displayPaymentForm()
    {

        //$this->updateCheckoutCookie(static::STEP_ID, $this->getCookieData());

        return view('frontend.checkout.payment');
    }

    /**
     * process the current step in the checkout process
     *
     * @param $data
     *
     * @return mixed
     */
    public function processCurrentStep($data)
    {
        // TODO: Implement processCurrentStep() method.
    }
}