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
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
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
                            <label class="radio-inline">
                                <input class="permission" type="radio" name="permissions[{{ $permission->key }}]"
                                       value="1" {{($group_permissions[$permission->key] == 1) ? 'checked' : ''}}>
                                Yes
                            </label>
                            <label class="radio-inline">
                                <input class="permission" type="radio" name="permissions[{{ $permission->key }}]"
                                       value="0" {{($group_permissions[$permission->key] == 0) ? 'checked' : ''}}>
                                No
                            </label>
                            <label class="radio-inline">
                                <input class="permission" type="radio" name="permissions[{{ $permission->key }}]"
                                       value="-1" {{($group_permissions[$permission->key] == -1) ? 'checked' : ''}}>
                                Never
                            </label>
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