<?php namespace app\Antony\DomainLogic\Contracts\Security;

interface AuthContract
{
    /**
     * Constant representing a disabled account
     *
     * @var string
     */
    const ACCOUNT_DISABLED = 1;

    /**
     * Constant representing an account that is not activated
     *
     * @var string
     */
    const ACCOUNT_NOT_ACTIVATED = 2;

    /**
     * Constant representing a deleted account
     *
     * @var string
     */
    const ACCOUNT_DELETED = 3;

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