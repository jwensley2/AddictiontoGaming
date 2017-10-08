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
                        <td><a href="{{ route('admin.users.show', [$user]) }}">{{{ $user->username }}}</a></td>
                        <td>{{{ $user->email }}}</td>
                        <td>
                            @if($user->group)
                                <a style="color: #{{{ $user->group->colour }}}"
                                   href="{{ route('admin.groups.show', [$user->group]) }}">{{{ $user->group->name }}}</a>
                            @else
                                None
                            @endif
                        </td>
                        <td>{{ $user->created_at->toDateString() }}</td>
                        <td>
                            <div class="user-actions btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="status">{{ ($user->active) ? 'Active' : 'Inactive' }}</span>
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <button class="de-activate dropdown-item {{ ($user->active) ? '' : 'd-none' }}"
                                       data-url="{{ route('admin.users.status', [$user, 0]) }}"
                                    >De-Activate</button>
                                    <button class="activate dropdown-item {{ ($user->active) ? 'd-none' : '' }}"
                                       data-url="{{ route('admin.users.status', [$user, 1]) }}"
                                    >Activate</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop