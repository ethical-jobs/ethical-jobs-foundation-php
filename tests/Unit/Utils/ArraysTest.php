<?php

namespace Tests\Unit\Utils;

use EthicalJobs\Foundation\Utils\Arrays;

class ArraysTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_test_for_keys_existing()
    {
        $array = [
            'apples'    => 11,
            'oranges'   => 23,
            'bananas'   => 45,
        ];

        $this->assertTrue(Arrays::hasKey($array, ['kiwis','avocados','apples']));
        $this->assertFalse(Arrays::hasKey($array, ['kiwis','avocados','tomatoes']));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_expand_dot_notaion_keys()
    {
        $array = [
            'food.fruit.apples'     => 'manzana',
            'food.fruit.oranges'    => 'naranja',
            'food.fruit.bananas'    => 'plátano',
            'plants.trees.redgum'   => 'árbol de redgum',
            'plants.trees.oak'      => 'árbol de roble',
            'plants.scrub'          => 'muchacho de negro',
        ];

        $expanded = Arrays::expandDotNotationKeys($array);

        $this->assertEquals($expanded['food']['fruit']['oranges'], 'naranja');
        $this->assertEquals($expanded['food']['fruit'], [
            'apples'     => 'manzana',
            'oranges'    => 'naranja',
            'bananas'    => 'plátano',
        ]);
        $this->assertEquals($expanded['plants']['trees']['oak'], 'árbol de roble');
        $this->assertEquals($expanded['plants']['scrub'], 'muchacho de negro');
    }    
}
