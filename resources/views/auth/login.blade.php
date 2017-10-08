@extends('layouts.admin')

@section('title')
    Login
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include("admin._partials.messages")
            @endif

            <form role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="f-username">Username</label>
                    <input id="f-username" class="form-control" type="text" name="username" value="{{old('username')}}">

                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="f-password">Password</label>
                    <input id="f-password" class="form-control" type="password" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="remember"> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Login</button>
                    <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>

                    <p class="mt-3">
                        <a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection