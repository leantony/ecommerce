<?php namespace app\Antony\DomainLogic\Modules\Security;

use app\Antony\DomainLogic\Modules\DAL\EloquentRepository;
use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Models\Role;
use Illuminate\Container\Container;

class RolesRepository extends EloquentRepository
{

    /**
     * @param Container $container
     * @param UserRepository $userRepository
     */
    public function __construct(Container $container, UserRepository $userRepository)
    {
        parent::__construct($container);

        $this->user = $userRepository;
    }


    /**
     * Assign roles to a user
     *
     * @param $userID
     * @param array $roles
     *
     * @return int
     */
    public function assign($userID, array $roles)
    {
        $user = $this->user->find($userID);

        foreach ($roles as $role) {

            // skip roles that already belong to the user
            if ($user->hasRole($this->find($role)->name)) {

                continue;
            }

            $user->roles()->attach($role);

        }

        return 1;
    }

    /**
     * Assign permissions to a role
     *
     * @param $roleID
     * @param array $permissions
     *
     * @return int
     */
    public function givePermissions($roleID, array $permissions)
    {

        $role = parent::find($roleID);

        $role->attachPermissions($permissions);

        return 1;
    }

    /**
     * Revoke a user's roles
     *
     * @param $userID
     * @param array $roles
     *
     * @return int
     */
    public function revoke($userID, array $roles)
    {

        $user = $this->user->find($userID);

        $user->roles()->detach($roles);

        return 1;
    }

    /**
     * Specify the Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Role::class;
    }
}