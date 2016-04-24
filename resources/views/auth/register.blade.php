@extends('layouts.admin')

@section('title')
    Register
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include("admin._partials.messages")
            @endif

            <p>Your account will need to be manually activated by an administrator before it can be used.</p>

            <form role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="f-username">Username</label>
                    <input id="f-username" class="form-control" type="text" name="username" value="{{ old('username') }}">

                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="f-email">Email</label>
                    <input id="f-email" class="form-control" type="text" name="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
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

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="f-confirm-password">Confirm Password</label>
                    <input id="f-confirm-password" class="form-control" type="password" name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Register</button>
                    <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
                </div>

                <p><a href="{{ url('login') }}">Already Registered?</a></p>
            </form>
        </div>
    </div>
@endsection