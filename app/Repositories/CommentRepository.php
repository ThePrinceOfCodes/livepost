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
                'Comment_id' => data_get($attributes, 'Comment_id'),
                'body' => data_get($attributes, 'body')

            ]);

          throw_if(!$created, GeneralJsonExecption::class, 'failed to create comment');

           return $created;
        });
    }

    public function update($Comment, array $attributes)
    {
        return DB::transaction(function () use($Comment, $attributes){
            $updated = $Comment->update([
                'user_id' => data_get($attributes, 'user_id'),
                'Comment_id' => data_get($attributes, 'Comment_id'),
                'body' => data_get($attributes, 'body')
            ]);

            throw_if(!$updated, GeneralJsonExecption::class, 'comment cannot be updated');


            // if($userIds = data_get($attributes, 'user_ids')){
            //     $Comment->users()->sync($userIds);
            // }
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