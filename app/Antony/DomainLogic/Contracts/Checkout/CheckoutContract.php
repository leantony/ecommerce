<?php namespace app\Antony\DomainLogic\Contracts\Checkout;

interface CheckoutContract
{

    /**
     * constant representing status = completed
     *
     * @var string
     */
    const STEP_COMPLETE = 'step.completed';

    /**
     * constant representing status = incomplete
     *
     * @var string
     */
    const STEP_INCOMPLETE = 'step.incomplete';

    /**
     * constant representing status = has been done already
     *
     * @var string
     */
    const STEP_ALREADY_DONE = 'step.done.already';

    /**
     * Retrieves the data associated with the cookie
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getCookieData($key = 'data');

    /**
     * Gets data about the authenticated user
     *
     * @return mixed
     */
    public function retrieveUserDetails();

    /**
     * Creates a user checkout cookie
     *
     * @param $step_id
     * @param $data
     *
     * @return mixed
     */
    public function createCheckoutCookie($step_id, $data);

    /**
     * process the current step in the checkout phase
     *
     * @param $data
     *
     * @return mixed
     */
    public function processCurrentStep($data);

}