<?php

namespace Database\Seeders;

use App\Models\Comment;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    use TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('comments');
        Comment::factory(3)->create();
    }
}
