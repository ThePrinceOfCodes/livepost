<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create()
    {
        $repository = $this->app->make(PostRepository::class);

        $payload = [
            'title' => 'heyaa',
            'body' => []
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Posts created does not have the same title');
    }

    public function test_update()
    {
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        $payload = [
            'title' => 'habkcvad',
        ];

        $updated = $repository->update($dummyPost, $payload);
       
        $this->assertSame($payload['title'], $updated->title, 'Updated post does not have the same title with update payload');
    }

    public function test_delete()
    {
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()->first();

        $deleted = $repository->forceDelete($dummyPost);

        $found = Post::query()->find($dummyPost->id);

        $this->assertSame(null, $found, 'post is not deleted');

    }
}
