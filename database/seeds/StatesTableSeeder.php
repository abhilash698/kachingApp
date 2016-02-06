<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['title' => 'Karnataka'],
            ['title' => 'Tamil Nadu']
        ];
        DB::table('states')->insert($states);
    }
}
