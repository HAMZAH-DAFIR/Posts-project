@extends('layout')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-8 offset-2">
            <h1 class="text-sm-center">Update Post</h1>
            <form action="{{ route('posts.update', ['post'=>$post->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts.form')
                <button type="submit" name="submit" class="btn btn-primary">update</button>
                </form>
        </div>
    </div>
</div>

@endsection
