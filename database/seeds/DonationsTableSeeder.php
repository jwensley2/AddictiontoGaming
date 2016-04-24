<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DonationsTableSeeder extends Seeder
{

    public function run()
    {
        // Delete the existing data
        DB::table('donations')->truncate();

        $donations = [
            [
                'donor_id'   => 1,
                'txn_id'     => 'TRANSACTION1',
                'gross'      => 10,
                'fee'        => 0.5,
                'status'     => 'Completed',
                'type'       => 'instant',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'donor_id'   => 1,
                'txn_id'     => 'TRANSACTION2',
                'gross'      => 10,
                'fee'        => 0.5,
                'status'     => 'Completed',
                'type'       => 'instant',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('donations')->insert($donations);
    }

}