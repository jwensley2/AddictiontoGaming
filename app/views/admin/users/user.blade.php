@extends('layouts.admin')

@section('title')
Users - Edit User
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if (isset($messages))
				@include('admin._partials.messages')
			@endif

			@if (isset($errors))
				@include('admin._partials.errors')
			@endif

			<h3>User Information:</h3>

			<dl class="dl-horizontal">
				<dt>User ID:</dt>
				<dd>{{ $user->id }}</dd>

				<dt>Username:</dt>
				<dd>{{{ $user->username }}}</dd>

				<dt>Email:</dt>
				<dd>{{{ $user->email }}}</dd>

				<dt>Group:</dt>
				@if ($user->group)
					<dd style="color: #{{{ $user->group()->first()->colour }}}">{{{ $user->group()->first()->name }}}</dd>
				@else
					<dd>None</dd>
				@endif

				<dt>Founder:</dt>
				<dd>{{ ($user->founder) ? 'Yes' : 'No' }}</dd>

				<dt>Active:</dt>
				<dd>{{ ($user->active) ? 'Yes' : 'No' }}</dd>

				<dt>Register Date:</dt>
				<dd>{{{ $user->created_at->toDateString() }}}</dd>
			</dl>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h3>Update User</h3>

			{{ Form::open(array('action' => array('UserController@postUser', $user->id), 'class' => 'form-horizontal')) }}
				<div class="form-group">
					{{ Form::label('username', 'Username', array('class' => 'col-sm-2 col-md-1')) }}

					<div class="col-sm-10 col-md-11">
						{{ Form::text('username', $user->username, array('class' => 'form-control')) }}
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('email', 'Email', array('class' => 'col-sm-2 col-md-1')) }}

					<div class="col-sm-10 col-md-11">
						{{ Form::text('email', $user->email, array('class' => 'form-control')) }}
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('group', 'Group', array('class' => 'col-sm-2 col-md-1')) }}

					<div class="col-sm-10 col-md-11">
						<select name="group" id="group" class="form-control">
							<option value="">None</option>
							@foreach ($groups as $group)
								<option style="color: #{{{ $group->colour }}}" value="{{ $group->id }}" {{ ($user->group and $user->group->id == $group->id) ? 'selected' : '' }}>
									{{ $group->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('active', 'Active', array('class' => 'col-sm-2 col-md-1')) }}

					<div class="col-sm-10 col-md-11">
						{{ Form::checkbox('active', '1', $user->active) }}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10 col-md-offset-1 col-md-11">
						<button type="submit" class="btn btn-primary">Update User</button>
						<button type="reset" class="btn btn-warning">Reset</button>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-md-12">
			<h3>Permissions:</h3>

			<div class="table-responsive">
				<table class="table table-hover table-bordered sortable">
					<thead>
						<tr>
							<th>Name</th>
							<th class="hidden-xs">Key</th>
							<th>Enabled</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($permissions as $permission)
							<tr>
								<td>{{ $permission->name }}</td>
								<td class="hidden-xs">{{{ $permission->key }}}</td>
								<td>
									<label class="radio-inline">
										Yes
										<input class="permission" type="radio" name="permissions[{{ $permission->key }}]" value="1" @if($user_permissions[$permission->key] == 1)checked@endif>
									</label>
									<label class="radio-inline">
										No
										<input class="permission" type="radio" name="permissions[{{ $permission->key }}]" value="0" @if($user_permissions[$permission->key] == 0)checked@endif>
									</label>
									<label class="radio-inline">
										Never
										<input class="permission" type="radio" name="permissions[{{ $permission->key }}]" value="-1" @if($user_permissions[$permission->key] == -1)checked@endif>
									</label>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<p>
				<button id="save-permissions" class="btn btn-primary" data-url="{{ action('UserController@postUpdatePermissions', $user->id) }}">Save Permissions</button>
			</p>
		</div>
	</div>
@stop