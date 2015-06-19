<?php namespace App\Http\Controllers\Shared;

use app\Antony\DomainLogic\Modules\Accounts\AccountsRepository;
use App\Http\Controllers\Controller;
use App\Http\Request\Accounts\updateShippingInfo;
use App\Http\Requests\Accounts\addMoreAccountInfo;
use App\Http\Requests\Accounts\ContactInfo;
use App\Http\Requests\Accounts\updatePasswordRequest;
use App\Http\Requests\Security\DestructiveActionRequest;
use App\Http\Requests\User\CreateUserAccountRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * The accounts repository
     *
     * @var AccountsRepository
     */
    private $accounts;

    /**
     * @param AccountsRepository $accounts
     * @param Request $request
     */
    public function __construct(AccountsRepository $accounts, Request $request)
    {
        $this->accounts = $accounts;

        $this->accounts->backend = eq($request->segment(1), 'backend') ? true : false;
    }

    /**
     * Displays data about a user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->accounts->getUserData();

        if ($this->accounts->backend) {

            return view('backend.account.index', compact('user'));
        }
        return view('shared.account.index', compact('user'));

    }

    /**
     * Update a user's contact information
     *
     * @param ContactInfo $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchContacts(ContactInfo $request)
    {
        $this->data = $this->accounts->updateAccountData($request->all());

        return $this->handleRedirect($request);
    }


    /**
     * Updates a user's password
     *
     * @param updatePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchPassword(updatePasswordRequest $request)
    {
        $this->data = $this->accounts->updatePassword($request->get('password'), $request->has('logMeOut'));

        return $this->handleRedirect($request);
    }

    /**
     * Updates another user's password
     *
     * @param updatePasswordRequest $request
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchAnotherUsersPassword(updatePasswordRequest $request, $user_id)
    {
        $this->data = $this->accounts->updateAnotherUsersPassword($user_id, $request->get('password'), false);

        return $this->handleRedirect($request);
    }

    /**
     * Updates a user's shipping details
     *
     * @param updateShippingInfo $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchShipping(updateShippingInfo $request)
    {
        $this->data = $this->accounts->updateAccountData($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Updates a user's account
     *
     * @param CreateUserAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchAccount(CreateUserAccountRequest $request)
    {
        $this->data = $this->accounts->updateAccountData($request->all());

        return $this->handleRedirect($request);
    }

    /**
     * Adds more data to a user's account
     *
     * @param addMoreAccountInfo $addMoreAccountInfo
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function patchAccountAddingMoreDetails(addMoreAccountInfo $addMoreAccountInfo)
    {
        $this->data = $this->accounts->updateAccountData($addMoreAccountInfo->all());

        return $this->handleRedirect($addMoreAccountInfo);
    }

    /**
     * Allows user's to be sure about destructive actions by confirming their password
     * Once they do, we save a key in the session, to prevent asking them to do this again
     *
     * @param DestructiveActionRequest|Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function confirmPassword(DestructiveActionRequest $request)
    {
        if ($this->accounts->confirmPassword($request->get('password'))) {

            $request->getSession()->set('password.confirmed-' . $request->user()->id, true);

            return response()->json(['target' => $request->get('proceedTo')]);
        }

        return response()->json(['message' => 'You entered an incorrect password'], 401);
    }

    /**
     * Deletes an account. Not actually though, since our users model implements the soft deletes trait
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAccount(Request $request)
    {
        if ($request->getSession()->has('password.confirmed-' . $request->user()->id)) {

            $this->data = $this->accounts->deleteAccount();

            return $this->handleRedirect($request, route('home'));
        }
        flash()->error('You need to confirm your password first');

        return redirect()->back();
    }

    /**
     * Permanently destroys a user's account
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request)
    {
        if ($request->getSession()->has('password.confirmed' . h($request->user()->id))) {

            $this->data = $this->accounts->deleteAccount(true);

            return $this->handleRedirect($request, route('home'));
        }
        flash()->error('You need to confirm your password first');

        return redirect()->back();
    }

}