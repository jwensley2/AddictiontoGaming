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

            <form action="{{ route('admin.articles.update', [$article]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

				<div class="form-group">
					<label for="article-author">Author</label>

					<select id="article-author" class="form-control custom-select" name="author">
						@foreach ($authors as $author)
							@if(Request::old('user_id') === $author->id OR $article->user_id === $author->id)
								<option value="{{ $author->id }}" selected>{{ $author->username }}</option>
							@else
								<option value="{{ $author->id }}">{{ $author->username }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="article-title">Title</label>
					<input type="text" id="article-title" class="form-control" name="title" value="{{ Request::old('title', $article->title) }}">
				</div>

				<div class="form-group">
					<label for="article-content">Content</label>
					<textarea id="article-content" class="form-control editor" name="content">{{ Request::old('content', $article->content) }}</textarea>
				</div>

				<div>
					<button type="submit" class="btn btn-primary">Save</button>
					<a class="btn btn-secondary" href="{{ route('admin.home') }}">Cancel</a>
				</div>
			</form>
		</div>
	</div>
@stop