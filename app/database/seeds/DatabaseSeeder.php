<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('NewsTableSeeder');
		$this->call('DonorsTableSeeder');
		$this->call('DonationsTableSeeder');
		$this->call('SettingsTableSeeder');
		$this->call('SettingsTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('GroupsTableSeeder');
	}

}