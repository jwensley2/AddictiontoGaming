@extends('layouts.admin')

@section('title')
Register
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if ($errors)
				@foreach ($errors as $error)
					<div class="alert alert-danger">{{ $error }}</div>
				@endforeach
			@endif

			<p>Your account will need to be manually activated by an administrator before it can be used.</p>

			{{ Form::open(array('action' => array('AccountController@postRegister'))) }}
				<div class="form-group">
					<label for="f-username">Username</label>
					<input id="f-username" class="form-control" type="text" name="username" value="{{ Input::old('username') }}">
				</div>

				<div class="form-group">
					<label for="f-email">Email</label>
					<input id="f-email" class="form-control" type="text" name="email" value="{{ Input::old('email') }}">
				</div>

				<div class="form-group">
					<label for="f-password">Password</label>
					<input id="f-password" class="form-control" type="password" name="password">
				</div>

				<div class="form-group">
					<label for="f-confirm-password">Confirm Password</label>
					<input id="f-confirm-password" class="form-control" type="password" name="password_confirmation">
				</div>

				<div class="form-group">
					<button class="btn btn-primary" type="submit">Register</button>
					<a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
				</div>

				<p>{{ link_to_route('login', 'Already Registered?') }}</p>
			{{ Form::close() }}
		</div>
	</div>
@stop