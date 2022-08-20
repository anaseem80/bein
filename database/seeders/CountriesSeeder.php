<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name'=>'الكويت',
            'key'=>'00965'
        ]);
        DB::table('countries')->insert([
            'name'=>'السعودية',
            'key'=>'00966'
        ]);
        DB::table('countries')->insert([
            'name'=>'الإمارات',
            'key'=>'00971'
        ]);
        DB::table('countries')->insert([
            'name'=>'عمان',
            'key'=>'00968'
        ]);
        DB::table('countries')->insert([
            'name'=>'البحرين',
            'key'=>'00973'
        ]);

    }
}
