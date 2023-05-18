<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonExecption;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = User::create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email')
            ]);

            throw_if(!$created, GeneralJsonExecption::class, 'failed to create User');

            if($userIds = data_get($attributes, 'user_ids')){
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($User, array $attributes)
    {
        return DB::transaction(function () use($User, $attributes){
            $updated = $User->update([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email')
            ]);

            throw_if(!$updated, GeneralJsonExecption::class, 'failed to update User');


            if($userIds = data_get($attributes, 'user_ids')){
                $User->users()->sync($userIds);
            }

            return $updated;
        });
        
    }

    public function forceDelete($User)
    {
        return DB::transaction(function () use($User){
            $deleted = $User->forceDelete();  
        
            throw_if(!$deleted, GeneralJsonExecption::class, 'cannot delete this User');

            return $deleted;
        });
        
    }
}