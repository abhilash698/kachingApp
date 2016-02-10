<?php

use Illuminate\Database\Seeder;

class AppElementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_elements')->insert([
            'mabout' => 'For any queries or complaints, you can contact us on kachingtheapp@gmail.com ',
            'msupport' => 'The Kaching Merchant platform solves every restaurant/cafe/bar/nightclub owner’s biggest problem - Getting the word on deals and offers, out to the customers! Takes 10 seconds to sign up, and once you’re on board, you can keep posting as many deals as you want and edit them how ever you like - all in real time.',
        ]);
    }
}
