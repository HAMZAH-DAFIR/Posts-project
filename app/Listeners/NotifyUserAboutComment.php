<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Mail\CommentedPostmarkdown;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifyUserPostWasCommented;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Comment $event)
    {
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostmarkdown($event->comment));
        NotifyUserPostWasCommented::dispatch($event->comment);


    }
}
