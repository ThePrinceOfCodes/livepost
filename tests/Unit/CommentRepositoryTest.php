<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Comment;
use App\Repositories\CommentRepository;

class CommentRepositoryTest extends TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(CommentRepository::class);

        $payload = [
            'body' => 'heyaa',
            'user_id' => 1,
            'post_id' => 1
            
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['body'], $result->body, 'Comments created does not have the same title');
    }

    public function test_update()
    {
        $repository = $this->app->make(CommentRepository::class);

        $dummyComment = Comment::factory(1)->create()[0];

        $payload = [
            'body' => 'habkcvad',
            'post_id' => $dummyComment->post_id,
            'user_id' => $dummyComment->user_id
        ];

        $updated = $repository->update($dummyComment, $payload);
        
        $this->assertSame($payload['body'], $dummyComment->body, 'Updated Comment does not have the same title with update payload');
    }

    public function test_delete()
    {
        $repository = $this->app->make(CommentRepository::class);

        $dummyComment = Comment::factory(1)->create()->first();

        $deleted = $repository->forceDelete($dummyComment);

        $found = Comment::query()->find($dummyComment->id);

        $this->assertSame(null, $found, 'Comment is not deleted');

    }
}
