<?php namespace app\Antony\DomainLogic\Contracts\Security;

interface UserRegistrationContract
{

    /**
     * Sends registration email to a registered user on first time of asking
     *
     * @return mixed
     */
    public function sendRegistrationEmail();

    /**
     * Create a new user account, with an option to allow the user to activate it before use
     *
     * @param array $data
     *
     * @param bool $enforceActivation
     *
     * @return mixed
     */
    public function register(array $data, $enforceActivation = true);

    /**
     * Activates a user account
     *
     * @param $code
     *
     * @return mixed
     */
    public function activate($code);

    /**
     * Verifies that the code we sent via email is associated with that email
     *
     * @param $code
     *
     * @return mixed
     */
    public function verifyCode($code);
}