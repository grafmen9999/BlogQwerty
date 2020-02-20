<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostCommentWithAuthorization()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->json('POST', '/comment', [
            '_token' => $this->faker->md5,
            'body' => $this->faker->text(),
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => null
        ]);
        
        $this->assertAuthenticated();
        $response->assertCreated()
                ->assertSuccessful();
        $this->assertJson($response->content(), Comment::first()->toJson());
    }
    
    public function testPostCommentWithoutAuthorization()
    {
        factory(User::class)->create();
        $post = factory(Post::class)->create();
        
        $response = $this->json('POST', '/comment', [
            '_token' => $this->faker->md5(),
            'body' => $this->faker->text(),
            'post_id' => $post->id,
            'user_id' => null,
            'parent_id' => null
        ]);
        
        $this->assertGuest()
                ->assertJson($response->content(), Comment::first()->toJson());
        $response->assertCreated()
                ->assertSuccessful();
    }
    
    public function testPostCommentWithParent()
    {
        factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 15)->create();
        
        $response = $this->json('POST', '/comment', [
            '_token' => $this->faker->md5(),
            'body' => $this->faker->text(),
            'post_id' => $post->id,
            'parent_id' => $comments[$this->faker->numberBetween(0, 14)]->id,
            'user_id' => null
        ]);
        
        $this->assertGuest();
        
        $this->assertJson($response->content(), Comment::all()->last()->toJson());
        $response->assertCreated()
                ->assertSuccessful();
    }
}
