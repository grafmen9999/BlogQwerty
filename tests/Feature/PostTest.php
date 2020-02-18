<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

// После исполнения одной из функций, происходит ебола, старые данные о пользователей зачищаются, а ссылается при каскадном удалении на неё, из-за этого возможны были исключения на ЭСКЬЮЭЛЬ
class PostTest extends TestCase
{
    use RefreshDatabase;

        // factory(Category::class, 10)->create();
        // factory(Tag::class, 15)->create();
        // factory(Post::class, 30)->create();
        // factory(Comment::class, 100)->create();
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStorePostInDatabase()
    {
        $users = factory(User::class, 15)->create();

        $post = factory(Post::class, 15)->create([
            'user_id' => $users[random_int(0, 14)]->id
        ])[0];
        $post_model = Post::first();

        $this->assertNotNull($post_model);
        $this->assertTrue($post_model->id === $post->id);
    }

    public function testPost()
    {
        $users = factory(User::class, 15)->create();
        $user = $users[0];

        factory(Category::class, 15)->create();
        factory(Post::class, 100)
            ->create([
                'user_id' => $users[random_int(0, 14)]->id
            ])->each(function ($post) {
                $post->tags()->save(factory(Tag::class)->create());
            });

        $responseGET = $this->actingAs($user)
        ->json('GET', '/post');
        $responsePOST = $this->actingAs($user)
        ->json('POST', '/post', [
            'title' => 'The title post',
            'body' => 'The body post',
            'user_id' => $user->id,
            'category_id' => random_int(1, 15)
        ]);
        $post = Post::all()->last();
        $responsePUT = $this->actingAs($user)
        ->json("PUT", "post/$post->id", [
            '_token' => csrf_token(),
            'title' => 'The new title post',
            'body' => 'The new body post',
            'tags' => ["1", "2", "3", "9"],
            'category_id' => 12,
            'user_id' => $user->id
        ]);

        $this->assertAuthenticated();
/*
        // Create assert for post json
        $post = Post::all()->last();
        $postData = collect([
            ['title' => $post->title],
            ['body' => $post->body],
            ['user_id' => $post->user_id]
        ]);

        if ($post->category_id !== null) {
            $postData->push(['category_id' => $post->category_id]);
        }

        $postData
            ->push(['updated_at' => $post->updated_at->format('yy-m-d H:i:s')])
            ->push(['created_at' => $post->created_at])
            ->push(['id' => $post->id]);
        $postData = $postData->collapse()->toArray();

        $postJson = [
            'post' => $postData
        ];
        // ***********************************
*/
        $responseGET->assertOk()
            ->assertSuccessful();

        $responsePOST->assertCreated()
            ->assertSuccessful();
        
        $responsePUT->assertSuccessful();
    }
}
