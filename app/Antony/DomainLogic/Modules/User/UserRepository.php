<?php namespace app\Antony\DomainLogic\Modules\User;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class UserRepository extends EloquentRepository
{
    /**
     * @param $data
     *
     * @return static
     */
    public function add($data)
    {
        $this->model->creating(function ($user) {
            $user->confirmation_code = $this->generateConfirmationCode();
        });

        $data['password'] = app('hash')->needsRehash($data['password']) ? app('hash')->make($data['password']) : $data['password'];

        $user = parent::add($data);

        return $user;
    }

    /**
     * @param $data
     * @param bool $enforceEmailActivation
     *
     * @return User
     */
    public function createAccount($data, $enforceEmailActivation = true)
    {
        $this->model->creating(function ($user) use ($enforceEmailActivation) {

            $enforceEmailActivation ? $user->confirmation_code = $this->generateConfirmationCode() : $user->confirmed = true;

        });

        $data['password'] = app('hash')->needsRehash($data['password']) ? app('hash')->make($data['password']) : $data['password'];

        $user = parent::add($data);

        return $user;
    }

    /**
     * Generate a user's email confirmation code
     *
     * @return string
     */
    public function generateConfirmationCode()
    {
        return h(str_random(30));
    }

    /**
     * Creates a user in our system using data from an OAUTH provider API
     *
     * @param SocialiteUser $user
     *
     * @param array $params
     * @return static
     */
    public function createUserUsingDataFromAPI(SocialiteUser $user, $params = [])
    {
        $data = $this->getUserData($user, $params);

        $user = parent::add($data);

        // disable account activation
        $user->confirmed = true;

        $user->confirmation_code = null;

        $user->save();

        return $user;
    }

    /**
     * @param SocialiteUser $user
     * @param $params
     * @return array
     */
    protected function getUserData(SocialiteUser $user, $params)
    {

        $user_data = $user->map($user->user);

        return [

            'first_name' => array_get($user_data->name, 'familyName'),
            'last_name' => array_get($user_data->name, 'givenName'),
            'avatar' => $user_data->avatar,
            'email' => $user->getEmail(),
            'gender' => $user_data->gender,
            'password' => app('hash')->make($params['password']),
        ];
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }
}