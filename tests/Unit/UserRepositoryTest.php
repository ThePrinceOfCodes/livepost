<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;

class userRepositoryTest extends TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(UserRepository::class);

        $payload = [
            'name' => 'Ebuka eze',
            'email' => 'prince@gmail.com',
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['email'], $result->email, 'Users created does not have the same email');
    }

    public function test_update()
    {
        $repository = $this->app->make(UserRepository::class);

        $dummyUser = User::factory(1)->create()[0];

        $payload = [
            'email' => 'princej@gmail.com',
            'name' => $dummyUser->name,
        ];

        $updated = $repository->update($dummyUser, $payload);
       
        $this->assertSame($payload['email'], $dummyUser->email, 'Updated User does not have the same email with update payload');
    }

    public function test_delete()
    {
        $repository = $this->app->make(UserRepository::class);

        $dummyUser = User::factory(1)->create()->first();

        $deleted = $repository->forceDelete($dummyUser);

        $found = User::query()->find($dummyUser->id);

        $this->assertSame(null, $found, 'User is not deleted');

    }
}
