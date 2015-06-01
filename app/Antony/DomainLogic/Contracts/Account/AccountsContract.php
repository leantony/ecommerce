<?php namespace app\Antony\DomainLogic\Contracts\Account;

interface AccountsContract
{

    public function retrieveAuthenticatedUser();

    /**
     * Prompt a user to confirm their password
     *
     * @param $user_password
     * @return mixed
     */
    public function confirmPassword($user_password);

    /**
     * Allows a user to delete their account, with an option to force it, if softDeletes are enabled
     *
     * @param bool $force
     *
     * @return mixed
     */
    public function deleteAccount($force = false);

    /**
     * Allows a user to update their account data
     *
     * @param $new_data
     *
     * @return mixed
     */
    public function updateAccountData($new_data);
}