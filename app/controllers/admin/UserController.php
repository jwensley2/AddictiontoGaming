<?php

class UserController extends BaseController {

	/**
	 * Show a listing of all the users
	 *
	 * @return response
	 */
	public function getList()
	{
		if ( ! Auth::user()->hasPermission('users_view')) return Redirect::route('admin');

		$users = DB::table('users')->get();

		return View::make('admin.users.list')
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
		if ( ! Auth::user()->hasPermission('users_edit')) return Redirect::route('admin');

		$permissions = DB::table('permissions')->get();

		try {
			$user = User::findOrFail($userId);
		} catch (Exception $e) {
			return App::abort(404);
		}

		return View::make('admin.users.user')
			->with('permissions', $permissions)
			->with('user', $user);
	}

	/**
	 * Update a users permissions
	 *
	 * @param int $userId The user's ID
	 * @return response
	 */
	public function postUpdatePermissions($userId)
	{
		if ( ! Auth::user()->hasPermission('users_edit'))
		{
			$response['success'] = false;
			$response['message'] = 'You do not have permission to do that.';

			return Response::json($response);
		}

		// Set default success
		$result['success'] = true;

		$permissions = Input::get('permissions');

		// Get the user or return an error
		try {
			$user = User::findOrFail($userId);
		} catch (Exception $e) {
			$result['success'] = false;
			$result['message'] = 'Could not find specified user.';

			return Response::json($result);
		}

		// Create an array to hold the permission IDs
		$ids = array();

		// Get and store the permission IDs
		if ($permissions)
		{
			foreach ($permissions as $key => $access)
			{
				$id = Permission::where('key', $key)->first()->id;

				$ids[$id] = array('access' => $access);
			}
		}

		// Sync the pivot table to only have the submitted IDs
		$user->permissions()->sync($ids);

		$result['message'] = 'Permissions Updated.';
		return Response::json($result);
	}

}