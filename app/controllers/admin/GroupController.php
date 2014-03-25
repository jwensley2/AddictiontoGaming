<?php

class GroupController extends BaseController {

	/**
	 * Show a listing of all the groups
	 *
	 * @return response
	 */
	public function getList()
	{
		if ( ! Auth::user()->hasPermission('groups_view')) return Redirect::route('admin');

		$groups = Group::all();

		return View::make('admin.groups.list')
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
		if ( ! Auth::user()->hasPermission('groups_edit')) return Redirect::route('admin');

		$permissions = DB::table('permissions')->get();

		try {
			$group = Group::findOrFail($groupId);
		} catch (Exception $e) {
			return App::abort(404);
		}

		return View::make('admin.groups.group')
			->with('permissions', $permissions)
			->with('group', $group);
	}


	/**
	 * Update a users permissions
	 *
	 * @param int $groupId The user's ID
	 * @return response
	 */
	public function postUpdatePermissions($groupId)
	{
		if ( ! Auth::user()->hasPermission('groups_edit'))
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
			$user = Group::findOrFail($groupId);
		} catch (Exception $e) {
			$result['success'] = false;
			$result['message'] = 'Could not find specified group.';

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