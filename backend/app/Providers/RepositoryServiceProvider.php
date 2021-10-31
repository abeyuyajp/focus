<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 下記のサービス(クラス)をサービスコンテナに登録
        $this->app->bind(\App\Repositories\Post\PostRepository::class, \App\Repositories\Post\EloquentPostRepository::class);
        $this->app->bind(\App\Repositories\Join\JoinRepository::class, \App\Repositories\Join\EloquentJoinRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
