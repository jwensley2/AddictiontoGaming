<?php

use Carbon\Carbon;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Empty the users table
		DB::table('users')->truncate();

		$now = Carbon::now();

		$users = [
			[
				'active'     => true,
				'created_at' => $now,
				'email'      => 'tester@example.com',
				'founder'    => true,
				'group_id'   => 1,
				'password'   => Hash::make('supersecretpassword'),
				'updated_at' => $now,
				'username'   => 'Tester',
			],
		];

		// Insert the users
		DB::table('users')->insert($users);
	}

}