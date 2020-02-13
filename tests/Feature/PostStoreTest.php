<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        factory(User::class, 15)->create();
        factory(Category::class, 10)->create();
        factory(Tag::class, 15)->create();
        factory(Post::class, 30)->create();
        factory(Comment::class, 150)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $post = factory(Post::class)->create();
        $post_model = Post::first();

        $this->assertNotNull($post_model);
        $this->assertTrue($post_model->id === $post->id);
    }
}
