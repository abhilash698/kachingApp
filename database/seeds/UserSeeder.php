<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($u) {
	        $u->roles()->sync([1]);
	        $u->Favourites()->sync([mt_rand(1,5),mt_rand(6,10)]);
	        $u->Votes()->sync([mt_rand(1,10)]);
	    });
    }
}
