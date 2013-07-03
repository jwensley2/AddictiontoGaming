@extends('layouts.master')

@section('content')
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("#content").on("click", ".delete-news", function(){
				title = $(this).parents('article').children('h2:first-child').text();
				return confirm('Are you sure you want to delete "'+title+'"');
			})
		})
	</script>

	<section id="content" class="content news-articles">
		<header>
			<h1>News and Announcements</h1>
		</header>

		@foreach($news AS $article)
			<article>
				<h2>{{ $article->title }}</h2>
				{{ $article->content }}

				<footer class="post-info">
					<div class="left">
						<a href="{{ action('NewsController@getEdit', $article->id) }}">Edit</a> |
						<a class="delete-news" href="{{ action('NewsController@postDelete', $article->id) }}">Delete</a>
					</div>
					<div class="right">
						<p class="edit-date">
							Updated by
							<a class="edit-user" style="color:red" href="">Username</a>
							on {{ $article->updated_at->toDateString() }}
						</p>
						<p>
							Posted by
							<a class="user" style="color:blue" href="">Username</a>
							on {{ $article->created_at->toDateString() }}
						</p>
					</div>
				</footer>
			</article>
		@endforeach
	</section>
@stop