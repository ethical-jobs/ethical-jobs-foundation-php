<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class LimitQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(
            DatabaseQueryAdapter::class, 
            $adapter->limitQuery(15)
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_calls_limit_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('limit')
             ->once()
             ->with(22)
             ->getMock();

        (new DatabaseQueryAdapter($query))->limitQuery(22);
    }  
}
