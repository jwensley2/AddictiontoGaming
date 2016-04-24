@extends('layouts.master')

@section('content')
	<section id="content" class="content news-articles">
		<header>
			<h1>News Archive</h1>
		</header>

		<ul class="news-archive">
			@foreach($months AS $date)
				<li class="date">
					<a href="{{ action('NewsController@getMonth', array($date->created_at->year, $date->created_at->month)) }}">{{ $date->created_at->format('F Y') }}</a>
				</li>
			@endforeach
		</ul>
	</section>
@stop