@extends('layouts.admin')

@section('title')
Settings
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if (Session::has('message'))
				<div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif

			@if ($errors)
				@foreach ($errors->all() as $error)
					<div class="alert alert-error">{{ $error }}</div>
				@endforeach
			@endif

			{{ Form::open(array('action' => 'SettingsController@postIndex', 'class' => 'form-horizontal')) }}
				<div class="form-group">
					<label class="col-sm-2 control-label">Monthly Cost</label>

					<div class="col-sm-3 input-group">
						<span class="input-group-addon">$</span>
						<input class="form-control" type="text" name="monthly_cost" value="{{{ $settings->monthly_cost }}}">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-primary" type="submit" value="Save Settings">
						<input class="btn btn-warning" type="reset" value="Reset">
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop