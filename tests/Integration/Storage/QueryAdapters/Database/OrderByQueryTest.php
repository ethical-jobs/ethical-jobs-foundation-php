<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class OrderByQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->orderByQuery('created_at')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_belongs_to_many()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('orderBy')
             ->once()
             ->with('created_at')
             ->getMock();

        (new DatabaseQueryAdapter($query))->orderByQuery('created_at');
    }  
}
