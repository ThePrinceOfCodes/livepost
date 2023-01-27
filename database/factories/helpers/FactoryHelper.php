<?php


namespace Database\Factories\helpers;


class FactoryHelper
{

    /**
     * @param string | HasFactory $model
     */
    public static function getRandomModelId(string $model)
    {
        $count = $model::query()->count();

        if($count === 0){
            return $model::factory()->create()->id;
        }else{
            return rand(1, $count);
        }

    }
}