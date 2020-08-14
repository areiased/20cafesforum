@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/" class="btn btn-primary">< Back Home</a>
    <a href="#" class="btn btn-light">View all my posts</a>
    <a href="#" class="btn btn-warning">Ask for support</a>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Deactivate Account
    </button>
    
    <!-- Modal -->
    <form method="POST" action="{{route('user.deactivate', $user_data)}}">
    @csrf
    {{ method_field("PUT") }}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deactivate Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to deactivate your account? You can reactivate it again later by asking an admin or support.
                    </div>
                    <div class="modal-body">
                        <label for="deactivatepassword">Please input your current password to confirm:</label>
                        <input type="password" class="form-control @error('deactivatepassword') is-invalid @enderror" id="deactivatepassword" minlength="8" name="deactivatepassword" placeholder="********" required>
                        @error('deactivatepassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">No, cancel.</button>
                        <button type="submit" class="btn btn-danger">Yes, deactivate my account.</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row justify-content-center pt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Profile - Edit my details') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{route('user.update', $user_data)}}">
                    @csrf
                    {{ method_field("PUT") }}
                        <div class="form-group">
                            <label for="user_realname">Real name: (private, only visible here)</label>
                            <input type="text" class="form-control" id="user_realname" name="user_realname" value="{{ $user_data->user_realname }}" required autocomplete="user_realname">
                            @error('user_realname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username: (public, shown on your posts)</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user_data->username }}" required autocomplete="username">
                            @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email: (private, only visible here)</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user_data->email }}" required autocomplete="email">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="givenpassword">Current Password: (hidden, encrypted)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="givenpassword" name="givenpassword" placeholder="********" required autocomplete="password">
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group pt-2">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="javascript:history.go(0)" class="btn btn-secondary">Revert Changes</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
