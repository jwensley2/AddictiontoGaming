<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Empty the users table
		DB::table('users')->truncate();

		$users = array(
			array(
				'active'   => true,
				'email'    => 'addictiontogaming@gmail.com',
				'username' => 'atg',
			),
			array(
				'active'   => true,
				'email'    => 'jwensley2@gmail.com',
				'username' => 'joe',
			),
		);

		// Insert the users
		DB::table('users')->insert($users);
	}

}