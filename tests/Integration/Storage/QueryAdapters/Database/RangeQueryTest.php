<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class RangeQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->rangeQuery('age', '2726'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_range_queries_with_query_language_operators()
    {
        foreach (['>=','<=','!=','=','<','>'] as $operator) {

            $query = Mockery::mock(Builder::class)
                ->shouldReceive('where')
                ->once()
                ->with('age', $operator, '1286')
                ->getMock();

            $adapter = new DatabaseQueryAdapter($query);

            $adapter->rangeQuery('age', $operator.'1286');
        }
    }

    /**
     * @test
     * @group Unit
     */
    public function it_wont_execute_range_query_on_invalid_operators()
    {
        foreach (['::',':-)','!!','--','+','%%'] as $operator) {

            $query = Mockery::mock(Builder::class)
                ->shouldReceive('where')
                ->never()
                ->getMock();

            $adapter = new DatabaseQueryAdapter($query);

            $adapter->rangeQuery($query, 'age', $operator.'1286');
        }
    }    
}
