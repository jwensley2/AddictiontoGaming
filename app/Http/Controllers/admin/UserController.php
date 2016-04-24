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
    public function getList()
    {
        if (!Auth::user()->hasPermission('users_view')) {
            return Redirect::route('Admin');
        }

        $users = User::all();

        return view('Admin.users.list')
            ->with('users', $users);
    }


    /**
     * Display a single user
     *
     * @param int $userId The user's ID
     * @return response
     */
    public function getUser($userId)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            return Redirect::route('Admin');
        }

        $permissions = DB::table('permissions')->get();
        $groups      = Group::all();

        try {
            $user = User::findOrFail($userId);
        } catch (\Exception $e) {
            \App::abort(404);
        }

        foreach ($permissions as $permission) {
            if ($user->permissions->find($permission->id)) {
                $user_permissions[$permission->key] = $user->permissions->find($permission->id)->pivot->access;
            } else {
                $user_permissions[$permission->key] = 0;
            }
        }

        return view('Admin.users.user')
            ->with('messages', Session::get('messages'))
            ->with('permissions', $permissions)
            ->with('groups', $groups)
            ->with('user_permissions', $user_permissions)
            ->with('user', $user);
    }


    public function postUser(Request $request, $userId)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            return Redirect::route('Admin');
        }

        try {
            $user = User::findOrFail($userId);
        } catch (\Exception $e) {
            \App::abort(404);
            die;
        }

        $rules = User::$updateRules;
        $rules['username'] .= ",{$user->id}";
        $rules['email'] .= ",{$user->id}";

        $this->validate($request, $rules);

        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->group_id = $request->input('group');
        $user->active   = $request->input('active');
        $user->save();

        return Redirect::action('Admin\UserController@getUser', $user->id)
            ->with('messages', ['User Updated.']);
    }


    /**
     * Update a users permissions
     *
     * @param int $userId The user's ID
     * @return response
     */
    public function postUpdatePermissions(Request $request, $userId)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            $response['success'] = false;
            $response['message'] = 'You do not have permission to do that.';

            return Response::json($response);
        }

        // Set default success
        $result['success'] = true;

        $permissions = $request->input('permissions');

        // Get the user or return an error
        try {
            $user = User::findOrFail($userId);
        } catch (\Exception $e) {
            $result['success'] = false;
            $result['message'] = 'Could not find specified user.';

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


    /**
     * Set the activation status of a user
     *
     * @param int $userId
     * @param int $active
     * @return response
     */
    public function postActiveStatus($userId = null, $active = 0)
    {
        if (!Auth::user()->hasPermission('users_edit')) {
            $response['success'] = false;
            $response['message'] = 'You do not have permission to do that.';

            return Response::json($response);
        }

        // Set default status
        $result['success'] = true;

        // Find the user
        try {
            $user = User::findOrFail($userId);
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = 'Could not find specified user.';

            return Response::json($result);
        }

        // A non-Founder cannot edit a founder
        if (!Auth::user()->founder AND $user->founder) {
            $result['success'] = false;
            $result['message'] = 'A non-Founder cannot edit a founder.';

            return Response::json($result);
        }

        $user->active = $active;
        $user->forceSave();

        $result['message'] = 'Status Updated.';
        $result['status']  = $user->active ? 'Active' : 'Inactive';

        return Response::json($result);
    }
}