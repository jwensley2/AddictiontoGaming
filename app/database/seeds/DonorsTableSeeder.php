<?php

class DonorsTableSeeder extends Seeder {

	public function run()
	{
		// Delete existing data
		DB::table('donors')->delete();

		$old_donors = DB::connection('old')->table('donators')->get();

		if ($old_donors)
		{
			foreach ($old_donors AS $donor)
			{
				$donors[] = array(
					'id'          => $donor->id,
					'email'       => $donor->email,
					'first_name'  => $donor->first_name,
					'last_name'   => $donor->last_name,
					'steam_id'    => $donor->steam_id,
					'ingame_name' => $donor->ingame_name,
					'payer_id'    => $donor->payer_id,
					'expires_at'  => $donor->expire_date,
				);
			}

			// Insert the donors
			foreach ($donors AS $donor)
			{
				Donor::create($donor);
			}
		}
	}

}