<?php

namespace App\Policies;

use App\User;
use App\Visitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any visitors.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['visitor-list', 'visitor-create', 'visitor-update', 'visitor-delete']);
    }

    /**
     * Determine whether the user can view the visitor.
     *
     * @param User $user
     * @param Visitor $visitor
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, Visitor $visitor)
    {
        return $user->hasAnyPermission(['visitor-list', 'visitor-create', 'visitor-update', 'visitor-delete']);
    }

    /**
     * Determine whether the user can create visitors.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('visitor-create');
    }

    /**
     * Determine whether the user can update the visitor.
     *
     * @param User $user
     * @param Visitor $visitor
     * @return mixed
     */
    public function update(User $user, Visitor $visitor)
    {
        return $user->hasPermissionTo('visitor-edit');
    }

    /**
     * Determine whether the user can delete the visitor.
     *
     * @param User $user
     * @param Visitor $visitor
     * @return mixed
     */
    public function delete(User $user, Visitor $visitor)
    {
        return $user->hasPermissionTo('visitor-delete');
    }

    /**
     * Determine whether the user can restore the visitor.
     *
     * @param User $user
     * @param Visitor $visitor
     * @return mixed
     */
    public function restore(User $user, Visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the visitor.
     *
     * @param User $user
     * @param Visitor $visitor
     * @return mixed
     */
    public function forceDelete(User $user, Visitor $visitor)
    {
        //
    }
}
