<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['title' => 'Bangalore'],
            ['title' => 'Chennai']
        ];
        DB::table('cities')->insert($cities);
    }
}
