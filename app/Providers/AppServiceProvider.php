<?php

namespace App\Providers;

use App\Http\ViewComposer\Activity;
use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\View;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        View::composer('posts.side',Activity::class);
        Post::observe(PostObserver::class);
    }
}
