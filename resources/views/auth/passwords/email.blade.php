@extends('layouts.admin')

@section('title')
    Forgot Password
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form role="form" method="POST" action="{{ route('password.email') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="f-email">Email</label>
                    <input id="f-email" class="form-control" type="text" name="email">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                    </button>
                    <a href="{{ route('admin.home') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop