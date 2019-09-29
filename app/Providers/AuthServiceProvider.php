<?php

namespace App\Providers;

use App\City;
use App\Job;
use App\Policies\CityPolicy;
use App\Policies\JobPolicy;
use App\Policies\RolePolicy;
use App\Policies\StaffPolicy;
use App\Staff;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        City::class => CityPolicy::class,
        Job::class => JobPolicy::class,
        Staff::class => StaffPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });;
    }
}
