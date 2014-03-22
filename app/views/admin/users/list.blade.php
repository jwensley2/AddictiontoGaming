@extends('layouts.admin')

@section('title')
Users
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<table class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th>Active</th>
					</tr>
				</thead>

				<tbody>
					@foreach($users as $user)
						<tr>
							<td><a href="{{ action('UserController@getUser', $user->id) }}">{{{ $user->username }}}</a></td>
							<td>{{{ $user->email }}}</td>
							<td>{{ $user->active }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop