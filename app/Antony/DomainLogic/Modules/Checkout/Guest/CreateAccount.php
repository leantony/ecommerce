<?php namespace app\Antony\DomainLogic\Modules\Checkout\Guest;

use app\Antony\DomainLogic\Contracts\Redirects\AppRedirector;
use app\Antony\DomainLogic\Modules\Checkout\AbstractCheckoutProcessor;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Models\Guest;
use Illuminate\Http\Request;

class CreateAccount extends AbstractCheckoutProcessor implements AppRedirector
{

    const ACCOUNT_CREATED = 1;

    /**
     * Handle a redirect after a CRUD operation
     *
     * @param $request
     *
     * @return mixed
     */
    public function handleRedirect($request)
    {
        switch ($this->getStepStatus()) {

            case static::ACCOUNT_CREATED: {
                flash()->overlay('Your account was created successfully. You have been logged in');

                // redirect user & destroy the guest checkout cookie
                return redirect()->to(route('u.checkout.step4'))->withCookie($this->checkOutCookie->destroy());
            }

            default: {
                flash()->error('An error occurred. Please try again');

                return redirect()->back()->withInput($request->all());
            }
        }
    }

    /**
     * Process the current step in the checkout phase
     *
     * @param $data
     *
     * @return mixed
     */
    public function processCurrentStep($data)
    {
        return;
    }

    /**
     * Creates the user's account
     *
     * @param $request
     *
     * @param UserRepository $registerUser
     *
     * @return $this
     */
    public function createAccount(Request $request, UserRepository $registerUser)
    {
        $data = $this->mapGuestToUser($request->all());

        if (is_null($data)) {

            return $this;
        } else {

            // we create their account, and skip activation checks
            $user = $registerUser->createAccount($data, false);

            // remove the guest account
            $this->deleteGuestAccount($this->cookieData->id);

            // login user & remember them
            auth()->login($user, true);

            $request->getSession()->set('account_created_after_checkout', true);

            $this->setStepStatus(static::ACCOUNT_CREATED);

            return $this;
        }

    }

    /**
     * Maps a guest user account to an new user account
     *
     * @param $data
     *
     * @return array|null
     */
    public function mapGuestToUser($data)
    {
        if (!$this->getCookieData() instanceof Guest) {

            return null;
        }

        $new_data = [
            'first_name' => $this->cookieData->first_name,
            'last_name' => $this->cookieData->last_name,
            'email' => $this->cookieData->email,
            'home_address' => $this->cookieData->home_address,
            'county_id' => $this->cookieData->county_id,
            'phone' => $this->cookieData->phone,
            'town' => $this->cookieData->town,
            'password' => bcrypt($data['password'])
        ];

        return $new_data;
    }

    /**
     * Deletes the guest user's account
     *
     * @param $id
     *
     * @return bool|int
     */
    private function deleteGuestAccount($id)
    {
        return $this->guestRepository->delete([$id]);
    }
}