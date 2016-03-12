<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);   
        $this->call(TagsTableSeeder::class); 
        $this->call(MerchantUserSeeder::class);   
        $this->call(StoreSeeder::class); 
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(AppElementsSeeder::class);

        Model::reguard();
    }
}
