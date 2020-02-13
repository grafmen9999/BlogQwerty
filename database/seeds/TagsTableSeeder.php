<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

/**
 * Class TagsTableSeeder
 */
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 20)->create();
    }
}
