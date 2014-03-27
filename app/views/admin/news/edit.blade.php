@extends('layouts.admin')

@section('title')
News - Edit Post
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if (isset($messages))
				@include('admin._partials.messages')
			@endif

			@if (isset($errors))
				@include('admin._partials.errors')
			@endif

			{{ Form::open(array('action' => array('AdminNewsController@postEdit', $article->id))) }}
				<div class="form-group">
					<label>Author</label>

					<select class="form-control" name="author">
						@foreach ($authors as $author)
							@if(Input::old('user_id') === $author->id OR $article->user_id === $author->id)
								<option value="{{ $author->id }}" selected>{{ $author->username }}</option>
							@else
								<option value="{{ $author->id }}">{{ $author->username }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Title</label>
					<input class="form-control" type="text" name="title" value="{{ Input::old('title', $article->title) }}">
				</div>

				<div class="form-group">
					<label>Content</label>
					<textarea class="form-control editor" name="content">{{ Input::old('content', $article->content) }}</textarea>
				</div>

				<div class="form-actions">
					<button class="btn btn-primary" type="submit">Save</button>
					<a href="{{ route('admin') }}" class="btn btn-default">Cancel</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop