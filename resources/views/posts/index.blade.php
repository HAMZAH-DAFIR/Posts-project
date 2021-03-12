@extends('layout')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 ">

                {{-- <div class="nav nav-tab nav-stacked my-5">
                    <a href="{{ route('posts.index') }}" class="nav-link @if($tab == 'list') active @endif">List</a>
                    <a href="{{ route('archive') }}" class="nav-link @if($tab == 'archive') active @endif">Archive</a>
                    <a href="{{ route('all') }}" class="nav-link @if($tab == 'all') active @endif">All</a>
                </div> --}}

            <div class="my-3 mt-5">
                <h4> {{ trans_choice('post',$posts->count() ) }}</h4>
            </div>
                @forelse($posts as $post)
                    <!-- component -->
 <!----------------------------------------- post card --------------------------------------------------------------->
            <div class="card mt-4">
                {{-- ---------------------card header -----------------------------}}
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div >
                            <div class="d-flex">
                                <x-avatar height='60' width='60' :src='$post->user->image->path??null'></x-avatar>
                                <x-date-user  :date="$post->created_at" :name="$post->user->name"></x-date-user>
                            </div>

                            <h2 class="@if($post->trashed()) text-muted @endif d-inline text-primary" >{{ $post->title }}</h2>


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
                    {{-- <p>{{ Storage::url(null) ?? null}}</p> --}}
                    {{-- <p>{{ $post->picture->path }}</p> --}}
                    @if($post->picture)
                    <div class="mx-auto mt-4">
                        {{-- <img src="{{ Storage::url($post->picture->path ?? null) }}" class="img-fluid rounded " alt=""> --}}
                        <img src="{{ $post->picture->url()  }}" class="img-fluid rounded " alt="">

                    </div>
                    @endif



                </div>
                {{-----------------card body --------------------}}
                <div class="card-body @if($post->trashed()) text-muted @endif">
                    <h5 class="">{{ $post->content }}</h5>
                    <img src="" class="img-fluid rounded" alt="">
                </div>
                {{-- -----------------card footer -----------------------------}}
                <div class="card-footer d-flex justify-content-between">
                    <div class="d-flex justify-content-between">
                        @if(!$post->deleted_at)
                        {{-- ---------------btn Show -----------if post is deleted --}}
                        <form action="{{ route('posts.show', ['post'=>$post->id]) }}" method="GET" class="ml-2">
                            @csrf
                            <x-button type="primary">Show</x-button>
                        </form>
                        {{-- --------- btn Edit-----------user  can edit her post and admin also edit her post and auther posts--}}
                        @can('update', $post)
                        <form action="{{ route('posts.edit',['post'=>$post->id]) }}" method="GET" class="ml-2">
                            <x-button type="warning">Edit</x-button>
                        </form>
                        @endcan
                        <form action="{{ route('posts.destroy',['post'=>$post->id]) }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        {{-- ---------user can delete her post -------- --}}
                        @can('delete', $post)
                            <x-button type="danger">Delete</x-button>
                        @endcan
                        {{-- ---------- user can't delete author user's post -------- --}}
                        @cannot('delete',$post)
                            <x-badge type="danger"> You can't deleted</x-badge>
                        @endcannot
                        </form>
                        @else
                        {{-- --------------- btn restore ------ admin only can restore posts --}}
                        @can('restore',$post)
                        <form action="{{ route('restore',['id'=>$post->id]) }}" method="GET" class="ml-2">
                            @csrf
                            @method('PATCH')
                            <x-button type="success">Restore</x-button>
                        </form>
                        @endcan
                        {{-- ------------------btn force delete ------- admin only can force delete posts---- --}}
                        @can('forcedelete',$post)
                        <form action="{{ route('forcedelete',['id'=>$post->id]) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <x-button type="danger">Force Delete</x-button>
                        </form>
                        @endif
                        @endcan
                    </div>
                    <div class="d-flex justify-content-between" >
                       <div class="text-info">{{ $post->comments_count ?$post->comments_count.' Comment(s)':'no comments yet' }}</div>
                       <div class="ml-3"> {{ $post->deleted_at? 'Deleted at : '. $post->deleted_at->diffForHumans(): $post->created_at->diffForHumans() }}</div>

                    </div>
                </div>
            </div>
                    @empty <h1>not found</h1>
                    @endforelse
        </div>
{{-- ------------------------------------- cards --------------------------------------- --}}
        <div class="col-md-4 ">
            <form action="{{ route('search',['tab'=>'list']) }}" method="GET">
                @csrf
                <div class="input-group my-3">
                    <input type="text" class="form-control" placeholder="Search" name="searching">
                    <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Go</button>
                    </div>
                </div>
            </form>
            @include('posts.side')
        </div>
    </div>
</div>

@endsection
