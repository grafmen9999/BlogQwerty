<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Tag::class, 10)->create();
        DB::table('tags')->insert([
            'name' => 'tag1'
        ]);
        DB::table('tags')->insert([
            'name' => 'tag2'
        ]);
        DB::table('tags')->insert([
            'name' => 'tag3'
        ]);
    }
}
