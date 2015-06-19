<?php namespace app\Antony\DomainLogic\Modules\Checkout\AuthUser;

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
    protected $previousRoute = 'u.checkout.step2';

    /**
     * Route to next step
     *
     * @var string
     */
    protected $nextStepRoute = 'u.checkout.step3';

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
        $status = $this->userRepository->update($data, $this->retrieveUserDetails()->id);

        if ($status) {

            $this->createCheckoutCookie(static::STEP_ID, $this->retrieveUserDetails()->id);

            $this->setStepStatus(static::STEP_COMPLETE);

            return $this;
        }

        $this->setStepStatus(static::STEP_INCOMPLETE);

        return $this;
    }
}