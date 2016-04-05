<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            ['title' => 'Alwarpet','city_id' => '2'],
            ['title' => 'T Nagar' ,'city_id' => '2'],
            ['title' => 'Ashok Nagar','city_id' => '2'],
            ['title' => 'Anna Nagar','city_id' => '2'],
            ['title' => 'Mylapore','city_id' => '2'],
            ['title' => 'Nungambakkam','city_id' => '2'],
        ];
        DB::table('areas')->insert($areas);
    }
}
