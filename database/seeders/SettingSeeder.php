<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'type' => 'info',
            'key' => 'sidebar_color',
            'value' => '#001b6b',
        ]);
        DB::table('settings')->insert([
            'type' => 'info',
            'key' => 'currency',
            'value' => '$',
        ]);
        DB::table('settings')->insert([
            'type' => 'info',
            'key' => 'pay_currency',
            'value' => '$',
        ]);
    }
}
