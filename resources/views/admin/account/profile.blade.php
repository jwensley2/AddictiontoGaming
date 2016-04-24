@extends('layouts.admin')

@section('title')
    Profile
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include('admin._partials.messages')
            @endif

            @if (isset($errors))
                @include('admin._partials.errors')
            @endif

            <h3>Edit Profile</h3>

            <form action="{{action('Admin\AccountController@postProfile')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="f-username">Username</label>
                    <input id="f-username" class="form-control" type="text" name="username" value="{{ $user->username }}">
                </div>

                <div class="form-group">
                    <label for="f-email">Email</label>
                    <input id="f-email" class="form-control" type="text" name="email" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <button class="btn btn-warning" type="reset">Reset</button>
                    <a href="{{ route('admin') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <h3>Change Password</h3>

            <form action="{{action('Admin\AccountController@postChangePassword')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="f-password">Password</label>
                    <input id="f-password" class="form-control" type="password" name="password">
                </div>

                <div class="form-group">
                    <label for="f-confirm-password">Confirm Password</label>
                    <input id="f-confirm-password" class="form-control" type="password" name="password_confirmation">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Change Password</button>
                </div>
            </form>
        </div>
    </div>
@stop