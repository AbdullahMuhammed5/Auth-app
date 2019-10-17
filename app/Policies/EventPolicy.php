<?php

namespace App\Policies;

use App\Event;
use App\User;
use App\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any event.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['event-list', 'event-create', 'event-update', 'event-delete']);
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function view(User $user)
    {
        return $user->hasAnyPermission(['event-list', 'event-create', 'event-update', 'event-delete']);
    }

    /**
     * Determine whether the user can create newss.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('event-create');
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param User $user
     * @param Event $event
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        return $user->hasPermissionTo('event-edit');
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param User $user
     * @param Event $event
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        return $user->hasPermissionTo('event-delete');
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
