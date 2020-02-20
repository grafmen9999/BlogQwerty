<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tag;

class TagTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @dataProvider providerCreateTag
     */
    public function testCreateTag($names, $expected)
    {
        $response = $this->actingAs(factory(User::class)->make())
                ->json('POST', '/tag', [
            '_token' => $this->faker->md5(),
            'names' => $names
        ]);
        
        $response->assertCreated()
                ->assertSuccessful();
        
        $tagsName = [];
        
        foreach (Tag::all() as $tag) {
            $tagsName[] = $tag->name;
        }
        
        $this->assertSame($expected, $tagsName);
    }
    
    public function providerCreateTag()
    {
        return [
            ['tag1, tag2, tag3', ['tag1', 'tag2', 'tag3']],
            ['tag5 tag 5tag supe_rtags userTag', ['tag5', 'tag', '5tag', 'supe_rtags', 'userTag']],
            ['tag3, tag5 tag3 tag4 tag2 tag3', ['tag3', 'tag5', 'tag4', 'tag2']],
            ['tag1|tag2|tag3|tag4|tag3|tag2|tag4', ['tag1', 'tag2', 'tag3', 'tag4']]
        ];
    }
}
