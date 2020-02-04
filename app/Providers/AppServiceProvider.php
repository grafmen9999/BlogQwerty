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
        $this->app->bind('NoAnswer', function () {
            return new \App\Services\Filter\Post\NoAnswer();
        });

        $this->app->bind('My', function () {
            return new \App\Services\Filter\Post\My();
        });

        $this->app->bind('Popular', function () {
            return new \App\Services\Filter\Post\Popular;
        });

        $this->app->bind('Tag', '\App\Services\Filter\Post\Tag');
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
        $this->app->bind('App\Repositories\PostRepositoryInterface', 'App\Repositories\PostRepositoryEloquent');
    }
}
