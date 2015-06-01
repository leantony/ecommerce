<?php namespace app\Antony\DomainLogic\Contracts\Security;

interface AuthContract
{
    /**
     * Allows a user to login to the app
     *
     * @param array $credentials
     * @return mixed
     */
    public function login(array $credentials);

    /**
     * Allows us to check if an account has been confirmed
     *
     * @return mixed
     */
    public function checkIfAccountIsConfirmed();

    /**
     * Log out a user
     *
     * @return mixed
     */
    public function logout();

}