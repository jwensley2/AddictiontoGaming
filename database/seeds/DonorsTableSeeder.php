<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DonorsTableSeeder extends Seeder
{

    public function run()
    {
        // Delete existing data
        DB::table('donors')->truncate();

        $donors = [
            [
                'id'          => 1,
                'email'       => 'donor@exalmple.com',
                'first_name'  => 'Testy',
                'last_name'   => 'McTester',
                'steam_id'    => 'STEAM_0:0:1234567',
                'ingame_name' => 'TheTestinator',
                'payer_id'    => '12345',
                'expires_at'  => Carbon::now()->addMonths(2),
            ],
        ];

        DB::table('donors')->insert($donors);
    }

}