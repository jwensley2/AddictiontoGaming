<?php

class GroupsTableSeeder extends Seeder {

	public function run()
	{
		// Empty the groups table
		DB::table('groups')->truncate();

		$groups = array(
			array(
				'name'   => 'Founder',
				'colour' => '990000',
			),
			array(
				'name'   => 'Managers',
				'colour' => '00CC33',
			),
			array(
				'name'   => 'Community Team',
				'colour' => '0099CC',
			),
		);

		// Insert the groups
		DB::table('groups')->insert($groups);
	}

}