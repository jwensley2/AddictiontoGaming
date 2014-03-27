<article>
	<h2>{{ $article->title }}</h2>
	{{ $article->content }}

	<footer class="post-info">
		<div class="left">
			@if (Auth::check() AND Auth::user()->hasPermission('news_edit'))
				<a href="{{ action('AdminNewsController@getEdit', $article->id) }}">Edit</a> |
				<a class="delete-news" href="{{ action('AdminNewsController@postDelete', $article->id) }}" data-title="{{ $article->title }}">Delete</a>
			@endif
		</div>
		<div class="right">
			@if ($article->editor)
				<p class="edit-date">
					Updated by
					<span style="color:#{{ ($article->editor->group) ? $article->editor->group->colour : 'FFF' }}">{{ $article->editor->username }}</span>
					on {{ $article->updated_at->toDateString() }}
				</p>
			@endif

			@if ($article->author)
				<p>
					Posted by
					<span style="color:#{{ ($article->author->group) ? $article->author->group->colour : 'FFF' }}">{{ $article->author->username }}</span>
					on {{ $article->created_at->toDateString() }}
				</p>
			@endif
		</div>
	</footer>
</article>