<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['title' => 'bar'],
            ['title' => 'restaurant'],
            ['title' => 'cafe'],
            ['title' => 'retail'],
            ['title' => 'restrobar'],
            ['title' => 'nightlife'],
            ['title' => 'lounge'],
        ];
        DB::table('tags')->insert($tags);
    }
}
