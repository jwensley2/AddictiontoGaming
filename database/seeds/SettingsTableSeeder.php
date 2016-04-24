<?php

class SettingsTableSeeder extends \Illuminate\Database\Seeder {

	public function run()
	{
		// Delete the existing data
		DB::table('settings')->truncate();

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