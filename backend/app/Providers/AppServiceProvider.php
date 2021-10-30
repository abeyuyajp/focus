<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          \App\Post\Repositories\PostRepository::class,
            \App\Post\Repositories\EloquentPostRepository::class
        );

        $this->app->bind(
            \App\Join\Repositories\JoinRepository::class,
            \App\Join\Repositories\EloquentJoinRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\App::environment(['production'])) {
            \URL::forceScheme('https');
        }
    }
}
