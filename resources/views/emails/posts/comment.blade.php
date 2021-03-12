<p>
    Someone comment your Post
    <a href="{{ route('posts.show',['post'=>$comment->commentable->id]) }}">{{ $comment->commentable->title }}</a>
</p>
<p>
    <a href="">{{ $comment->user->name }}</a>
</p>
<p>
    {{ $comment->content }}
</p>
