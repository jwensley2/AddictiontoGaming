<?php

class GroupsTableSeeder extends Seeder {

	public function run()
	{
		// Empty the groups table
		DB::table('groups')->delete();

		// Get the groups from phpBB
		$phpbb_groups = DB::connection('phpbb')
			->table('phpbb_groups')
			->select('group_id', 'group_name', 'group_colour')
			->whereIn('group_id', array(7, 14, 19))
			->get();

		// Build an array of groups
		foreach ($phpbb_groups AS $group)
		{
			$groups[] = array(
				'id'     => $group->group_id,
				'name'   => $group->group_name,
				'colour' => $group->group_colour,
			);
		}

		// Insert the groups
		DB::table('groups')->insert($groups);
	}

}