@extends('layouts.app')

@section('adminbuttons')
<? if (Auth::user() != null && Auth::user()->user_role == 1) {
    echo '
<form method="POST" action="'. route('category.deactivate', $category) .'">
    '. method_field("PUT") .'
    ' . csrf_field() . '
    <input type="hidden" name="id" value="'. $category->id .'"/>
    <button class="btn btn-warning mr-2" type="submit">ADMIN - Deactivate this Category</button>
</form>
';}?>
@endsection

@section ('content')

    <div class="row justify-content-center pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>
                    <a href="/" class="btn btn-primary">< Back Home</a>
                    <a class="btn btn-primary" href="{{route('posts.create')}}">Create New Post</a>
                    {{ $category->category_title }}
                </h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($posts as $post)
                    <? $username = \App\User::find($post->post_author)->username ?>
                    <div class="list-group">
                        
                        <a href="/category/post/view?category={{$category->id}}&post={{$post->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$post->post_title}}</h5>
                            <small style="color:black">Last Updated: {{$post->updated_at}}, Created: {{$post->created_at}}</small>
                            </div>
                            <p class="mb-1">{{$post->post_trimmed_desc}}</p>
                            <small>Created by {{$username}}
                                <? $lastComment = \App\Post::find($post->id)->comments()->get()->last(); 
                                    $lastAuthorUser = \App\User::find($lastComment['comment_author']);
                                    $commentsCount = \App\Post::find($post->id)->comments()->get()->count();
                                    echo ', ' . $commentsCount . ' comment(s).';
                                        if ($lastComment != null) {
                                            echo ' Last commented by: '. $lastAuthorUser['username'] .', at '. $lastComment['created_at'] 
                                ;} 
                                ?>
                            
                            </small>
                        </a>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection