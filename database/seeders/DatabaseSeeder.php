<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\CountriesSeeder;
use Database\Seeders\OtherCountrySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([UserSeeder::class,CountriesSeeder::class,OtherCountrySeeder::class,SettingSeeder::class]);
    }
}
