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

            <dl class="row">
                <dt class="col-sm-2 text-right my-0">User ID:</dt>
                <dd class="col-sm-9 my-0">{{ $user->id }}</dd>

                <dt class="col-sm-2 text-right my-0">Username:</dt>
                <dd class="col-sm-9 my-0">{{{ $user->username }}}</dd>

                <dt class="col-sm-2 text-right my-0">Email:</dt>
                <dd class="col-sm-9 my-0">{{{ $user->email }}}</dd>

                <dt class="col-sm-2 text-right my-0">Group:</dt>
                @if ($user->group)
                    <dd class="col-sm-9 my-0"
                        style="color: #{{{ $user->group->colour }}}">{{{ $user->group->name }}}</dd>
                @else
                    <dd class="col-sm-9 my-0">None</dd>
                @endif

                <dt class="col-sm-2 text-right my-0">Founder:</dt>
                <dd class="col-sm-9 my-0">{{ ($user->founder) ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-2 text-right my-0">Active:</dt>
                <dd class="col-sm-9 my-0">{{ ($user->active) ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-2 text-right my-0">Register Date:</dt>
                <dd class="col-sm-9 my-0">{{{ $user->created_at->toDateString() }}}</dd>
            </dl>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">Update User</h3>

            <form action="{{ route('admin.users.update', [$user]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group row">
                    <label class="col-sm-2 col-md-1" for="username">Username</label>

                    <div class="col-sm-10 col-md-11">
                        <input id="username" class="form-control" type="text" name="username"
                               value="{{ $user->username }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-md-1" for="email">Email</label>

                    <div class="col-sm-10 col-md-11">
                        <input id="email" class="form-control" type="text" name="email" value="{{ $user->email }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-md-1" for="group">Group</label>

                    <div class="col-sm-10 col-md-11">
                        <select name="group" id="group" class="form-control custom-select">
                            <option value="">None</option>
                            @foreach ($groups as $group)
                                <option style="color: #{{ $group->colour }}"
                                        value="{{ $group->id }}" {{ ($user->group && $user->group->id == $group->id) ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-check">
                    <label class="form-check-label" for="active">
                        <input id="active"
                               class="form-check-input"
                               type="checkbox"
                               name="active"
                               value="1"
                                {{$user->active ? 'checked' : ''}}>
                        Active
                    </label>
                </div>

                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-10 col-md-offset-1 col-md-11">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">Permissions:</h3>

            <div class="table-responsive">
                <table class="table table-hover table-bordered sortable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hidden-xs">Key</th>
                        <th data-sorter="false">Enabled</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td class="hidden-xs">{{{ $permission->key }}}</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input permission" type="radio"
                                               name="permissions[{{ $permission->key }}]"
                                               value="1" {{($user_permissions[$permission->key] == 1) ? 'checked' : ''}}>
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input permission" type="radio"
                                               name="permissions[{{ $permission->key }}]"
                                               value="0" {{($user_permissions[$permission->key] == 0) ? 'checked' : ''}}>
                                        No
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input permission" type="radio"
                                               name="permissions[{{ $permission->key }}]"
                                               value="-1" {{($user_permissions[$permission->key] == -1) ? 'checked' : ''}}>
                                        Never
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <p>
                <button id="save-permissions" class="btn btn-primary"
                        data-url="{{ route('admin.users.permissions', [$user]) }}">
                    Save Permissions
                </button>
            </p>
        </div>
    </div>
@stop