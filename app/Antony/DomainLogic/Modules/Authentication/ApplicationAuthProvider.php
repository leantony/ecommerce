<?php namespace app\Antony\DomainLogic\Modules\Authentication;

use app\Antony\DomainLogic\Contracts\Security\AuthContract;
use app\Antony\DomainLogic\Modules\Authentication\Traits\oauth2\oauth2Authenticator;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use Illuminate\Contracts\Auth\Guard;
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
     * @var Store
     */
    private $session;

    /**
     * @param Socialite $socialite
     * @param Guard $guard
     * @param UserRepository $userRepository
     * @param Store $session
     */
    public function __construct(Socialite $socialite, Guard $guard, UserRepository $userRepository, Store $session)
    {
        $this->socialite = $socialite;
        $this->auth = $guard;
        $this->userRepository = $userRepository;
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

            $user = $this->auth->user();
            // check a user's account status
            switch ($user) {

                // check if their account is disabled
                case ($user->disabled): {

                    $this->auth->logout();

                    return static::ACCOUNT_DISABLED;
                }
                // check for account confirmation
                case (!$user->confirmed): {

                    // check if the configuration allows users to login without activating their accounts
                    if (!config('site.account.activation.allow_login')) {

                        $this->auth->logout();

                        return static::ACCOUNT_NOT_ACTIVATED;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Disables a user's account
     *
     * @param $user_id
     * @return bool
     */
    public function disableAccount($user_id)
    {

        $user = $this->userRepository->find($user_id);

        $user->disabled = true;

        return $user->save();
    }

    /**
     * Enables a users account
     *
     * @param $user_id
     * @return bool
     */
    public function enableAccount($user_id)
    {

        $user = $this->userRepository->find($user_id);

        $user->disabled = false;

        return $user->save();
    }

    /**
     * Checks if the current user's account is activated. Requires that the user is logged in
     *
     * @return boolean
     */
    public function checkIfAccountIsConfirmed()
    {
        // retrieve the authenticated user and check if their account is activated/confirmed
        $result = $this->auth->user()->confirmed && $this->auth->user()->confirmation_code === null;

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