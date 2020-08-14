@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

    <div class="card-body">
        <a href="/" class="btn btn-primary">< Back Home</a>
        {{-- <nav class="navbar sticky-top navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">Create New Post</span>
        </nav> --}}
            <div class="card p-3 border-dark mt-3">

                <form action="{{ route('posts.store') }}" method="POST">
                <div><h3>Creating a new post as: {{ Auth::user()->username }}</h3></div>
                    @csrf
                    <br>
                    <div class="form-group">
                        Post Title:
                        <input name="post_title" type="text" class="form-control" maxlength="80" placeholder="Max. 80 characters" value="" />
                    </div>
                    <div class="form-group">
                        Select the category(ies) to publish your post in: (you can select more than one; on PC, hold CTRL (CMD on mac) while you select multiple)
                        <select multiple class="form-control" name="category_id[]">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        Write your post:
                        <textarea name="post_content" class="form-control" placeholder="Maximum lenght of 2000 characters" maxlength="2000" cols="6" rows="12"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </div>
                </form>
            </div>
    </div>
</div></div></div>

@endsection