<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;
use App\Project;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body'          => $faker->sentence,
        'project_id'    => function(){
            return factory(Project::class)->create()->id;
        },
        'completed'      => false
    ];
});
