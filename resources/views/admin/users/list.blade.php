@extends('layouts.admin')

@section('title')
Users
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<table id="user-list" class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th>Group</th>
						<th>Register Date</th>
						<th>Status</th>
					</tr>
				</thead>

				<tbody>
					@foreach($users as $user)
						<tr>
							<td><a href="{{ action('Admin\UserController@getUser', $user->id) }}">{{{ $user->username }}}</a></td>
							<td>{{{ $user->email }}}</td>
							<td>
								@if($user->group)
									<a style="color: #{{{ $user->group->colour }}}" href="{{ action('Admin\GroupController@getGroup', array($user->group->id)) }}">{{{ $user->group->name }}}</a>
								@else
									None
								@endif
							</td>
							<td>{{ $user->created_at->toDateString() }}</td>
							<td>
								<div class="user-actions btn-group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span class="status">{{ ($user->active) ? 'Active' : 'Inactive' }}</span> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a
												class="de-activate"
												data-url="{{ action('Admin\UserController@postActiveStatus', array($user->id, 0)) }}"
												href="#"
												style="display: {{ ($user->active) ? 'block' : 'none' }}"
											>De-Activate</a>
										</li>
										<li>
											<a
												class="activate"
												data-url="{{ action('Admin\UserController@postActiveStatus', array($user->id, 1)) }}"
												href="#"
												style="display: {{ ($user->active) ? 'none' : 'block' }}"
											>Activate</a>
										</li>
										{{--
										<li class="divider"></li>
										<li><a href="#">Delete</a></li>
										--}}
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop