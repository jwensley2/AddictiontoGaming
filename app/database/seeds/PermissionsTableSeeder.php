<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('permissions')->delete();

		$permissions = array(
			'donations_view',
			'donors_edit',
			'donors_view',
			'groups_delete',
			'groups_edit',
			'groups_view',
			'news_delete',
			'news_edit',
			'news_post',
			'news_view',
			'panel_view',
			'users_delete',
			'users_edit',
			'users_view',
		);

		$permissions = array_map(function($p) {
			return array('name' => $p);
		}, $permissions);

		// Uncomment the below to run the seeder
		DB::table('permissions')->insert($permissions);
	}

}