@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="span6">
			<h3>Latest Donations</h3>
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Amount</th>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach($donations as $donation)
						<tr>
							<td>{{ $donation->donor->ingame_name }}</td>
							<td>${{ $donation->gross }}</td>
							<td>{{ $donation->created_at->toDateString() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="span6">
			<h3>Latest News</h3>
			<ul class="nav nav-tabs nav-stacked">
				@foreach ($news as $article)
					<li>
						<a href="{{ action('NewsController@getEdit', $article->id) }}">
							{{ $article->created_at->toDateString() }} - {{ $article->title }}
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@stop