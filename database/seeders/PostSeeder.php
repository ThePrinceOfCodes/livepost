<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Database\Seeders\traits\TruncateTable;
use Database\Factories\helpers\FactoryHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    use TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->truncate('posts');
        $posts = Post::factory(3)->has(Comment::factory(3), 'comments')->untitled()->create();

        $posts->each(function (Post $post){
            $post->users()->sync([FactoryHelper::getRandomModelid(User::class)]);
        });
    }
}
