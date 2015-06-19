<?php namespace app\Antony\DomainLogic\Modules\Security;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Models\Permission;
use Illuminate\Container\Container;

class PermissionsRepo extends EloquentRepository
{

    protected $roles;

    protected $user;

    /**
     * @param Container $container
     * @param UserRepository $userRepository
     * @param RolesRepository $rolesRepository
     */
    public function __construct(Container $container, UserRepository $userRepository, RolesRepository $rolesRepository)
    {
        parent::__construct($container);

        $this->user = $userRepository;

        $this->roles = $rolesRepository;
    }

    /**
     * @param $id
     * @param array $roles
     *
     * @return int
     */
    public function assign($id, array $roles)
    {

        $permission = $this->find($id);

        //dd($permission);
        foreach ($roles as $role) {

            // find the role in the db
            $this->roles->find($role)->attachPermission($permission);
            //$role->attachPermission($permission);
        }

        return 1;

    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Permission::class;
    }
}