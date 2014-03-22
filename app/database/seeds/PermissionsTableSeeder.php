<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('permissions')->truncate();

		$permissions = array(
			array(
				'key'  => 'DONATIONS_VIEW',
				'name' => 'View Donations',
			),
			array(
				'key'  => 'DONORS_EDIT',
				'name' => 'Edit Donors',
			),
			array(
				'key'  => 'DONORS_VIEW',
				'name' => 'View Donors',
			),
			array(
				'key'  => 'GROUPS_DELETE',
				'name' => 'Delete Groups',
			),
			array(
				'key'  => 'GROUPS_EDIT',
				'name' => 'Edit Groups',
			),
			array(
				'key'  => 'GROUPS_VIEW',
				'name' => 'View Groups',
			),
			array(
				'key'  => 'NEWS_DELETE',
				'name' => 'Delete News',
			),
			array(
				'key'  => 'NEWS_EDIT',
				'name' => 'Edit News',
			),
			array(
				'key'  => 'NEWS_POST',
				'name' => 'Post News',
			),
			array(
				'key'  => 'NEWS_VIEW',
				'name' => 'View News',
			),
			array(
				'key'  => 'PANEL_VIEW',
				'name' => 'View admin panel',
			),
			array(
				'key'  => 'USERS_DELETE',
				'name' => 'Delete Users',
			),
			array(
				'key'  => 'USERS_EDIT',
				'name' => 'Edit Users',
			),
			array(
				'key'  => 'USERS_VIEW',
				'name' => 'View Users',
			),
		);

		// Uncomment the below to run the seeder
		DB::table('permissions')->insert($permissions);
	}

}