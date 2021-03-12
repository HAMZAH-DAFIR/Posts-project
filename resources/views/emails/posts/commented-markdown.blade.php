@component('mail::message')
# Introduction

Someone commnted your post : {{ $comment->commentable->title }}
by : {{ $comment->user->name }}
@component('mail::button', ['url' => route('posts.show', ['post'=>$comment->commentable->id])])
Read More
@endcomponent

@component('mail::panel')
    <img src="{{ Storage::url($comment->commentable->picture->path )}}" alt="" class="img-fluid">
    ##{{ $comment->content }}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
