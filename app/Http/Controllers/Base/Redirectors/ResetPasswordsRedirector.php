<?php namespace app\Http\Controllers\Base\Redirectors;

use Illuminate\Contracts\Auth\PasswordBroker;

trait ResetPasswordsRedirector {

    /**
     * Message for user not found
     *
     * @var string
     */
    protected $userNotFoundMessage = "We could not find a user with that email address";

    /**
     * A success message
     *
     * @var string
     */
    protected $resetSuccessMessage = "Your password was reset successfully";

    /**
     * An error msg
     *
     * @var string
     */
    protected $resetPasswordErrorMessage = "An error occurred when trying to reset your password. Please try again later";

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getEmailResponse($request){

        if($this->data === PasswordBroker::INVALID_USER){

            if ($request->ajax()) {
                return response()->json(['message' => $this->userNotFoundMessage], 404);
            } else {
                flash()->error($this->userNotFoundMessage);

                return redirect()->back()->with('email', $request->get('email'));
            }
        }
        if($this->data === PasswordBroker::RESET_LINK_SENT){

            if ($request->ajax()) {
                return response()->json(
                    [
                        'message' => "Password reset instructions successfully sent to {$request->get('email')}",
                        'target' => eq($request->segment(1), 'backend') ? route('backend.login') : route('login')
                    ]);
            } else {
                flash("Password reset instructions successfully sent to {$request->get('email')}");
                return eq($request->segment(1), 'backend') ? redirect()->route('backend.login') : redirect()->route('login');
            }
        }
    }


    /**
     * @param $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getPasswordResetResponse($request){

        if($this->data === PasswordBroker::PASSWORD_RESET){
            flash()->message($this->resetSuccessMessage);

            return redirect($this->redirectPath());
        }
        if($this->data === PasswordBroker::INVALID_TOKEN){

            session(['errorFatal' => true]);

            return redirect()->back();
        }

        flash()->error($this->resetPasswordErrorMessage);

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($this->data)]);
    }
}