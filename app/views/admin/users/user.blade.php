@extends('layouts.admin')

@section('title')
Users - Edit User
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>User Information:</h3>
			<dl class="dl-horizontal">
				<dt>User ID:</dt>
				<dd>{{ $user->id }}</dd>

				<dt>Username:</dt>
				<dd>{{{ $user->username }}}</dd>

				<dt>Email:</dt>
				<dd>{{{ $user->email }}}</dd>

				<dt>Founder:</dt>
				<dd>{{ ($user->founder) ? 'Yes' : 'No' }}</dd>

				<dt>Active:</dt>
				<dd>{{ ($user->active) ? 'Yes' : 'No' }}</dd>

				<dt>Register Date:</dt>
				<dd>{{{ $user->created_at->toDateString() }}}</dd>
			</dl>

			<h3>Permissions:</h3>
			<table class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Key</th>
						<th>Enabled</th>
					</tr>
				</thead>

				<tbody>
					@foreach($permissions as $permission)
						<tr>
							<td>{{ $permission->name }}</td>
							<td>{{{ $permission->key }}}</td>
							<td>
								<input class="permission" type="checkbox" name="permissions[{{ $permission->key }}]" value="1" @if($user->hasPermission($permission->key, false))checked@endif>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<p>
				<button id="save-permissions" class="btn btn-primary" data-url="{{ action('UserController@postUpdatePermissions', $user->id) }}">Save Permissions</button>
			</p>
		</div>
	</div>
@stop