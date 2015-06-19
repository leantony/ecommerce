<?php namespace app\Antony\DomainLogic\Modules\Accounts;

use app\Antony\DomainLogic\Contracts\Account\AccountsContract;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

class AccountsRepository implements AccountsContract
{
    /**
     * Flag to indicate if the request is from/to the backend
     *
     * @var boolean
     */
    public $backend = false;

    /**
     * Results from a account audit attempt
     *
     * @var string
     */
    protected $result;

    /**
     * The authenticator implementation
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The user repo
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * The hasher implementation
     *
     * @var Hasher
     */
    protected $hasher;

    /**
     * The user object
     *
     * @var User
     */
    protected $user;

    /**
     * The data results
     *
     * @var mixed
     */
    protected $dataResult;

    /**
     * @param Guard $guard
     * @param UserRepository $userRepository
     * @param Hasher $hasher
     */
    public function __construct(Guard $guard, UserRepository $userRepository, Hasher $hasher)
    {

        $this->auth = $guard;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;

        $this->retrieveAuthenticatedUser();
    }

    /**
     * Retrieves the authenticated user
     *
     * @return User|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|mixed|null|static
     */
    public function retrieveAuthenticatedUser()
    {
        $this->user = $this->auth->user();

        // This will be so rare, but anyway..
        if (is_null($this->user)) {
            if(app()->runningInConsole()){
                return null;
            }
            throw new HttpResponseException(new Response('Access denied', 401));
        }
        return $this->user;
    }

    /**
     * Retrieves user account data
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserData()
    {
        return $this->userRepository->getFirstBy('id', '=', $this->user->id, ['county', 'shopping_cart']);
    }

    /**
     * Allows a user to update all their account data at once
     *
     * @param $new_data
     *
     * @return bool|int|mixed
     */
    public function updateAccountData($new_data)
    {
        // dob
        if (array_has($new_data, 'dob')) {
            // sometimes the date gets inserted as 000, so this function call fixes that
            $data['dob'] = $this->correctDateFormat($new_data['dob']);

        }

        $this->dataResult = $this->user->update($new_data);

        return $this->dataResult;
    }

    /**
     * Fixes the 000 issue when inserting a date in the mm/dd/yyyy format
     *
     * @param $dob
     *
     * @return bool|string
     */
    public function correctDateFormat($dob)
    {
        return date("Y-m-d", strtotime($dob));
    }

    /**
     * Allows a user to update their password, with an option to log them out when they finish
     *
     * @param $new_password
     * @param bool $logOutWhenDone
     *
     * @return bool
     */
    public function updatePassword($new_password, $logOutWhenDone = false)
    {
        // update user's password
        $this->user->password = $this->hasher->make($new_password);

        $this->dataResult = $this->user->save();

        // the user requested to log-out, so we return the favour
        if ($logOutWhenDone) {

            $this->auth->logout();

        }

        return $this->dataResult;

    }

    /**
     * Allows an admin user to update another user's password
     *
     * @param $user_id
     * @param $new_password
     * @param bool $logoutTheUser
     * @return bool
     */
    public function updateAnotherUsersPassword($user_id, $new_password, $logoutTheUser = false)
    {

        if ($user_id === $this->user->id) {

            return $this->updatePassword($new_password, $logoutTheUser);
        }
        $user = $this->userRepository->find($user_id, [], true);

        $user->password = $this->hasher->make($new_password);

        $this->dataResult = $user->save();

        if ($logoutTheUser) {

            // not implemented yet

        }

        return $this->dataResult;
    }

    /**
     * Validates the authenticated user's password
     *
     * @param $user_password
     * @return bool
     */
    public function confirmPassword($user_password)
    {
        $current_password = $this->user->getAuthPassword();

        $status = $this->hasher->check($user_password, $current_password);

        return $status;
    }

    /**
     * Allows a user to delete their account. The force option can be used, if we are working with a model
     * that uses the soft deletes trait
     *
     * @param bool $force
     *
     * @return bool|int|mixed
     */
    public function deleteAccount($force = false)
    {
        if ($force) {

            $this->user->forceDelete();

            // log the user out
            $this->auth->logout();

            return true;
        } else {

            $this->dataResult = $this->userRepository->delete([$this->user->id]);

            // log the user out
            $this->auth->logout();

            return $this->dataResult;
        }

    }

}