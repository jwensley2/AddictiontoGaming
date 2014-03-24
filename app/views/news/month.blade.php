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
			@include('news.partials.article', array('article' => $article))
		@endforeach
	</section>
@stop