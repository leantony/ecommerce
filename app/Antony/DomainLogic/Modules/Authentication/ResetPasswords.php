<?php namespace app\Antony\DomainLogic\Modules\Authentication;

use app\Antony\DomainLogic\Contracts\Security\ResetPasswordContact;
use App\Events\PasswordResetWasRequested;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use UnexpectedValueException;

class ResetPasswords implements ResetPasswordContact
{
    /**
     * Results after sending mail
     *
     * @var array
     */
    private $mailResult;

    /**
     * The user
     *
     * @var User
     */
    private $user;

    /**
     * @var PasswordBroker
     */
    protected $passwordBroker;

    /**
     * @param PasswordBroker $passwordBroker
     */
    public function __construct(PasswordBroker $passwordBroker)
    {

        $this->passwordBroker = $passwordBroker;
    }

    /**
     * @return array
     */
    public function getSendEmailResult()
    {
        return $this->mailResult;
    }

    /**
     * Does exactly what it says it does
     *
     * @param array $credentials
     * @return array|null|string
     */
    public function getUserAndSendEmail(array $credentials)
    {

        try {
            $this->user = $this->passwordBroker->getUser($credentials);

        } catch (UnexpectedValueException $e) {

            return PasswordBroker::INVALID_USER;
        }

        // trigger the mail send event
        $this->mailResult = event(new PasswordResetWasRequested($this->user));

        return empty($this->mailResult) ? null : PasswordBroker::RESET_LINK_SENT;

    }

    /**
     * Process a password reset request. This is the last step in the reset process
     *
     * @param $credentials
     * @return mixed|string
     */
    public function resetPassword($credentials)
    {
        $status = $this->passwordBroker->reset($credentials, function ($user, $password) {

            $user->password = app('hash')->make($password);

            if ($user->save()) {
                // auto login the user
                auth()->login($user);

            }

        });

        return $status;

    }

    /**
     * Finds the user with the specified email address
     *
     * @param $email_address
     *
     * @return mixed
     */
    public function getUser($email_address)
    {
        // TODO: Implement getUser() method.
    }

    /**
     * Sends a reset email to the user
     *
     * @return mixed
     */
    public function sendResetEmail()
    {
        if (is_null($this->user)) return;

        return event(new PasswordResetWasRequested($this->user));

    }
}