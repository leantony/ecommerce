<?php namespace app\Antony\DomainLogic\Modules\Authentication\Base;

use app\Antony\DomainLogic\Contracts\Security\AuthContract;
use app\Antony\DomainLogic\Modules\Authentication\Traits\oauth2\oauth2Authenticator;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Session\Store;
use Laravel\Socialite\Contracts\Factory as Socialite;

abstract class ApplicationAuthProvider implements AuthContract
{
    use oauth2Authenticator;

    /**
     * Status of an authentication request. For non API calls only
     *
     * @var string
     */
    protected $authStatus;

    /**
     * Socialite implementation
     *
     * @var Socialite
     */
    protected $socialite;

    /**
     * Authenticator implementation
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The socialite driver, ie an API name, like facebook, google, etc. Defaults to google
     *
     * @var string
     */
    protected $driver = 'google';

    /**
     * Our user repo
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * The password broker implementation
     *
     * @var PasswordBroker
     */
    protected $passwords;

    /**
     * @var Store
     */
    private $session;

    /**
     * @param Socialite $socialite
     * @param Guard $guard
     * @param UserRepository $userRepository
     * @param PasswordBroker $passwords
     */
    public function __construct(Socialite $socialite, Guard $guard, UserRepository $userRepository, PasswordBroker $passwords, Store $session)
    {

        $this->socialite = $socialite;
        $this->auth = $guard;
        $this->userRepository = $userRepository;
        $this->passwords = $passwords;
        $this->session = $session;
    }

    /**
     * Logs in a user. True is returned if login succeeds
     *
     * @param array $credentials
     * @return bool|null
     */
    public function login(array $credentials)
    {
        if ($this->auth->attempt($credentials, array_has($credentials, 'remember'))) {

            // check if users are allowed to login without activating their accounts
            if (!config('site.account.activation.allow_login')) {

                $result = $this->checkIfAccountIsConfirmed();

                if (!$result) {

                    // log out the user
                    $this->auth->logout();

                    return null;
                }
                return true;
            }

            return true;

        } else {

            return false;
        }
    }

    /**
     * Checks if a user's account is activated. Requires that the user is logged in
     *
     * @return boolean
     */
    public function checkIfAccountIsConfirmed()
    {
        // retrieve the authenticated user and check if their account is activated/confirmed
        $result = $this->auth->user()->confirmed;

        return $result;
    }

    /**
     * Log out a user.
     *
     */
    public function logout()
    {
        $this->auth->logout();
    }

}