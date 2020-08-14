@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a class="btn btn-primary m-2 p-2" href="/category={{$category->id}}">< Back to {{$category->category_title}}</a>
            <div class="card border-dark">
                <div class="card-header">
                    <h3>
                    {{ $post->post_title }}</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <? $username = \App\User::find($post->post_author)->username ?>
                    <div class="card border-light">
                        <div class="card-body">
                            <? echo $post->post_content ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">By {{ $username }}, {{$post->created_at}}
                        <? if ($post->created_at != $post->updated_at) { echo ', Last edited at '. $post->updated_at ; }?>
                        </small>
                    <? 
                    if (Auth::user() != null) {
                        if ($post->post_author == Auth::user()->id || Auth::user()->user_role == 1 ) {
                            
                            echo '

                            <button class="btn btn-secondary ml-2" type="button" data-toggle="collapse" data-target="#editPost' . $post->id . '" aria-expanded="false" aria-controls="editPost' . $post->id . '">Edit Post</button>
                            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#deletePost' . $post->id . '" aria-expanded="false" aria-controls="deletePost' . $post->id . '">Delete Post</button>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="editPost' . $post->id . '">
                                            <div class="card card-body">
                                                
                                                <form method="POST" action="' . route('posts.update', $post) . '">
                                                    ' . method_field("PUT") .  '
                                                    ' . csrf_field() . '
                                                    <input type="hidden" required id="post_id" name="post_id" value="' . $post->id . '">
                                                    <input type="text" disabled required id="username" name="username" class="form-control" value="Editing as: ' . Auth::user()->username . '">
                                                    <input type="text" max-lenght="80" required id="post_title" name="post_title" class="form-control" value="' . $post->post_title . '">
                                                    <textarea class="form-control mt-2" name="post_content" id="post_content" cols="20" rows="5" minlength="2" maxlength="1000" required>'. str_replace("<br />", "", $post->post_content) . '</textarea>
                                                    ';
                                                            if ( ( Auth::user()->user_role ) == 1 ) {
                                                                echo '<span class=" badge badge-warning">ADMIN</span>';
                                                            };
                                                    echo '
                                                    <button class="btn btn-primary mt-1" type="submit">Submit edits</button>
                                                    <button class="btn btn-secondary w-25 mt-1" type="button" data-toggle="collapse" data-target="#editPost' . $post->id . '" aria-expanded="false" aria-controls="editPost' . $post->id . '">Cancel</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="deletePost' . $post->id . '">
                                            <div class="card card-body">
                                                <form action="' . route('posts.destroy', $post) . '" method="POST">
                                                    ' . method_field("DELETE") .  '
                                                    ' . csrf_field() . '
                                                    Are you sure? This will delete / deactivate this post! 
                                                    <button class="btn btn-success ml-2" type="button" data-toggle="collapse" data-target="#deleteComment' . $post->id . '" aria-expanded="false" aria-controls="deleteComment' . $post->id . '">Cancel - Keep the Post UP!</button>
                                                    <button class="btn btn-danger ml-2" type="submit">
                                                        CONFIRM - DELETE POST
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            ';
                        } // só aparece se o user for o criador do post
                    }
                    ?>
                    </small>
                    </div>
                    
                    <div class="dropdown-divider mt-3 mb-3"></div>
                    <p class="ml-2">Comments</p>
                    <div class="dropdown-divider mt-0 mb-3"></div>
                    
                    @foreach ($comments as $comment)
                    <? $author_id = App\User::find($comment->comment_author)->id; ?>
                        <div class="card border-light bg-light mb-3" style="max-width: 100%">
                            <div class="card-header">{{ $username }} said:</div>
                            <div class="card-body text-dark">
                                <? echo $comment->content ?>
                                <br><br>
                                <p><small><? if ($comment->created_at != $comment->updated_at) { echo '[ Edited ]'; }?></small></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Created at {{$comment->created_at}}<? if ($comment->created_at != $comment->updated_at) { echo ', Last edited at: '. $comment->updated_at ; }?></small>
                            <? if (Auth::user() != null ) {
                                    if (Auth::user()->id == $author_id || Auth::user()->user_role == 1) {   // admins podem interagir com todos os comments
                                echo '
                                <button class="btn btn-light btn-small ml-2" type="button" data-toggle="collapse" data-target="#editComment' . $comment->id . '" aria-expanded="false" aria-controls="editComment' . $comment->id . '">Edit Comment</button>
                                <button class="btn btn-light btn-small" type="button" data-toggle="collapse" data-target="#deleteComment' . $comment->id . '" aria-expanded="false" aria-controls="deleteComment' . $comment->id . '">Delete Comment</button>
                            ';
                            }}?>
                            </div>
                            <? 
                            if (Auth::user() != null ) {
                            if (Auth::user()->id == $author_id || Auth::user()->user_role == 1) {   // admins podem interagir com todos os comments
                                echo '

                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="editComment' . $comment->id . '">
                                            <div class="card card-body">
                                                
                                                <form method="POST" action="' . route('comment.update', $comment) . '">
                                                    ' . method_field("PUT") .  '
                                                    ' . csrf_field() . '
                                                    <input type="hidden" required id="post_id" name="post_id" value="' . $post->id . '">
                                                    <input type="text" disabled required id="username" name="username" class="form-control" value="Editing as: ' . Auth::user()->username . '">
                                                    <textarea class="form-control mt-2" name="comment_content" id="comment_content" cols="20" rows="5" minlength="2" maxlength="1000" required>'. str_replace("<br />", "", $comment->content) . '</textarea>
                                                    ';
                                                            if ( ( Auth::user()->user_role ) == 1 ) {
                                                                echo '<span class=" badge badge-warning">ADMIN</span>';
                                                            };
                                                    echo '
                                                    <button class="btn btn-primary mt-1" type="submit">Submit edits</button>
                                                    <button class="btn btn-secondary mt-1" type="button" data-toggle="collapse" data-target="#editComment' . $comment->id . '" aria-expanded="false" aria-controls="editComment' . $comment->id . '">Cancel</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">  
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="deleteComment' . $comment->id . '">
                                            <div class="card card-body">
                                                <form action="' . route('comment.destroy', $comment) . '" method="POST">
                                                    ' . method_field("DELETE") .  '
                                                    ' . csrf_field() . '
                                                    Are you sure? You will delete this comment for good!
                                                    <button class="btn btn-success ml-2" type="button" data-toggle="collapse" data-target="#deleteComment' . $comment->id . '" aria-expanded="false" aria-controls="deleteComment' . $comment->id . '">Cancel - Keep comment</button>
                                                    <button class="btn btn-danger ml-2" type="submit">
                                                        CONFIRM - DELETE COMMENT
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                            } }?>
                        </div>
                    @endforeach

                    <? if (Auth::user() != null) { echo '
                    <div class="dropdown-divider mt-0 mb-3"></div>
                    <div class="card border-secondary bg-light mb-3 d-flex align-content-center" style="max-width: 100%">
                        <div class="card-header">Leave a comment on this post:</div>
                        <div class="card-body text-dark">

                        <form method="POST" action="' . route('comment.store') . '">
                            ' . csrf_field() . '
                            <input type="hidden" required id="post_id" name="post_id" value="' . $post->id . '">
                            <input type="text" disabled required id="username" name="username" class="form-control" value="Posting as: ' . Auth::user()->username . '">
                            <textarea class="form-control mt-2" name="comment_content" id="comment_content" cols="20" rows="5" minlength="2" maxlength="1000" placeholder="Write your comment, max 1000 characters" required></textarea>
                            <button class="btn btn-primary mt-1" type="submit">Submit comment</button>
                        </form>

                        </div>
                    </div>
                    ';} ?>
                    <? if (Auth::user() == null)
                    echo '<a href="/login">Login</a> to leave a comment';
                    ?>
                    <div class="dropdown-divider"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function goBack() {
        window.history.back();
    }
    </script>

@endsection
