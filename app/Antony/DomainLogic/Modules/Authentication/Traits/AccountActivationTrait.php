<?php namespace app\Antony\DomainLogic\Modules\Authentication\Traits;

use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait AccountActivationTrait
{
    /**
     * Activate a user's account
     *
     * @param $code
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($code)
    {
        // activate a user's account
        $user = $this->verifyCode($code);

        // check if we need to automatically sign in a user, once they activate their account
        $autoLogin = config('site.account.activation.autologin', false);

        if ($autoLogin) {

            $this->auth->login($user);

            flash()->success("Your account was successfully activated. You are now a member at PC-World!.");

            return redirect()->intended($this->redirectPath());
        } else {

            flash()->overlay("Your account was successfully activated. You are now a member at PC-World!. Please login to continue");

            return redirect()->route('login');
        }

    }

    /**
     * Verify that a given activation code matches a user
     *
     * @param $code
     *
     * @return mixed
     */
    public function verifyCode($code)
    {
        // verify that this confirmation code matches the user
        $user = $this->userRepository->where('confirmation_code', '=', $code)->first();

        // check if the result is valid
        if (is_null($user)) {

            throw new NotFoundHttpException('A user matching that confirmation code was not found');
        }

        // update necessary fields and save the user model
        $user->confirmation_code = null;

        $user->confirmed = true;

        $user->confirmed_at = Carbon::now();

        $user->save();

        return $user;
    }
}