<?php

namespace App\Policies;

use App\User;
use App\Job;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any jobs.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['job-list', 'job-create', 'job-update', 'job-delete']);
    }

    /**
     * Determine whether the user can view the job.
     *
     * @param User $user
     * @param Job $job
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, Job $job)
    {
        return $user->hasAnyPermission(['job-list', 'job-create', 'job-update', 'job-delete']);
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('job-create');
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param User $user
     * @param Job $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        return $user->hasPermissionTo('job-edit');
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param User $user
     * @param Job $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $user->hasPermissionTo('job-delete');
    }

    /**
     * Determine whether the user can restore the job.
     *
     * @param User $user
     * @param Job $job
     * @return mixed
     */
    public function restore(User $user, Job $job)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the job.
     *
     * @param User $user
     * @param Job $job
     * @return mixed
     */
    public function forceDelete(User $user, Job $job)
    {
        //
    }
}
