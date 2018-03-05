<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class HasQueryFunctionTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_check_a_functions_existence()
    {
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertTrue($adapter->hasQueryFunction('rangeQuery'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_check_a_functions_absence()
    {
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertFalse($adapter->hasQueryFunction('whatTheShit'));
    }    
}
