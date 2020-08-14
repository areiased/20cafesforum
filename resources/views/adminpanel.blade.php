@extends('layouts.app')

@section('content')

<div class="container">
    <a href="/" class="btn btn-primary">< Back Home</a>
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Control Panel') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a href="" class="m-1 btn btn-secondary">View User List</a>
                    <a href="" class="m-1 btn btn-secondary">Edit User Info</a>
                    <a href="" class="m-1 btn btn-danger">Deactivate / Activate User</a>
                    <a href="" class="m-1 btn btn-secondary">View all posts from a user</a>
                    <a href="" class="m-1 btn btn-secondary">View all posts from a category</a>
                    <a href="" class="m-1 btn btn-secondary">View latest posts</a>
                    <a href="" class="m-1 btn btn-secondary">Search for a post title</a>
                    <a href="" class="m-1 btn btn-warning">View/Edit All Admins</a>


                </div>
            </div>
        </div>

</div>


@endsection