<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    SubjectInterface,
    UserInterface,
    TagInterface,
    ProjectInterface,
    CommentInterface,
    SectionInterface,
    PageInterface
};
use App\Repositories\Entities\{
    SubjectRepository,
    UserRepository,
    TagRepository,
    ProjectRepository,
    CommentRepository,
    SectionRepository,
    PageRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SubjectInterface::class, SubjectRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(CommentInterface::class, CommentRepository::class);
        $this->app->bind(SectionInterface::class, SectionRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
    }
}
