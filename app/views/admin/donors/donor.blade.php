@extends('layouts.admin')

@section('title')
Donors - View Donor
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>Donor Information:</h3>
			<dl class="dl-horizontal">
				<dt>Name:</dt>
				<dd>{{{ $donor->name }}}</dd>

				<dt>Ingame Name:</dt>
				<dd>{{{ $donor->ingame_name }}}</dd>

				<dt>Steam ID:</dt>
				<dd>{{{ $donor->steam_id }}}</dd>

				<dt>Total Donated:</dt>
				<dd>${{{ $donor->total_donated }}}</dd>

				<dt>Expire Date:</dt>
				<dd>{{{ $donor->expires_at->toDateString() }}}</dd>
			</dl>

			<h3>Donations:</h3>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Amount</th>
						<th>Fee</th>
						<th>Status</th>
						<th>Type</th>
						<th>Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach($donations as $donation)
						<tr>
							<td>${{ $donation->gross }}</td>
							<td>${{ $donation->fee }}</td>
							<td>{{{ $donation->status }}}</td>
							<td>{{{ $donation->type }}}</td>
							<td>{{ $donation->created_at->toDateString() }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop