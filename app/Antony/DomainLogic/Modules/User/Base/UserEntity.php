<?php namespace app\Antony\DomainLogic\Modules\User\Base;

use app\Antony\DomainLogic\Modules\Authentication\RegisterUser;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class UserEntity extends DataAccessLayer
{

    /**
     * @var string
     */
    protected $objectName = 'users';

    /**
     * @var Authenticatable
     */
    protected $authenticatable;

    /**
     * @var RegisterUser
     */
    private $registrationContract;

    /**
     * @param UserRepository $userRepository
     * @param Authenticatable $authenticatable
     * @param RegisterUser $registrationContract
     */
    public function __construct(UserRepository $userRepository, Authenticatable $authenticatable, RegisterUser $registrationContract)
    {
        parent::__construct($userRepository);
        $this->authenticatable = $authenticatable;
        $this->registrationContract = $registrationContract;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        return $this->repository->paginate(['county', 'roles'], null, 20);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function create($data)
    {
        $this->dataResult = $this->repository->createAccount($data, false);

        return $this->dataResult;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->dataResult = parent::delete($id);

        return $this->dataResult;
    }
}