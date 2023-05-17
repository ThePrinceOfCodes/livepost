<?php

namespace App\Repositories;

use Exception;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = Comment::create([
                'user_id' => data_get($attributes, 'user_id'),
                'post_id' => data_get($attributes, 'post_id'),
                'body' => data_get($attributes, 'body')

            ]);

          throw_if(!$created, GeneralJsonExecption::class, 'failed to create comment');

           return $created;
        });
    }

    public function update($comment, array $attributes)
    {
        return DB::transaction(function () use($comment, $attributes){
            $updated = $comment->update([
                'user_id' => data_get($attributes, 'user_id'),
                'post_id' => data_get($attributes, 'post_id'),
                'body' => data_get($attributes, 'body')
            ]);

            throw_if(!$updated, GeneralJsonExecption::class, 'comment cannot be updated');


            // if($userIds = data_get($attributes, 'user_ids')){
            //     $Comment->users()->sync($userIds);
            // }

            return $updated;
        });
        
    }

    public function forceDelete($comment)
    {
        return DB::transaction(function () use($comment){
            $deleted = $comment->forceDelete();  
        
            throw_if(!$deleted, GeneralJsonExecption::class, 'cannot delete this comment');


            return $deleted;
        });
        
    }
}