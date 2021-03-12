<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\CommentPosted;
use Illuminate\Http\Request;
use App\Mail\CommentedPostmarkdown;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CommentResource;
use App\Jobs\NotifyUserPostWasCommented;
use App\Events\CommentPosted as EventsCommentPosted;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }
    public function show(Post $post){
        return  CommentResource::collection($post->comments()->with('user')->get());
    }
    public function store(Request $request,Post $post)
    {
       $comment= $post->comments()->create([
            'content'=>$request->content,
            'user_id'=>$request->user()->id
        ]);
        //---------send mail emidiatliy
        // Mail::to($post->user->email)->send(new CommentedPostmarkdown($comment));
        // Mail::to($post->user->email)->queue(new CommentedPostmarkdown($comment));
        // Mail::to($post->user->email)->later(now()->addMinutes(1),new CommentedPostmarkdown($comment));
        // Mail::to($post->user->email)->queue()
        // NotifyUserPostWasCommented::dispatch($comment);
        event(new EventsCommentPosted($comment));
        return Redirect()->back()->withStatus('post was created');
    }
}
