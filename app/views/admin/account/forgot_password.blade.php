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

			@if (isset($errors))
				@include("admin._partials.errors")
			@endif

			{{ Form::open(array('action' => array('AccountController@postForgotPassword'))) }}
				<div class="form-group">
					<label for="f-email">Email</label>
					<input id="f-email" class="form-control" type="text" name="email">
				</div>

				<div class="form-actions">
					<button class="btn btn-primary" type="submit">Reset Password</button>
					<a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop