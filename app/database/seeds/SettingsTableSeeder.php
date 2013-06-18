<?php

class SettingsTableSeeder extends Seeder {

	public function run()
	{
		// Delete the existing data
		DB::table('settings')->delete();

		$settings = array(
			array(
				'name'       => 'MONTHLY_COST',
				'value'      => 50,
				'serialized' => false,
			),
		);

		// Insert the settings
		DB::table('settings')->insert($settings);
	}

}