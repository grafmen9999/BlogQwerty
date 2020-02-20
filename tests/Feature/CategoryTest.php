<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @dataProvider providerCreateCategory
     */
    public function testCreateCategory($name)
    {
        $response = $this->actingAs(factory(User::class)->make())
                ->json('POST', '/category', [
            '_token' => $this->faker->md5(),
            'name' => $name
        ]);
        
        $response->assertCreated()
                ->assertSuccessful();
    }
    
    public function providerCreateCategory()
    {
        return [
            ['Category 1'],
            ['cat eg ory']
        ];
    }
}
