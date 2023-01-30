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

            if(!$updated){
                throw new Exception('Failed to update Comment');
            }

            // if($userIds = data_get($attributes, 'user_ids')){
            //     $Comment->users()->sync($userIds);
            // }
        });
        
    }

    public function forceDelete($comment)
    {
        return DB::transaction(function () use($comment){
            $deleted = $comment->forceDelete();  
        
            if(!$deleted){
                throw new Exception('cannot delete Comment');
            }

            return $deleted;
        });
        
    }
}