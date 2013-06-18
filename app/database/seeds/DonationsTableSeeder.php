<?php

class DonationsTableSeeder extends Seeder {

	public function run()
	{
		// Delete the existing data
		DB::table('donations')->delete();

		$old_donations = DB::connection('old')->table('donations')->get();

		if ($old_donations)
		{
			foreach ($old_donations AS $donation)
			{
				$donations[] = array(
					'donor_id'   => $donation->donor_id,
					'txn_id'     => $donation->txn_id,
					'gross'      => $donation->amount,
					'fee'        => $donation->fee,
					'status'     => 'completed',
					'type'       => 'instant',
					'created_at' => $donation->date,
					'updated_at' => $donation->date,
				);
			}

			// Insert the donations
			foreach ($donations AS $donation)
			{
				Donation::create($donation);
			}
		}
	}

}