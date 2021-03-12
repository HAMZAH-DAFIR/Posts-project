<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Post::class => PostPolicy::class,
         Comment::class => CommentPolicy::class,
         User::class=>UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('secret.page',function(User $user){
            return $user->is_admin;
        });
        // Gate::resource('posts', PostPolicy::class);
        //
        // Gate::define('posts.update',function(User $user,Post $post){
        //     return $user->id===$post->user_id;
        // });
        // Gate::define('posts.delete',function(User $user,Post $post){
        //     return $user->id===$post->user_id;
        // });
        Gate::before(function($user,$ability){
            if($user->is_admin && in_array($ability,['update','restore'])) return true;
        });
        // Gate::before(function($user,$post,$ability){
        //     return ($user->id===$post->user_id && in_array($ability,['delete']))?? false;
        // });
    }
}
