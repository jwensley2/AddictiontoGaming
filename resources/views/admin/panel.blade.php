@extends('layouts.admin')

@section('title')
Administration
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>General Information</h3>

			<dl class="dl-horizontal">
				<dt>PayPal Balance</dt>
				<dd>${{ $balance }}</dd>

				<dt>Monthly Donations</dt>
				<dd>${{ $total }}</dd>
			</dl>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-6">
			<h3>Latest Donations</h3>
			<table class="table table-hover table-bordered sortable">
				<thead class="tablesorter-header">
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

		<div class="col-md-6">
			<h3>Latest News</h3>

			<table class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>Title</th>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($news as $article)
						<tr>
							<td><a href="{{ action('Admin\NewsController@getEdit', $article->id) }}">{{ $article->title }}</a></td>
							<td>{{ $article->created_at->toDateString() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop