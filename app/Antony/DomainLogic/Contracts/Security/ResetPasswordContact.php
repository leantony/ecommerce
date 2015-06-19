<?php namespace app\Antony\DomainLogic\Contracts\Security;

interface ResetPasswordContact
{

    /**
     * Finds the user with the specified email address
     *
     * @param $email_address
     *
     * @return mixed
     */
    public function getUser($email_address);

    /**
     * Does the actual password reset stuff
     *
     * @param $request
     *
     * @return mixed
     */
    public function resetPassword($request);

    /**
     * Sends a reset email to the user
     *
     * @return mixed
     */
    public function sendResetEmail();
}