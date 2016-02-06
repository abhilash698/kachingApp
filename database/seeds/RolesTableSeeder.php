<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'customer', 'display_name' => 'Customer', 'description' => 'our customers'],
            ['name' => 'merchant' , 'display_name' => 'Merchant', 'description' => 'our partnered Merchant'],
            ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Daily maintenance administrator'],
            ['name' => 'superAdmin', 'display_name' => 'Owner', 'description' => 'Owner of the application'],
        ];
        DB::table('roles')->insert($roles);
    }
}
