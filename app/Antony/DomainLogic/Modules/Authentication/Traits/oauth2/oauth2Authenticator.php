<?php namespace app\Antony\DomainLogic\Modules\Authentication\Traits\oauth2;

use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User;

trait oauth2Authenticator
{
    /**
     * Redirects a user to an OAUTH provider
     *
     * @param $has_code
     * @param $provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($has_code, $provider)
    {
        // if we have a code in the request, then we attempt to gather data about our user
        if ($has_code) {

            return $this->handleProviderCallback($provider);

        } else {
            // we redirect to the provider login page
            return $this->getAuthorizationFirst($provider);
        }
    }

    /**
     * Handles a callback from an OAUTH API provider. This will be placed in the OAUTH redirect url handler
     *
     * @param $api
     *
     * @return \Laravel\Socialite\Contracts\User
     */
    public function handleProviderCallback($api)
    {
        $user = $this->getApiUser($api);

        return $user;
    }

    /**
     * Returns the user data from an api call
     *
     * @param $api
     *
     * @return \Laravel\Socialite\Contracts\User
     */
    protected function getApiUser($api)
    {
        return $this->socialite->driver($api)->user();
    }

    /**
     * Redirects the client to the OAUTH provider sign in page
     *
     * @param $provider
     * @return mixed
     */
    private function getAuthorizationFirst($provider)
    {
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * Checks the API data returned with what we have in the db. Then logs them in
     * There's an option to create an account for them
     *
     * @param User $api_user
     * @param bool $createNew
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkUsersAccount(User $api_user, $createNew = false)
    {
        // grab the user's email
        $email = $api_user->getEmail();

        // check if the account exists on our server
        $user = $this->userRepository->getFirstBy('email', '=', $email);

        if (is_null($user)) {

            if ($createNew) {

                // store the user api data in the session, then allow them to fill other fields prior to their account creation
                $this->session->put('api_user_data', $api_user);

                return redirect()->route('auth.fill');
            }

            flash()->error('We could not find a matching user account on our server. Try creating an account first');

            return redirect()->to(session('url.intended', '/'));

        } else {

            // login the user
            $this->auth->login($user, true);

            return redirect()->intended(session('url.intended', '/'));
        }
    }

    /**
     * Creates a user's account using OAUTH provider API data
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(Request $request)
    {
        $user = $this->userRepository->createUserUsingDataFromAPI($request->getSession()->get('api_user_data'), $request->all());

        $this->auth->login($user, true);

        // update the last logged in field
        $this->updateLastLogin();

        $this->session->pull('api_user_data');

        return redirect()->intended(session('url.intended', '/'));
    }
}