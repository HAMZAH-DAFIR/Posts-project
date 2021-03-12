<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
     //---------we kill cache route post.show whene updating post-------------

        Cache::forget("show-post-{$post->id}");
        cache::forget("comment-show-{$post->id}");
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
    //-------we delete picture and comments before deletd post -----------

        $post->picture()->delete();
        $post->comments()->delete();
     //    delete  picture physicly and comments before delete physic post and after post is deleted logic =>(picture,comments was deleted)
        if($post->deleted_at)
        {
            $post->comments()->forceDelete();
            $post->picture()->forceDelete();
        }
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restoring(Post $post)
    {
    //-- we restore comments and picture before restore post

        $post->comments()->restore();
        $post->picture()->restore();
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
