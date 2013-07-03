@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="span12">
			<h3>News Posts</h3>
			<table class="table">
				<thead>
					<tr>
						<th>Title</th>
						<th>Post Date</th>
						<th>Edit Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach($news as $article)
						<tr>
							<td><a href="{{ action('NewsController@getEdit', $article->id) }}">{{ $article->title }}</a></td>
							<td>{{ $article->created_at->toDateString() }}</td>
							<td>{{ $article->updated_at->toDateString() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop