<?php

namespace App\Repositories;

use Exception;
use App\Models\Post;
use App\Events\PostCreated;
use App\Events\PostDeletedEvent;
use App\Events\PostUpdated;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonExecption;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = Post::create([
                'title' => data_get($attributes, 'title', 'untitled'),
                'body' => data_get($attributes, 'body')
            ]);

            throw_if(!$created, GeneralJsonExecption::class, 'failed to create post');

            event(new PostCreated($created));
            if($userIds = data_get($attributes, 'user_ids')){
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($post, array $attributes)
    {
        return DB::transaction(function () use($post, $attributes){
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body)
            ]);

            throw_if(!$updated, GeneralJsonExecption::class, 'failed to update post');
            
            event(new PostUpdated($updated));

            if($userIds = data_get($attributes, 'user_ids')){
                $post->users()->sync($userIds);
            }

            return $post;

        });

        
    }

    public function forceDelete($post)
    {
        return DB::transaction(function () use($post){
            $deleted = $post->forceDelete();  
        
            throw_if(!$deleted, GeneralJsonExecption::class, 'cannot delete this post');
            event(new PostDeletedEvent($deleted));

            return $deleted;
        });
        
    }
}