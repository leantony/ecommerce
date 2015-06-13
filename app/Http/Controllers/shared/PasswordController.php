<?php namespace App\Http\Controllers\Shared;

use app\Antony\DomainLogic\Modules\Authentication\ResetPasswords;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ResetPassword;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
    /**
     * The password reset module
     *
     * @var ResetPasswords
     */
    private $passwords;

    /**
     * @param ResetPasswords $passwords
     */
    public function __construct(ResetPasswords $passwords)
    {
        $this->middleware('guest');
        $this->passwords = $passwords;
    }

    /**
     * Displays the form to allow a user to enter their email
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getEmail(Request $request)
    {
        if (eq($request->segment(1), 'backend')) {

            return view('backend.auth.forgot_password');
        }
        return view('auth.forgot_password');
    }

    /**
     * @param ResetPassword $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function postEmail(ResetPassword $request)
    {
        return $this->passwords->getUser($request->get('email'))->sendResetEmail()->handleRedirect($request);
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function getReset($token)
    {
        if (is_null($token)) {

            throw new NotFoundHttpException('No token present in the current request');
        }
        return view('auth.reset')->with('token', $token);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postReset(Request $request)
    {
        return $this->passwords->resetPassword($request)->handleRedirect($request);
    }
}
