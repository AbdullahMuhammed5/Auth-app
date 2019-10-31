<?php

namespace App\Policies;

use App\User;
use App\Folder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any news.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['folder-create']);
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param User $user
     * @param Folder $folder
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, Folder $folder)
    {
        $isAuthorized = in_array($folder->id, $user->staff->folders->pluck('id')->all());
        return $user->hasAnyPermission(['folder-create']) && $isAuthorized;
    }

    /**
     * Determine whether the user can create news.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('folder-create');
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param User $user
     * @param Folder $folder
     * @return mixed
     * @throws \Exception
     */
    public function update(User $user, Folder $folder)
    {
        $isAuthorized = in_array($folder->id, $user->staff->folders->pluck('id')->all());
        return $user->hasAnyPermission(['folder-create']) && $isAuthorized;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param User $user
     * @param Folder $folder
     * @return mixed
     * @throws \Exception
     */
    public function delete(User $user, Folder $folder)
    {
        $isAuthorized = in_array($folder->id, $user->staff->folders->pluck('id')->all());
        return $user->hasAnyPermission(['folder-create']) && $isAuthorized;
    }

}
