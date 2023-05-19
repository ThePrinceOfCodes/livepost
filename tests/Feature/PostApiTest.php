<?php

namespace Tests\Feature;

use App\Events\PostCreated;
use App\Events\PostDeletedEvent;
use Tests\TestCase;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
       $posts = Post::factory(10)->create();
       $postIds = $posts->map(fn ($post) => $post->id);

       $response = $this->json('get', '/api/V1/posts');

       $response->assertStatus(200);

       $data = $response->json('data');

       collect($data)->each(fn ($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));

    }

    public function test_show()
    {
        $dummyPost = Post::factory()->create();
        $response = $this->json('get', '/api/V1/posts/' . $dummyPost->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $dummyPost->id, 'Response id not the same as created post');
    }

    public function test_create()
    {
        Event::fake();
        $dummyPost = Post::factory()->make();
        // dump($dummyPost);

        $response = $this->json('post', '/api/V1/posts', $dummyPost->toArray());

        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(PostCreated::class);

        $result = collect($result)->only(array_keys($dummyPost->getAttributes()));

        $result->each(function ($value, $field) use ($dummyPost){
            $this->assertSame(data_get($dummyPost, $field), $value , 'fillable not the same');
        });
    }

    public function test_update()
    {
        $dummy = Post::factory()->create();
        $dummy2 = Post::factory()->make();
        Event::fake();

        $fillables = collect((new Post())->getFillable());

        $fillables->each(function ($toUpdate) use($dummy, $dummy2){
            $response =$this->json('patch', '/api/V1/posts/'.$dummy->id, [
                $toUpdate => data_get($dummy2, $toUpdate)
            ]);

            $result = $response->assertStatus(200)->json('data');

            Event::assertDispatched(PostCreated::class);

            $this->assertSame(data_get($dummy2, $toUpdate), data_get($dummy->refresh(), $toUpdate), 'Failed to update model');
        });
    }

    public function test_delete()
    {
        $dummy = Post::factory()->create();
        Event::fake();

        $response = $this->json('delete', '/api/V1/posts/'.$dummy->id);

        $result = $response->assertStatus(200);

        Event::assertDispatched(PostDeletedEvent::class);

        $this->expectException(ModelNotFoundException::class);

        Post::query()->findOrFail($dummy->id);

    }
}
