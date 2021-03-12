@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card mt-5">
                {{-- ---------------------card header -----------------------------}}
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <h2 class="@if($post->trashed()) text-muted @endif d-inline text-primary" >{{ $post->title }}</h2>
                            <x-date-user  :date="$post->created_at" :name="$post->user->name"></x-date-user>
                            @if($post->trashed())
                            <x-badge type='info y-auto'> deleted</x-badge>
                            @endif
                        </div>
                        <div>
                            @if($post->created_at->diffInHours()<1)
                            <x-badge type="primary">New</x-badge>
                            @endif
                        </div>
                    </div>
                    <div>
                        <x-tags :tags="$post->tags"></x-tags>
                    </div>
                    @if($post->picture)
                    <div class="mx-auto mt-4">
                        {{-- <img src="{{ Storage::url($post->picture->path ?? null) }}" class="img-fluid rounded " alt=""> --}}
                        <img src="{{ $post->picture->url()  }}" class="img-fluid rounded " alt="">

                    </div>
                    @endif
                </div>
                <div class="card-body"><h5>{{ $post->content }}</h5></div>
                <div class="card-footer">
                    <div class="d-flex float-right" >
                        <div class="ml-3"> {{ $post->deleted_at? 'Deleted at : '. $post->deleted_at->diffForHumans(): $post->created_at->diffForHumans() }}
                    </div>
                     </div>
                    {{-- ------------- Add comment ------------------ --}}
                    <form action="{{ route('posts.comments.store',['post'=>$post]) }}" method="post" >
                        @csrf
                        {{-- --------- post id value hidden ----------------- --}}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="group-form my-4">
                            <div class="d-flex">
                                <div class="d-flex col-sm-4">
                                    {{-- <img src="{{ Storage::url(Auth::user()->image->path) }}" class="rounded-circle my-auto img-fluid" alt=""> --}}
                                    {{-- <p>{{ Storage::url(Auth::user()->image->path) }}</p> --}}
                                    @auth
                                    <x-avatar width='40' height='40' ></x-avatar>
                                    <h4 class="d-inline text-sm-4 text-small text-info my-auto"> {{ Auth::user()->name ??'' }}</h4> <!--user name from class Auth-->

                                    @endauth
                                </div>
                                <div class="col-sm-8 d-flex">
                                    <textarea rows="1" class="form-control my-auto " name="content"></textarea>
                                    <div class="group-form my-4 rigth-0">
                                        <input type="submit" value="Comment" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <h3>{{ $post->comments->count() }} Comments</h3>
                    <br>
                    {{-- ------------------Commnets --------------------- --}}
                        @foreach ($post->comments as $comment)
                    <div class="d-block  shadow p-1 mb-4 bg-dark">
                        <div class="d-flex text-center">
                            <div class="d-flex col-sm-10 ">
                                <x-avatar width='40' height='40' :src='$comment->user->image->path??null'></x-avatar>
                                <h4 class="d-inline  my-auto"> {{ $comment->user->name }}</h4>
                                <div class="text-muted ml-4 my-auto">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                            {{-- ---------------user commentd and user's post can see dropdawn---------- --}}
                            @can('delete',[$comment, $post->user_id ])
                            <div class="dropdown col-sm-2 my-auto">
                                <button type="button" class="btn btn-large dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu">
                                    {{-- -------- user commented and user's post can delete comment---------- --}}
                                        @can('delete',[$comment, $post->user_id ])
                                    <form action="{{ route('comments.destroy',['comment'=>$comment->id]) }}" method="POST" class="dropdown-item">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="post" value="{{ $post->user_id }}">
                                        <button class="dropdown-item" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                    @can('update',[$comment])
                                    <form action="" class="dropdown-item">
                                        <button  type="button" class="btn btn-large dropdown-toggle dropdown-item" data-toggle="dropdown">Edit</button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                                @endcan
                        </div>
                        <div class="col-sm-10 ml-5 p-3">
                            <p>{{ $comment->content }}</p>
                        </div>
                        <div class="dropdown-menu"></div>
                    </div>
                        @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            @include('posts.side')
        </div>
    </div>
</div>
@endsection
