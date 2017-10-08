@extends('layouts.admin')

@section('title')
    Groups - Edit Group
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Group Information:</h3>

            <dl class="row">
                <dt class="col-sm-2 text-right my-0">Group ID:</dt>
                <dd class="col-sm-10 my-0">{{ $group->id }}</dd>

                <dt class="col-sm-2 text-right my-0">Name:</dt>
                <dd class="col-sm-10 my-0">{{{ $group->name }}}</dd>

                <dt class="col-sm-2 text-right my-0">Colour:</dt>
                <dd class="col-sm-10 my-0" style="color: #{{ $group->colour }}">#{{ $group->colour }}</dd>
            </dl>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">Permissions:</h3>

            <table class="table table-hover table-bordered sortable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Key</th>
                    <th data-sorter="false">Enabled</th>
                </tr>
                </thead>

                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{{ $permission->key }}}</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input permission" type="radio"
                                           name="permissions[{{ $permission->key }}]"
                                           value="1" {{($group_permissions[$permission->key] == 1) ? 'checked' : ''}}>
                                    Yes
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input permission" type="radio"
                                           name="permissions[{{ $permission->key }}]"
                                           value="0" {{($group_permissions[$permission->key] == 0) ? 'checked' : ''}}>
                                    No
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input permission" type="radio"
                                           name="permissions[{{ $permission->key }}]"
                                           value="-1" {{($group_permissions[$permission->key] == -1) ? 'checked' : ''}}>
                                    Never
                                </label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p>
                <button id="save-permissions" class="btn btn-primary"
                        data-url="{{ route('admin.groups.permissions', [$group]) }}">Save Permissions
                </button>
            </p>
        </div>
    </div>
@stop