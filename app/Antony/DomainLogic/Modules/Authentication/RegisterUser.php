<?php namespace app\Antony\DomainLogic\Modules\Authentication;

use app\Antony\DomainLogic\Contracts\Security\UserRegistrationContract;
use app\Antony\DomainLogic\Modules\Authentication\Traits\AccountActivationTrait;
use App\Events\UserWasRegistered;
use App\Models\User;
use InvalidArgumentException;

class RegisterUser extends AuthenticateUser implements UserRegistrationContract
{
    /**
     * Allows users to activate their accounts
     */
    use AccountActivationTrait;

    /**
     * The user created
     *
     * @var User
     */
    protected $user;

    /**
     * Response returned after sending registration email
     *
     * @var array
     */
    protected $mailResponse;

    /**
     * Triggers the registration mail send event
     *
     * @return array|mixed|null
     */
    public function sendRegistrationEmail()
    {
        if (is_null($this->user)) {
            throw new InvalidArgumentException('A user needs to be created first');

        }
        $this->mailResponse = event(new UserWasRegistered($this->user));

        return $this->mailResponse;
    }

    /**
     * Creates a user's account
     *
     * @param array $data
     * @param bool $enforceActivation
     * @return array|null
     */
    public function register(array $data, $enforceActivation = true)
    {
        $this->user = $this->userRepository->createAccount($data, $enforceActivation);

        if (!is_null($this->user)) {

            // if no activation is required, then we log in the user automatically
            if (!$enforceActivation) {

                $this->auth->login($this->user, true);

                return ["user" => $this->user];

            } else {

                $mailResult = $this->sendRegistrationEmail();

                return ["user" => $this->user, "mailResult" => $mailResult];

            }
        }
        return null;
    }

    /**
     * Returns user data as JSON or otherwise
     *
     * @param bool $json
     *
     * @return User|string
     */
    public function getUser($json = false)
    {
        return $json ? $this->user->toJson() : $this->user;
    }
}