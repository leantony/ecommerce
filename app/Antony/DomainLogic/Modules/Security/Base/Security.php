<?php namespace app\Antony\DomainLogic\Modules\Security\Base;

use app\Antony\DomainLogic\Contracts\Security\AccessControl;
use app\Antony\DomainLogic\Modules\DAL\Base\DataAccessLayer;

class Security extends DataAccessLayer implements AccessControl
{

    /**
     * @param $permission_id
     * @param array $roles
     *
     * @return mixed
     */
    public function assignPermission($permission_id, array $roles)
    {
        // TODO: Implement assignPermission() method.
    }

    /**
     * @param $user_id
     * @param array $roles
     *
     * @return mixed
     */
    public function assignRole($user_id, array $roles)
    {
        // TODO: Implement assignRole() method.
    }

    /**
     * @param $role_id
     * @param array $permissions
     *
     * @return mixed
     */
    public function givePermissionsToRole($role_id, array $permissions)
    {
        // TODO: Implement givePermissionsToRole() method.
    }

    /**
     * @param $user_id
     * @param array $roles
     *
     * @return mixed
     */
    public function revokeRole($user_id, array $roles)
    {
        // TODO: Implement revokeRole() method.
    }

    /**
     * Ok, this presents a commonly used implementation of a SELECT procedure
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
    public function get()
    {
        // TODO: Implement get() method.
    }
}