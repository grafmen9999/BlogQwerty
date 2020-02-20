<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

// После исполнения одной из функций, происходит ебола, старые данные о пользователей зачищаются, а ссылается при каскадном удалении на неё, из-за этого возможны были исключения на ЭСКЬЮЭЛЬ
class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

    public function testGetPost()
    {
        $users = factory(User::class, 15)->create();
        $user = $users[0];

        factory(Category::class, 15)->create();
        factory(Post::class, 100)
            ->create([
                'user_id' => $users[$this->faker->numberBetween(0, 14)]->id
            ])->each(function (Post $post) {
                $post->tags()->save(factory(Tag::class)->create());
            });
            
        $post = Post::all()->first();

        $responseGET = $this->actingAs($user)
        ->json('GET', '/post');
        
        $this->assertAuthenticated();
        $responseGET->assertOk()
            ->assertSuccessful();
        $responseGET->assertSee($post->title);
    }
    
    public function testPostPost()
    {
        $user = factory(User::class)->create();
        $tagsId = [];
        $rand = $this->faker->numberBetween(1, 10);
        $tags = factory(Tag::class, $rand)->create();
        $categories = factory(Category::class, 15)->create();
        
        foreach ($tags as $tag) {
            if ($this->faker->numberBetween(0, 100) <= 35) {
                $tagsId[] = $tag->id;
            }
        }
        
        $responsePOST = $this->actingAs($user)->json('POST', '/post', [
            '_token' => $this->faker->md5(),
            'title' => 'The title post',
            'body' => 'The body post',
            'user_id' => $user->id,
            'category_id' => $categories[$this->faker->numberBetween(0, 14)]->id,
            'tags' => $tagsId
        ]);
        
        $post = Post::first();
        $responsePOST->assertCreated()->assertSuccessful(); 
        $this->assertJson($responsePOST->content(), $post->toJson());
    }
    
    public function testPutPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $rand = $this->faker->numberBetween(1, 25);
        $categoryId = factory(Category::class, $rand)
                ->create()[$this->faker->numberBetween(0, $rand - 1)]->id;
        $tagsId = [];
        
        foreach (factory(Tag::class, $this->faker->numberBetween(1, 25))->create() as $tag) {
            if ($this->faker->boolean(35)) {
                $tagsId[] = $tag->id;
            }
        }
        
        $responsePUT = $this->actingAs($user)
        ->json("PUT", "/post/$post->id", [
            '_token' => $this->faker->md5(),
            'title' => $this->faker->word(),
            'body' => $this->faker->text(),
            'tags' => $tagsId,
            'category_id' => $categoryId,
            'user_id' => $user->id
        ]);
        
        $responsePUT->assertOk()->assertSuccessful();
    }
    
    public function testGetPostFilterByMy()
    {
        $users = factory(User::class, 15)->create();
        $user = $users[$this->faker->numberBetween(0, 14)];
        factory(Post::class, 150)->create();
        factory(Post::class, $this->faker->numberBetween(1, 15))->create(['user_id' => $user->id]);
        $posts = Post::all();

        $response = $this->actingAs($user)
            ->json('GET', '/post', [
                'filter' => ['My']
            ]);

        $response->assertOk()->assertSuccessful();

        $actual = json_decode($response->content(), true);
        $expectedPost = [];

        foreach ($posts as $post) {
            if ($user->id === $post->user_id) {
                $expectedPost[] = $post->toArray();
            }

            // Limit
            if (count($expectedPost) === 15) {
                break;
            }
        }

        $expected = ['data' => ['posts' => $expectedPost]];

        $countActual = count($actual['data']['posts']['data']);
        $countExpected = count($expected['data']['posts']);

        $actualFirst = $actual['data']['posts']['data'][0]['id'];
        $expectedFirst = $expected['data']['posts'][0]['id'];

        $actualLast = $actual['data']['posts']['data'][$countActual - 1]['id'];
        $expectedLast = $expected['data']['posts'][$countExpected - 1]['id'];

        $this->assertSame($expectedFirst, $actualFirst);
        $this->assertSame($expectedLast, $actualLast);
        $this->assertSame($countExpected, $countActual);
    }
    
    public function testGetPostFilterByNoAnswer()
    {
        factory(User::class, 15)->create();
        $posts = factory(Post::class, 300)->create()->each(function (Post $post) {
            if ($this->faker->boolean(25)) {
                factory(Comment::class, 10)->create(['post_id' => $post->id]);
            }
        });

        $response = $this->json('GET', '/post', [
            'filter' => ['NoAnswer']
        ]);

        $response->assertOk()->assertSuccessful();

        $actual = json_decode($response->content(), true);
        $expectedPost = [];

        foreach ($posts as $post) {
            if ($post->comments()->count() === 0) {
                $expectedPost[] = $post->toArray();
            }

            // Limit
            if (count($expectedPost) === 15) {
                break;
            }
        }

        $expected = ['data' => ['posts' => $expectedPost]];

        $countActual = count($actual['data']['posts']['data']);
        $countExpected = count($expected['data']['posts']);

        $actualFirst = $actual['data']['posts']['data'][0]['id'];
        $expectedFirst = $expected['data']['posts'][0]['id'];

        $actualLast = $actual['data']['posts']['data'][$countActual - 1]['id'];
        $expectedLast = $expected['data']['posts'][$countExpected - 1]['id'];

        $this->assertSame($expectedFirst, $actualFirst);
        $this->assertSame($expectedLast, $actualLast);
        $this->assertSame($countExpected, $countActual);
    }
    
    public function testGetPostFilterByPopular()
    {
        $users = factory(User::class, 15)->create();
        factory(Post::class, 25)->create();
        
        $response = $this->json('GET', '/post', [
            'filter' => ['Popular']
        ]);

        $response->assertOk()->assertSuccessful();

        $postsExpected = ['posts' => Post::popular()->simplePaginate(15)];
        $expected = collect(['data' => $postsExpected])->toJson();
        $actual = $response->content();
        
        $actualFirst = json_decode($actual, true)['data']['posts']['data'][0]['id'];
        $expectedFirst = json_decode($expected, true)['data']['posts']['data'][0]['id'];
        
        $actualLast = json_decode($actual, true)['data']['posts']['data'][14]['id'];
        $expectedLast = json_decode($expected, true)['data']['posts']['data'][14]['id'];
        
        $this->assertSame($expectedFirst, $actualFirst);
        $this->assertSame($expectedLast, $actualLast);

        $this->assertJson($expected, $actual);
    }
    
    public function testGetPostFilterByTag()
    {
        factory(User::class, 15)->create();
        $tags = factory(Tag::class, 25)->create();
        $posts = factory(Post::class, 400)
            ->create()
            ->each(function (Post $post) use ($tags) {
                foreach ($tags as $tag) {
                    if ($this->faker->boolean(25)) {
                        $tag->posts()->save($post);
                    }
                }
            });
            
        $randomTags = [];
        
        foreach ($tags as $tag) {
            if ($this->faker->boolean(8)) {
                $randomTags[] = $tag->id;
            }
        }
        
        if (empty($randomTags)) {
            $randomTags[] = $tags[$this->faker->numberBetween(0, 24)]->id;
        }
        
        $response = $this->json('GET', '/post', [
            'tags' => $randomTags,
        ]);
        
        $response->assertOk()->assertSuccessful();
        
        $actual = json_decode($response->content(), true);
        $postsExpected = [];

        foreach ($posts as $post) {
            if ($post->has('tags')) {
                $postTags = [];
                
                foreach ($post->tags()->get() as $tag) {
                    $postTags[] = $tag->id;
                }
                
                $result = collect($randomTags)->diff($postTags);
              
                if ($result->count() === 0) {
                    $postsExpected[] = $post->toArray();
                }
                
                if (count($postsExpected) === 15) {
                    break;
                }
            }
        }
        
        $expected = ['data' => ['posts' => $postsExpected]];
        
        $actualFirst = $actual['data']['posts']['data'][0]['id'];
        $expectedFirst = $expected['data']['posts'][0]['id'];
        
        $countExpected = count($expected['data']['posts']);
        $countActual = count($actual['data']['posts']['data']);
        
        $actualLast = $actual['data']['posts']['data'][$countActual - 1]['id'];
        $expectedLast = $expected['data']['posts'][$countExpected - 1]['id'];
        
        $this->assertSame($countExpected, $countActual);
        $this->assertSame($expectedFirst, $actualFirst);
        $this->assertSame($expectedLast, $actualLast);
    }
}
