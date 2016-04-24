<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Permission;
use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Response;

class GroupController extends Controller
{

    /**
     * Show a listing of all the groups
     *
     * @return response
     */
    public function getList()
    {
        if (!Auth::user()->hasPermission('groups_view')) {
            return Redirect::route('admin');
        }

        $groups = Group::all();

        return view('admin.groups.list')
            ->with('groups', $groups);
    }


    /**
     * Display a single group
     *
     * @param int $groupId The group's ID
     * @return response
     */
    public function getGroup($groupId)
    {
        if (!Auth::user()->hasPermission('groups_edit')) {
            return Redirect::route('admin');
        }

        $permissions = DB::table('permissions')->get();

        try {
            $group = Group::findOrFail($groupId);
        } catch (\Exception $e) {
            \App::abort(404);
        }

        foreach ($permissions as $permission) {
            if ($group->permissions->find($permission->id)) {
                $group_permissions[$permission->key] = $group->permissions->find($permission->id)->pivot->access;
            } else {
                $group_permissions[$permission->key] = 0;
            }
        }

        return view('admin.groups.group')
            ->with('permissions', $permissions)
            ->with('group_permissions', $group_permissions)
            ->with('group', $group);
    }


    /**
     * Update a users permissions
     *
     * @param int $groupId The user's ID
     * @return response
     */
    public function postUpdatePermissions(Request $request,$groupId)
    {
        if (!Auth::user()->hasPermission('groups_edit')) {
            $response['success'] = false;
            $response['message'] = 'You do not have permission to do that.';

            return Response::json($response);
        }

        // Set default success
        $result['success'] = true;

        $permissions = $request->input('permissions');

        // Get the user or return an error
        try {
            $user = Group::findOrFail($groupId);
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = 'Could not find specified group.';

            return Response::json($result);
        }

        // Create an array to hold the permission IDs
        $ids = [];

        // Get and store the permission IDs
        if ($permissions) {
            foreach ($permissions as $key => $access) {
                $id = Permission::where('key', $key)->first()->id;

                $ids[$id] = ['access' => $access];
            }
        }

        // Sync the pivot table to only have the submitted IDs
        $user->permissions()->sync($ids);

        $result['message'] = 'Permissions Updated.';

        return Response::json($result);
    }
}