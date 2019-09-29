<?php

namespace App\Policies;

use App\User;
use App\Staff;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any staff.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['staff-list', 'staff-create', 'staff-update', 'staff-delete']);
    }

    /**
     * Determine whether the user can view the staff.
     *
     * @param User $user
     * @param Staff $staff
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, Staff $staff)
    {
        return $user->hasAnyPermission(['staff-list', 'staff-create', 'staff-update', 'staff-delete']);
    }

    /**
     * Determine whether the user can create staff.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('staff-create');
    }

    /**
     * Determine whether the user can update the staff.
     *
     * @param User $user
     * @param Staff $staff
     * @return mixed
     */
    public function update(User $user, Staff $staff)
    {
        return $user->hasPermissionTo('staff-edit');
    }

    /**
     * Determine whether the user can delete the staff.
     *
     * @param User $user
     * @param Staff $staff
     * @return mixed
     */
    public function delete(User $user, Staff $staff)
    {
        return $user->hasPermissionTo('staff-delete');
    }

    /**
     * Determine whether the user can restore the staff.
     *
     * @param User $user
     * @param Staff $staff
     * @return mixed
     */
    public function restore(User $user, Staff $staff)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the staff.
     *
     * @param User $user
     * @param Staff $staff
     * @return mixed
     */
    public function forceDelete(User $user, Staff $staff)
    {
        //
    }
}
