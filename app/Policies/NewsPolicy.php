<?php

namespace App\Policies;

use App\User;
use App\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class newsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any newss.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['news-list', 'news-create', 'news-update', 'news-delete']);
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param User $user
     * @param news $news
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user, News $news)
    {
        return $user->hasAnyPermission(['news-list', 'news-create', 'news-update', 'news-delete']);
    }

    /**
     * Determine whether the user can create newss.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('news-create');
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param User $user
     * @param news $news
     * @return mixed
     */
    public function update(User $user, News $news)
    {
        return $user->hasPermissionTo('news-edit');
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param User $user
     * @param news $news
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
        return $user->hasPermissionTo('news-delete');
    }

    /**
     * Determine whether the user can restore the news.
     *
     * @param User $user
     * @param news $news
     * @return mixed
     */
    public function restore(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the news.
     *
     * @param User $user
     * @param news $news
     * @return mixed
     */
    public function forceDelete(User $user, News $news)
    {
        //
    }
}
