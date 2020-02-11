<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Just method for create filter dependency
     *
     * @return void
     */
    private function makeFilters()
    {
        $this->app->bind('NoAnswer', \App\Services\Filter\Post\NoAnswer::class);

        $this->app->bind('My', \App\Services\Filter\Post\My::class);

        $this->app->bind('Popular', \App\Services\Filter\Post\Popular::class);

        $this->app->bind('Tag', \App\Services\Filter\Post\Tag::class);
    }

    private function makeRepositories()
    {
        $this->app->bind(
            'App\Repositories\PostRepositoryInterface',
            'App\Repositories\PostRepositoryEloquent'
        );
        
        $this->app->bind(
            'App\Repositories\CategoryRepositoryInterface',
            'App\Repositories\CategoryRepositoryEloquent'
        );
        
        $this->app->bind(
            'App\Repositories\TagRepositoryInterface',
            'App\Repositories\TagRepositoryEloquent'
        );
        
        $this->app->bind(
            'App\Repositories\CommentRepositoryInterface',
            'App\Repositories\CommentRepositoryEloquent'
        );
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->makeFilters();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->makeRepositories();
    }
}
