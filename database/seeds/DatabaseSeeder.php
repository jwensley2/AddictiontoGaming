<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('PermissionsTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('GroupsTableSeeder');
        $this->call('NewsTableSeeder');
        $this->call('DonorsTableSeeder');
        $this->call('DonationsTableSeeder');
        $this->call('SettingsTableSeeder');
    }
}
