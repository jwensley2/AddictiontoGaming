@extends('layouts.admin')

@section('title')
Groups
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<table id="group-list" class="table table-hover table-bordered sortable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Colour</th>
					</tr>
				</thead>

				<tbody>
					@foreach($groups as $group)
						<tr>
							<td>{{ $group->id }}</td>
							<td><a href="{{ route('admin.groups.show', [$group]) }}">{{{ $group->name }}}</a></td>
							<td>
								<span style="color: #{{{ $group->colour }}}">#{{ $group->colour }}</span>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop