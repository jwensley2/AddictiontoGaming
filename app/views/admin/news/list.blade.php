@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="span12">
			<h3 class="pull-left">News Posts</h3>

			<p class="pull-right text-right"><a class="btn btn-primary" href="{{ action('NewsController@getCreate') }}">Post News</a></p>

			<table id="news-list" class="table table-hover">
				<thead>
					<tr>
						<th>Title</th>
						<th>Post Date</th>
						<th>Edit Date</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($news as $article)
						<tr
							class="news-item"
							data-delete="{{ action('NewsController@postDelete', $article->id) }}"
							data-id="{{ $article->id }}"
							data-title="{{{ $article->title }}}"
						>
							<td><a href="{{ action('NewsController@getEdit', $article->id) }}">{{{ $article->title }}}</a></td>
							<td>{{ $article->created_at->toDateString() }}</td>
							<td>{{ $article->updated_at->toDateString() }}</td>
							<td>
								<a class="btn btn-primary" href="{{ action('NewsController@getEdit', $article->id) }}">Edit</a>
								<button class="btn btn-danger delete">Delete</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<p class="text-right"><a class="btn btn-primary" href="{{ action('NewsController@getCreate') }}">Post News</a></p>
		</div>
	</div>
@stop