
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3><a class="btn btn-primary" href="{{route('posts.create')}}">Create New Post</a>
                    {{ __('Dashboard') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                
                <div class="card-body mt-0 pt-0">
                    @foreach($categories as $category)
                        <div class="card border-dark mb-3">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a class="btn btn-dark mr-2" href="/category={{$category->id}}">View All Posts</a>
                                    {{ $category->category_title }}
                                </h3>
                                <?
                                    // nesta especifica categoria, vai buscar exatamente os ultimos 5 posts, ordem do mais recente para mais antigo
                                    $lastPostsFromThisCategory = \App\Category::find($category->id)->posts()->get()->reverse()->take(5);
                                ?>
                                @foreach ($lastPostsFromThisCategory as $post)
                                <? $username = \App\User::find($post->post_author)->username ?>
                                <div class="list-group">
                                    <a href="/category/post/view?category={{$category->id}}&post={{$post->id}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$post->post_title}}</h5>
                                        <small style="color:black">Last Updated: {{$post->updated_at}} || Created: {{$post->created_at}}</small>
                                        </div>
                                        <small>Created by: {{$username}}
                                        <? $lastComment = \App\Post::find($post->id)->comments()->get()->last(); 
                                            $lastAuthorUser = \App\User::find($lastComment['comment_author']);
                                            $commentsCount = \App\Post::find($post->id)->comments()->get()->count();
                                            echo ', ' . $commentsCount . ' comment(s).';
                                        if ($lastComment != null) {
                                            echo ' Last commented by: '. $lastAuthorUser['username'] .', at '. $lastComment['created_at'] 
                                        ;}?>
                                        </small>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

