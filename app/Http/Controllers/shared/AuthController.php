<?php namespace App\Http\Controllers\Shared;

use app\Antony\DomainLogic\Modules\Authentication\RegisterUser as AuthenticateUser;
use app\Antony\DomainLogic\Modules\Authentication\Traits\oauth2\oauth2ActionsHandler;
use app\Http\Controllers\Base\Redirectors\AuthRedirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\User\CreateUserAccountRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
    /*
     * Allow users to login/register using OAUTH. The redirector handles authentication responses
     */
    use oauth2ActionsHandler, AuthRedirector;

    /**
     * @var AuthenticateUser
     */
    protected $auth;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param AuthenticateUser $authenticateUser
     * @param Request $request
     */
    public function __construct(AuthenticateUser $authenticateUser, Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout', 'getActivate']);

        $this->auth = $authenticateUser;
        $this->request = $request;
        $this->backend = eq($request->segment(1), 'backend') ? true : false;

    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return $this->displayLoginForm();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        return $this->logOutAndRedirect();

    }

    /**
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function postLogin(LoginRequest $request)
    {
        $this->data = $this->auth->login($request->except('_token'));

        return $this->getLoginResponse($request);
    }

    /**
     * @param CreateUserAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function postRegister(CreateUserAccountRequest $request)
    {
        // check if we need to enforce user account activation
        $this->data = $this->auth->register($request->all(), config('site.account.activation.email'));

        return $this->getRegistrationResponse($request);
    }

    /**
     * Activates a users account
     *
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getActivate(Request $request, $code)
    {
        if (is_null($code)) {

            throw new NotFoundHttpException('An activation code is required, but was not found');
        }
        return $this->auth->activate($code);
    }
}
