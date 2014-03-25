@extends('layouts.admin')

@section('title')
Groups - Edit Group
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>Group Information:</h3>
			<dl class="dl-horizontal">
				<dt>Group ID:</dt>
				<dd>{{ $group->id }}</dd>

				<dt>Name:</dt>
				<dd>{{{ $group->name }}}</dd>

				<dt>Colour:</dt>
				<dd style="color: #{{ $group->colour }}">#{{ $group->colour }}</dd>
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
								<input class="permission" type="checkbox" name="permissions[{{ $permission->key }}]" value="1" @if($group->hasPermission($permission->key))checked@endif>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<p>
				<button id="save-permissions" class="btn btn-primary" data-url="{{ action('GroupController@postUpdatePermissions', $group->id) }}">Save Permissions</button>
			</p>
		</div>
	</div>
@stop