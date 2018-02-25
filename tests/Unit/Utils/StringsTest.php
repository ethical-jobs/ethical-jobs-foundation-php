<?php

namespace EthicalJobs\Tests\Foundation\Unit\Utils;

use EthicalJobs\Foundation\Utils\Strings;

class StringsTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_return_search_operator_from_a_string()
    {
        $this->assertEquals(Strings::getSearchOperator('>=287363'), [
            'operator'  => '>=',
            'string'    => '287363',
        ]);

        $this->assertEquals(Strings::getSearchOperator('<=287363'), [
            'operator'  => '<=',
            'string'    => '287363',
        ]);        

        $this->assertEquals(Strings::getSearchOperator('>287363'), [
            'operator'  => '>',
            'string'    => '287363',
        ]);

        $this->assertEquals(Strings::getSearchOperator('<287363'), [
            'operator'  => '<',
            'string'    => '287363',
        ]);        

        $this->assertEquals(Strings::getSearchOperator('=287363'), [
            'operator'  => '=',
            'string'    => '287363',
        ]);

        $this->assertEquals(Strings::getSearchOperator('!=287363'), [
            'operator'  => '!=',
            'string'    => '287363',
        ]);                                        
    }
}
