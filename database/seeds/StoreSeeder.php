<?php

use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MerchantStore::class, 10)->create()->each(function($u) {
            $u->Tags()->sync([mt_rand(1,4),mt_rand(5,7)]);
            $u->Address()->save(factory(App\MerchantStoreAddress::class)->make());
            $u->Offers()->save(factory(App\Offers::class)->make());
        });
    }
}
