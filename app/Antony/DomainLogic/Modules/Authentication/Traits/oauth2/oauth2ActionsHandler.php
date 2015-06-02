<?php namespace app\Antony\DomainLogic\Modules\Authentication\Traits\oauth2;

use App\Http\Requests\User\ApiRegistrationRequest;
use Illuminate\Http\Request;
use JavaScript;

trait oauth2ActionsHandler
{

    /**
     * Redirects a user to the OAUTH provider login page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function apiAuth(Request $request)
    {
        $provider = $request->get('provider');

        // store used api in the current session
        $this->request->getSession()->set('oauth_api', $provider);

        return $this->auth->redirectToProvider($request->has('code'), $provider);
    }

    /**
     * Handle a callback (redirect) from an OAUTH provider
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleOAUTHCallback(Request $request)
    {
        $user = $this->auth->handleProviderCallback($request->getSession()->get('oauth_api'));

        // at this point, we should close the popup window, if any
        // the code below however doesn't work
        JavaScript::put([
            'process_done' => 'true',
        ]);

        // after fetching the user, we either log them in or create an account for them
        return $this->auth->checkUsersAccount($user, config('site.account.authentication.OAUTH2.registration', false));
    }

    /**
     * Display the mini form that users will fill in prior to registration via an API
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getMiniRegistrationForm(Request $request)
    {
        $user = $request->getSession()->get('api_user_data');

        return view('auth.fillRemaining', compact('user'));
    }


    /**
     * Creates an account using API data
     *
     * @param ApiRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccountViaOAUTHData(ApiRegistrationRequest $request)
    {
        return $request->getSession()->has('api_user_data')
            ? $this->auth->createAccount($request)
            : redirect()->route('login');
    }

}