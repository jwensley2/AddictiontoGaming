@extends('layouts.admin')

@section('title')
Settings
@stop

@section('content')
	<div class="row">
		<div class="span12">
			@if (Session::has('message'))
				<div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif

			@if ($errors)
				@foreach ($errors->all() as $error)
					<div class="alert alert-error">{{ $error }}</div>
				@endforeach
			@endif

			{{ Form::open(array('action' => 'SettingsController@postIndex', 'class' => 'form-horizontal')) }}
				<div class="control-group">
					<label class="control-label">Monthly Cost</label>

					<div class="controls">
						<input type="text" name="monthly_cost" value="{{{ $settings->monthly_cost }}}">
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<input class="btn btn-primary" type="submit" value="Save Settings">
						<input class="btn btn-warning" type="reset" value="Reset">
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop