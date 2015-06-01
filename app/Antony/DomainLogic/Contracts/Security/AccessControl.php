<?php namespace app\Antony\DomainLogic\Contracts\Security;

interface AccessControl
{

    /**
     * @param $permission_id
     * @param array $roles
     *
     * @return mixed
     */
    public function assignPermission($permission_id, array $roles);

    /**
     * @param $user_id
     * @param array $roles
     *
     * @return mixed
     */
    public function assignRole($user_id, array $roles);

    /**
     * @param $role_id
     * @param array $permissions
     *
     * @return mixed
     */
    public function givePermissionsToRole($role_id, array $permissions);

    /**
     * @param $user_id
     * @param array $roles
     *
     * @return mixed
     */
    public function revokeRole($user_id, array $roles);
}