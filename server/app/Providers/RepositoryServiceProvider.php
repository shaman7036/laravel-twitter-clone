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
        // user repository
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );

        // tweet repository
        $this->app->bind(
            \App\Repositories\TweetRepositoryInterface::class,
            \App\Repositories\TweetRepository::class
        );

        // like repository
        $this->app->bind(
            \App\Repositories\LikeRepositoryInterface::class,
            \App\Repositories\LikeRepository::class
        );

        // retweet repository
        $this->app->bind(
            \App\Repositories\RetweetRepositoryInterface::class,
            \App\Repositories\RetweetRepository::class
        );

        // reply repository
        $this->app->bind(
            \App\Repositories\ReplyRepositoryInterface::class,
            \App\Repositories\ReplyRepository::class
        );

        // follow repository
        $this->app->bind(
            \App\Repositories\FollowRepositoryInterface::class,
            \App\Repositories\FollowRepository::class
        );

        // pin repository
        $this->app->bind(
            \App\Repositories\PinRepositoryInterface::class,
            \App\Repositories\PinRepository::class
        );
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
