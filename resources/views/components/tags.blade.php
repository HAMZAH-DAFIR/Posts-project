
@foreach($tags as $tag)
    <a href="{{route('tags',['id'=>$tag->id])}}" class="badge badge-success">{{ $tag->name }}</a>
@endforeach
