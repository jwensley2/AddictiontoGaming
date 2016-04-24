@extends('layouts.admin')

@section('title')
    Forgot Password
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include("admin._partials.messages")
            @endif

            <form role="form" method="POST" action="{{ url('/password/reset') }}">
                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="f-email">Email</label>
                    <input id="f-email" class="form-control" type="text" name="email" value="{{ $email or old('email') }}">

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

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Reset Password</button>
                    <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop