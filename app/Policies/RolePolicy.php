<?php

namespace App\Policies;

use App\Staff;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('role-list');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param User $user
     * @param Role $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->hasPermissionTo('role-list');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('role-create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasPermissionTo('role-edit');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasPermissionTo('role-delete');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
