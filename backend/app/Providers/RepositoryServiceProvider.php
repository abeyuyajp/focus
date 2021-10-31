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
        $this->app->bind(\App\Post\Repositories\PostRepository::class, \App\Post\Repositories\EloquentPostRepository::class);
        $this->app->bind(\App\Join\Repositories\JoinRepository::class, \App\Join\Repositories\EloquentJoinRepository::class);
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
