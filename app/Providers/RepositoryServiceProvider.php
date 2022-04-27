<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\ImageRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register Services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap Services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }
}
