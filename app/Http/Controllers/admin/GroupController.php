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
    public function index()
    {
        if (!Auth::user()->hasPermission('groups_view')) {
            return redirect()->route('admin.home');
        }

        $groups = Group::all();

        return view('admin.groups.list')
            ->with('groups', $groups);
    }


    /**
     * Display a single group
     *
     * @param \App\Group $group
     * @return response
     */
    public function show(Group $group)
    {
        if (!Auth::user()->hasPermission('groups_edit')) {
            return redirect()->route('admin.home');
        }

        $permissions = DB::table('permissions')->get();

        $groupPermissions = [];
        foreach ($permissions as $permission) {
            if ($group->permissions->find($permission->id)) {
                $groupPermissions[$permission->key] = $group->permissions->find($permission->id)->pivot->access;
            } else {
                $groupPermissions[$permission->key] = 0;
            }
        }

        return view('admin.groups.show')
            ->with('permissions', $permissions)
            ->with('group_permissions', $groupPermissions)
            ->with('group', $group);
    }


    /**
     * Update a users permissions
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Group               $group
     * @return Response
     */
    public function updatePermissions(Request $request, Group $group)
    {
        if (!Auth::user()->hasPermission('groups_edit')) {
            return response([
                'success' => false,
                'message' => 'You do not have permission to do that.',
            ], 403);
        }

        $permissions = $request->input('permissions');

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
        $group->permissions()->sync($ids);

        return response([
            'success' => true,
            'message' => 'Permissions Updated.',
        ]);
    }
}