<div class="card mt-5" >
    <div class="card-header ">
        <h2>{{ $slot }}</h2>
    </div>
    <ul class="list-group list-group-flush">
        @foreach( $items  as $item)
      <li class="list-group-item">
          <span class="badge badge-{{ $type }}">{{ $item->$count }}</span>

        @if(!empty(trim($route)))
        <a href="{{ route('posts.show',['post'=>$item->id]) }}">{{ $item->$prop }}</a>
        @else
        <x-avatar width='40' height='40'></x-avatar>

        {{ $item->$prop }}
        @endif
    </li>
      @endforeach
    </ul>
  </div>
