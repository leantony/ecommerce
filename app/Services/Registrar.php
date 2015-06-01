<?php namespace App\Services;

use App\Antony\DomainLogic\modules\User\UserRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class Registrar implements RegistrarContract
{
    /**
     * The validation factory implementation.
     *
     * @var ValidationFactory
     */
    protected $validator;

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * The hasher implementation.
     *
     * @var Hasher
     */
    protected $hasher;

    /**
     * Create a new registrar instance.
     *
     * @param  ValidationFactory $validator
     * @param  UserRepository $users
     * @param  Hasher $hasher
     */
    public function __construct(ValidationFactory $validator, UserRepository $users, Hasher $hasher)
    {
        $this->validator = $validator;
        $this->user = $users;
        $this->hasher = $hasher;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return $this->validator->make(
            $data,
            [
                'first_name' => 'required|alpha|between:2,15',
                'last_name' => 'required|alpha|between:2,15',
                'phone' => 'required|digits:9|unique:users',
                'county_id' => 'required|numeric',
                'home_address' => 'required|between:3,50',
                'town' => 'required|between:3,15',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'accept' => 'required',
                // for the recaptcha, if it was included
                'g-recaptcha-response' => 'sometimes|required|recaptcha',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        return $this->user->add(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'county_id' => $data['county_id'],
                'town' => $data['town'],
                'home_address' => $data['home_address'],
                'email' => $data['email'],
                'password' => $this->hasher->make($data['password']),
            ]

        );
    }

}
