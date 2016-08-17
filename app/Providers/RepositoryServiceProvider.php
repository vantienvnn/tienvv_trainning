<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('\App\Repositories\HomeRepository', '\App\Repositories\HomeRepositoryEloquent');
        $this->app->bind('\App\Repositories\WordRepository', '\App\Repositories\WordRepositoryEloquent');
        $this->app->bind('\App\Repositories\CategoryRepository', '\App\Repositories\CategoryRepositoryEloquent');
        //:end-bindings:
    }
}
