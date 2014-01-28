@extends('layouts.admin')

@section('title')
News - New Post
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if (Session::has('message'))
				<div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif

			@if (Session::has('errors'))
				@foreach (Session::get('errors') as $error)
					<div class="alert alert-error">{{ $error }}</div>
				@endforeach
			@endif

			{{ Form::open(array('action' => array('NewsController@postCreate'))) }}
				<div class="form-group">
					<label>Title</label>
					<input class="form-control" type="text" name="title" value="{{ Input::old('title') }}">
				</div>

				<div class="form-group">
					<label>Content</label>
					<textarea class="form-control editor" name="content">{{ Input::old('content') }}</textarea>
				</div>

				<div class="form-actions">
					<button class="btn btn-primary" type="submit">Save</button>
					<a href="{{ route('admin') }}" class="btn btn-default">Cancel</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop