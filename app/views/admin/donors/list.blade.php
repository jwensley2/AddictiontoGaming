@extends('layouts.admin')

@section('title')
Donors
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Real Name</th>
						<th>Ingame Name</th>
						<th>Total Donated</th>
					</tr>
				</thead>

				<tbody>
					@foreach($donors as $donor)
						<tr>
							<td><a href="{{ action('DonorsController@getDonor', $donor->id) }}">{{{ $donor->name }}}</a></td>
							<td>{{{ $donor->ingame_name }}}</td>
							<td>${{ $donor->total_donated }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop