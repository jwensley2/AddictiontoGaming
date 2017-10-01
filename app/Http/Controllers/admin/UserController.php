<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Session;

class UserController extends Controller
{

    /**
     * Show a listing of all the users
     *
     * @return response
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('users_view')) {
            return redirect()->route('admin.home');
        }

        $users = User::with('group')
            ->get();

        return view('admin.users.list')
            ->with('users', $users);
    }


    /**
     * Display a single user
     *
     * @param int $userId The user's ID
     * @return response
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            return redirect()->route('admin.home');
        }

        $user->load('group');
        $permissions = DB::table('permissions')->get();
        $groups      = Group::all();

        $userPermissions = [];
        foreach ($permissions as $permission) {
            if ($user->permissions->find($permission->id)) {
                $userPermissions[$permission->key] = $user->permissions->find($permission->id)->pivot->access;
            } else {
                $userPermissions[$permission->key] = 0;
            }
        }

        return view('admin.users.show')
            ->with('messages', Session::get('messages'))
            ->with('permissions', $permissions)
            ->with('groups', $groups)
            ->with('user_permissions', $userPermissions)
            ->with('user', $user);
    }


    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            return redirect()->route('admin.home');
        }

        $rules             = User::$updateRules;
        $rules['username'] .= ",{$user->id}";
        $rules['email']    .= ",{$user->id}";

        $this->validate($request, $rules);

        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->group_id = $request->input('group');
        $user->active   = $request->input('active', false);
        $user->save();

        return redirect()->route('admin.users.show', [$user])
            ->with('messages', ['User Updated.']);
    }


    /**
     * Update a users permissions
     *
     * @param int $userId The user's ID
     * @return response
     */
    public function updatePermissions(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
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
        $user->permissions()->sync($ids);

        return response([
            'success' => true,
            'message' => 'Permissions Updated.',
        ]);
    }


    /**
     * Set the activation status of a user
     *
     * @param int $userId
     * @param int $active
     * @return response
     */
    public function setStatus(User $user, $active = 0)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            return response([
                'success' => false,
                'message' => 'You do not have permission to do that.',
            ], 403);
        }

        // A non-Founder cannot edit a founder
        if (!Auth::user()->founder && $user->founder) {
            return response([
                'success' => false,
                'message' => 'A non-Founder cannot edit a founder.',
            ], 403);
        }

        $user->active = $active;
        $user->save();

        return response([
            'success' => true,
            'message' => 'Status Updated.',
            'status'  => $user->active ? 'Active' : 'Inactive',
        ]);
    }
}