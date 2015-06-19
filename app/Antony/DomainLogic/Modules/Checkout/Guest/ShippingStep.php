<?php namespace app\Antony\DomainLogic\Modules\Checkout\Guest;

use app\Antony\DomainLogic\Modules\Checkout\AbstractCheckoutProcessor;

class ShippingStep extends AbstractCheckoutProcessor
{
    /**
     * Step identifier
     *
     * @var int
     */
    const STEP_ID = 2;

    /**
     * Route to previous step
     *
     * @var null
     */
    protected $previousRoute = 'checkout.step1';

    /**
     * Route to next step
     *
     * @var string
     */
    protected $nextStepRoute = 'checkout.step3';

    /**
     * Specifies if a user should be redirected back, once they are done
     *
     * @var boolean
     */
    protected $redirectBack = true;

    /**
     * @param $data
     *
     * @return $this
     */
    public function processCurrentStep($data)
    {
        $this->getCookieData();

        $result = $this->guestRepository->update($data, $this->cookieData->id);

        if (!$result) {

            $this->setStepStatus(static::STEP_INCOMPLETE);

            $this->updateCheckoutCookie(static::STEP_ID, $this->guestRepository->find($this->cookieData->id));

            return $this;
        }

        $this->setStepStatus(static::STEP_COMPLETE);

        $this->updateCheckoutCookie(static::STEP_ID, $this->guestRepository->find($this->cookieData->id));

        return $this;
    }
}