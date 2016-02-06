<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Kaching Super Admin',
            'mobile' => '7799637741',
            'email' => 'admin@kaching.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
