@extends('layouts.admin')

@section('title')
Login
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if (isset($messages))
				@include("admin._partials.messages")
			@endif

			@if (isset($errors))
				@include("admin._partials.errors")
			@endif

			{{ Form::open(array('action' => array('AccountController@postLogin'))) }}
				<div class="form-group">
					<label for="f-username">Username</label>
					<input id="f-username" class="form-control" type="text" name="username">
				</div>

				<div class="form-group">
					<label for="f-password">Password</label>
					<input id="f-password" class="form-control" type="password" name="password">
				</div>

				<div class="form-group">
					<button class="btn btn-primary" type="submit">Login</button>
					<a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
				</div>

				<p>{{ link_to_route('forgotPassword', 'Forgot your password?')}}</p>
			{{ Form::close() }}
		</div>
	</div>
@stop