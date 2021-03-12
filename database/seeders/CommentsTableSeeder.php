<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $users=User::all();
        $posts=Post::all();
        // $comments=Comment::factory()->count(500)->make()->each(function($comment) use ($posts,$users){
        //     // $comment->post_id=$posts->random()->id;
        //     $comment->user_id=$users->random()->id;
        //     // $comment->save();
        // });
        Comment::factory()->count(300)->make()->each(function($comment) use($posts,$users){
            $comment->user_id=$users->random()->id;
            $comment->commentable_id=$posts->random()->id;
            $comment->commentable_type='App\Models\Post';
            $comment->save();
        });
        Comment::factory()->count(300)->make()->each(function($comment) use($users){
            $comment->user_id=$users->random()->id;
            $comment->commentable_id=$users->random()->id;
            $comment->commentable_type='App\Models\User';
            $comment->save();
        });
        // $posts->each(function($post) use($comments){
        //     $take=random_int(1,20);
        //     $commentTake=$comments->take($take);
        //     $post->comments()->saveMany($commentTake);
        // });

        // // dd($comments->take(5));
        // $users->each(function($user) use($comments){
        //     $take=random_int(1,10);
        //     $commentTake=$comments->take($take);
        //     $user->comments()->saveMany($commentTake);
        // });
    }
}
