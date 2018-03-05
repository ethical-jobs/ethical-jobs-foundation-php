<?php

use EthicalJobs\Tests\Foundation\Fixtures\MockModel;

/*
|--------------------------------------------------------------------------
| Job Factories
|--------------------------------------------------------------------------
*/

$factory->define(MockModel::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->name,
        'description'   => $faker->paragraphs(4, true),
    ];
});