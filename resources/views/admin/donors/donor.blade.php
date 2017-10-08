@extends('layouts.admin')

@section('title')
Donors - View Donor
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>Donor Information:</h3>

			<dl class="row">
				<dt class="col-sm-2 text-right">Name:</dt>
				<dd class="col-sm-10">{{{ $donor->name }}}</dd>

				<dt class="col-sm-2 text-right">Ingame Name:</dt>
				<dd class="col-sm-10">{{{ $donor->ingame_name }}}</dd>

				<dt class="col-sm-2 text-right">Steam ID:</dt>
				<dd class="col-sm-10">{{{ $donor->steam_id }}}</dd>

				<dt class="col-sm-2 text-right">Total Donated:</dt>
				<dd class="col-sm-10">${{{ $donor->total_donated }}}</dd>

				<dt class="col-sm-2 text-right">Expire Date:</dt>
				<dd class="col-sm-10">{{{ $donor->expires_at->toDateString() }}}</dd>
			</dl>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h3>Donations:</h3>

			<table class="table table-hover table-bordered sortable">
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