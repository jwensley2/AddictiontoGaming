@extends('layouts.admin')

@section('title')
Donations
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			{{ $donations->links() }}

			<div class="table-responsive">
				<table class="table table-hover table-bordered sortable">
					<thead>
						<tr>
							<th>Real Name</th>
							<th>Ingame Name</th>
							<th>Amount</th>
							<th>Fee</th>
							<th>Status</th>
							<th>Date</th>
						</tr>
					</thead>

					<tbody>
						@foreach($donations as $donation)
							<tr>
								<td><a href="{{ route('admin.donors.show', $donation->donor->id) }}">{{{ $donation->donor->name }}}</a></td>
								<td>{{{ $donation->donor->ingame_name }}}</td>
								<td>${{ $donation->gross }}</td>
								<td>${{ $donation->fee }}</td>
								<td>{{ $donation->status }}</td>
								<td>{{ $donation->updated_at->toDateString() }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			{{ $donations->links() }}
		</div>
	</div>
@stop