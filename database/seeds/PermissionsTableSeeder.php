<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('permissions')->truncate();

		$permissions = [
			[
				'key'  => 'DONATIONS_VIEW',
				'name' => 'View Donations',
			],
			[
				'key'  => 'DONORS_EDIT',
				'name' => 'Edit Donors',
			],
			[
				'key'  => 'DONORS_VIEW',
				'name' => 'View Donors',
			],
			[
				'key'  => 'GROUPS_DELETE',
				'name' => 'Delete Groups',
			],
			[
				'key'  => 'GROUPS_EDIT',
				'name' => 'Edit Groups',
			],
			[
				'key'  => 'GROUPS_VIEW',
				'name' => 'View Groups',
			],
			[
				'key'  => 'NEWS_DELETE',
				'name' => 'Delete News',
			],
			[
				'key'  => 'NEWS_EDIT',
				'name' => 'Edit News',
			],
			[
				'key'  => 'NEWS_POST',
				'name' => 'Post News',
			],
			[
				'key'  => 'NEWS_VIEW',
				'name' => 'View News',
			],
			[
				'key'  => 'PANEL_VIEW',
				'name' => 'View Admin panel',
			],
			[
				'key'  => 'USERS_DELETE',
				'name' => 'Delete Users',
			],
			[
				'key'  => 'USERS_EDIT',
				'name' => 'Edit Users',
			],
			[
				'key'  => 'USERS_VIEW',
				'name' => 'View Users',
			],
		];

		// Uncomment the below to run the seeder
		DB::table('permissions')->insert($permissions);
	}

}