@extends('layout')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-8 offset-2">
            <h1 class="text-sm-center">Update Post</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posts.form')
                <button type="submit" name="submit" class="btn btn-warning">create</button>
            </form>
        </div>
    </div>
</div>
@endsection
