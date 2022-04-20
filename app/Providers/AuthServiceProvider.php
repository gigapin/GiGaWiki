<?php

namespace App\Providers;

use App\Models\Setting;
use App\Policies\SubjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Subject;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Subject::class => SubjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('settings', function(User $user) {
        //     return $user->role_user->role_id == 1;
        // });

        // Gate::define('create-subjects', function(User $user) {
        //     return $user->role_user->role_id == 1;
        // });

        // Gate::define('update-subjects', function(User $user) {
        //     return $user->role_user->role_id == 1;
        // });

        // Gate::define('delete-subjects', function(User $user) {
        //     return $user->role_user->role_id == 1;
        // });

    }
}
