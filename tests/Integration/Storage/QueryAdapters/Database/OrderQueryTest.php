<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class OrderQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->orderQuery('ASC')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_calls_orderBy_with_default_field()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('orderBy')
             ->once()
             ->with('created_at', 'ASC')
             ->getMock();

        (new DatabaseQueryAdapter($query))->orderQuery('ASC');
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_specify_orderBy_field_by_calling_orderBy_query_function()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('orderBy')
             ->once()
             ->with('expires_at')
             ->andReturn(Mockery::self())
             ->shouldReceive('orderBy')
             ->once()
             ->with('expires_at', 'ASC')
             ->getMock();

        (new DatabaseQueryAdapter($query))
            ->orderByQuery('expires_at')
            ->orderQuery('ASC');
    }      
}
