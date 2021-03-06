<?php

namespace App\Policies;

use App\User;
use App\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cities.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('city-list');
    }

    /**
     * Determine whether the user can view the city.
     *
     * @param User $user
     * @param City $city
     * @return mixed
     */
    public function view(User $user, City $city)
    {
        return $user->hasPermissionTo('city-list');
    }

    /**
     * Determine whether the user can create cities.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('city-create');
    }

    /**
     * Determine whether the user can update the city.
     *
     * @param User $user
     * @param City $city
     * @return mixed
     */
    public function update(User $user, City $city)
    {
        return $user->hasPermissionTo('city-edit');
    }

    /**
     * Determine whether the user can delete the city.
     *
     * @param User $user
     * @param City $city
     * @return mixed
     */
    public function delete(User $user, City $city)
    {
        return $user->hasPermissionTo('city-delete');
    }

    /**
     * Determine whether the user can restore the city.
     *
     * @param User $user
     * @param City $city
     * @return mixed
     */
    public function restore(User $user, City $city)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the city.
     *
     * @param User $user
     * @param City $city
     * @return mixed
     */
    public function forceDelete(User $user, City $city)
    {
        //
    }
}
