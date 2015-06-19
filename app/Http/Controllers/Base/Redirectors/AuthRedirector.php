<?php namespace app\Http\Controllers\Base\Redirectors;

use app\Antony\DomainLogic\Contracts\Security\AuthContract;
use Illuminate\Http\Request;

trait AuthRedirector
{

    /**
     * Flag to indicate if the request is from/to the backend
     *
     * @var boolean
     */
    public $backend = false;

    /**
     * A message for a failed login attempt
     *
     * @var string
     */
    protected $loginErrorMessage = "Invalid email/password combination. Please try again";

    /**
     * A message for a failed registration attempt
     *
     * @var string
     */
    protected $accountCreationErrorMessage = "Account creation failed. Please try again";

    /**
     * A message for a successful registration attempt
     *
     * @var string
     */
    protected $accountCreationSuccessMessage = "Your account was successfully created.";

    /**
     * A message for a successful activation attempt
     *
     * @var string
     */
    protected $accountActivationSuccessMessage = "Your account was activated";

    /**
     * A message for a not activated account
     *
     * @var string
     */
    protected $accountNotActivatedMessage = "Your account has not been activated. You need to activate your account before using it";

    /**
     * A message for a disabled account
     *
     * @var string
     */
    protected $accountDisabledMessage = "Your account has been disabled. Please contact system support";

    /**
     * The url the user should be redirected to, once they login successfully
     *
     * @var string
     */
    protected $returnUrl = '/';

    /**
     * Display the login form
     *
     * @return \Illuminate\View\View
     */
    public function displayLoginForm()
    {
        if ($this->backend) {
            return view('backend.auth.login');
        }
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function getRegistrationResponse(Request $request)
    {
        $mail_sent = array_get($this->data, 'mailResponse');

        $appends = !empty($mail_sent) ? "Check your email address for an activation email" : "";

        if ($request->ajax()) {

            if (empty($this->data)) {
                return response()->json(["message" => $this->accountCreationErrorMessage], 422);
            }
            return response()->json(["message" => $this->accountCreationSuccessMessage . " {$appends}", "target" => url($this->redirectPath())]);
        } else {

            if (!empty($this->data)) {
                flash()->error($this->accountCreationErrorMessage);

                return redirect($this->redirectPath())->withInput($request->all());
            } else {

                flash()->overlay($this->accountCreationSuccessMessage . "{$appends}");

                return redirect($this->redirectPath());
            }
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        if ($this->backend) {
            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/backend';
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOutAndRedirect()
    {

        $this->auth->logout();

        return redirect()->to($this->logoutPath());
    }

    /**
     * Get the path to the logout route.
     *
     * @return string
     */
    public function logoutPath()
    {
        if ($this->backend) {

            return property_exists($this, 'logoutPath') ? $this->loginPath : '/backend/login';
        }
        return property_exists($this, 'logoutPath') ? $this->loginPath : '/';
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function getLoginResponse(Request $request)
    {
        if ($this->data === AuthContract::ACCOUNT_NOT_ACTIVATED) {

            // user's account isn't activated
            return $this->getAccountActivationResponse($request);
        }
        if ($this->data === AuthContract::ACCOUNT_DISABLED) {

            // user's account is disabled
            return $this->getAccountDisabledResponse($request);
        }
        if ($request->ajax()) {

            if (!$this->data) {
                return response()->json(["message" => $this->loginErrorMessage], 401);
            }

            return response()->json(["target" => secure_url(session("url.intended", $this->redirectPath()))]);

        } else {

            if (!$this->data) {
                flash()->error($this->loginErrorMessage);

                return redirect($this->loginPath())->withInput(
                    $request->only('email', 'remember')
                );
            }
            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function getAccountActivationResponse(Request $request)
    {
        if ($request->ajax()) {

            return response()->json(["message" => $this->accountNotActivatedMessage], 401);

        } else {

            flash()->error($this->accountNotActivatedMessage);
            return redirect($this->loginPath())->withInput(
                $request->only('email', 'remember')
            );
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function getAccountDisabledResponse(Request $request)
    {
        if ($request->ajax()) {

            return response()->json(["message" => $this->accountDisabledMessage], 403);

        } else {

            flash()->error($this->accountDisabledMessage);
            return redirect($this->loginPath())->withInput(
                $request->only('email', 'remember')
            );
        }
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        if ($this->backend) {

            return property_exists($this, 'loginPath') ? $this->loginPath : '/backend/login';
        }
        return property_exists($this, 'loginPath') ? $this->loginPath : '/account/login';
    }
}