@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="span12">
			<h3>Edit News</h3>

			@if (Session::has('message'))
				<div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif

			@if (Session::has('errors'))
				@foreach (Session::get('errors') as $error)
					<div class="alert alert-error">{{ $error }}</div>
				@endforeach
			@endif

			{{ Form::open(array('action' => array('NewsController@postEdit', $article->id))) }}
				<label>Title</label>
				<input class="span6" type="text" name="title" value="{{ Input::old('title', $article->title) }}">

				<label>Content</label>
				<textarea class="editor" name="content">{{ Input::old('content', $article->content) }}</textarea>

				<div class="form-actions">
					<button class="btn btn-primary" type="submit">Save</button>
					<a href="{{ route('admin') }}" class="btn">Cancel</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop