<?php

namespace App\DataFixtures\Faker;

use Faker\Provider\Base as BaseProvider;

class MineFakerProvider extends BaseProvider
{

    public function gender()
    {
        if(rand()%2 == 0)
            return 'female';
        else
            return 'male';
    }

    public function carModel()
    {
        $models = [

            'lada', 'mercedes', 'gaz', 'volvo',
            'kia', 'huyndai', 'skoda', 'subaru',
            'zaporojec', 'volga', 'jiguli', 'hammer',
            'ferrari', 'e-mobile'

        ];

        return $models[rand(0, count($models) - 1)];
    }

}