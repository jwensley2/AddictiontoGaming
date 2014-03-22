<?php

use Carbon\Carbon;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Empty the users table
		DB::table('users')->truncate();

		$now = Carbon::now();

		$users = array(
			array(
				'active'     => true,
				'created_at' => $now,
				'email'      => 'addictiontogaming@gmail.com',
				'founder'    => true,
				'updated_at' => $now,
				'username'   => 'atg',
			),
			array(
				'active'     => true,
				'created_at' => $now,
				'email'      => 'jwensley2@gmail.com',
				'founder'    => true,
				'updated_at' => $now,
				'username'   => 'joe',
			),
		);

		// Insert the users
		DB::table('users')->insert($users);
	}

}