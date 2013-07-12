<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Empty the users table
		DB::table('users')->delete();

		$time = Carbon\Carbon::now('America/Toronto')->toDateTimeString();

		// Get the users from phpBB
		$phpbb_users = DB::connection('phpbb')
			->table('phpbb_users')
			->select('user_id', 'username', 'user_email', 'group_id')
			->whereIn('group_id', array(7, 14, 19))
			->get();

		// Build an array of users
		foreach ($phpbb_users AS $user)
		{
			$users[] = array(
				'id'         => $user->user_id,
				'group_id'   => $user->group_id,
				'username'   => $user->username,
				'email'      => $user->user_email,
				'active'     => false,
				'created_at' => $time,
				'updated_at' => $time,
			);
		}

		// Insert the users
		DB::table('users')->insert($users);
	}

}