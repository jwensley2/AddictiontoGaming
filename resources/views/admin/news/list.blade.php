@extends('layouts.admin')

@section('title')
News
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<p class="text-right">
				@if(Auth::user()->hasPermission('news_post'))
					<a class="btn btn-primary" href="{{ action('Admin\NewsController@getCreate') }}">Post News</a>
				@endif
			</p>

			<table id="news-list" class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>Title</th>
						<th class="hidden-xs">Author</th>
						<th class="hidden-xs">Last Editor</th>
						<th class="hidden-xs">Post Date</th>
						<th class="hidden-xs">Edit Date</th>
						<th data-sorter="false">Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($news as $article)
						<tr
							class="news-item"
							data-delete="{{ action('Admin\NewsController@postDelete', $article->id) }}"
							data-id="{{ $article->id }}"
							data-title="{{{ $article->title }}}"
						>
							<td>
								@if(Auth::user()->hasPermission('news_edit'))
									<a href="{{ action('Admin\NewsController@getEdit', $article->id) }}">{{{ $article->title }}}</a>
								@else
									{{{ $article->title }}}
								@endif
							</td>
							<td class="hidden-xs">{{ ($article->author) ? $article->author->username : 'None' }}</td>
							<td class="hidden-xs">{{ ($article->editor) ? $article->editor->username : 'None' }}</td>
							<td class="hidden-xs">{{ $article->created_at->toDateString() }}</td>
							<td class="hidden-xs">{{ $article->updated_at->toDateString() }}</td>
							<td>
								@if(Auth::user()->hasPermission('news_edit'))
									<a class="btn btn-primary hidden-xs" href="{{ action('Admin\NewsController@getEdit', $article->id) }}">Edit</a>
								@endif

								@if(Auth::user()->hasPermission('news_delete'))
									<button class="btn btn-danger delete">Delete</button>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<p class="text-right"><a class="btn btn-primary" href="{{ action('Admin\NewsController@getCreate') }}">Post News</a></p>
		</div>
	</div>
@stop