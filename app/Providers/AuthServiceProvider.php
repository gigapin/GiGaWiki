<?php

namespace App\Providers;

use App\Models\Setting;
use App\Policies\SubjectPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SectionPolicy;
use App\Policies\PagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Subject;
use App\Models\Project;
use App\Models\Section;
use App\Models\Page;
use App\Policies\SettingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Subject::class => SubjectPolicy::class,
        Project::class => ProjectPolicy::class,
        Section::class => SectionPolicy::class,
        Page::class => PagePolicy::class,
        Setting::class => SettingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
