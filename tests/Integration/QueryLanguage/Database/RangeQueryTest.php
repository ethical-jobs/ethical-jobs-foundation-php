<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Database;

use Mockery;
use EthicalJobs\Foundation\QueryLanguage\DatabaseQueryLanguage;

class RangeQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_range_queries_with_query_language_operators()
    {
        $builder = new DatabaseQueryLanguage;

        foreach (['>=','<=','!=','=','<','>'] as $operator) {

            $query = Mockery::mock('query')
                ->shouldReceive('where')
                ->once()
                ->with('age', $operator, '1286')
                ->getMock();

            $returnedQuery = $builder->rangeQuery($query, 'age', $operator.'1286');

            $this->assertEquals($query, $returnedQuery);
        }
    }

    /**
     * @test
     * @group Unit
     */
    public function it_wont_execute_range_query_on_invalid_operators()
    {
        $builder = new DatabaseQueryLanguage;

        foreach (['::',':-)','!!','--','+','%%'] as $operator) {

            $query = Mockery::mock('query')
                ->shouldReceive('where')
                ->never()
                ->getMock();

            $returnedQuery = $builder->rangeQuery($query, 'age', $operator.'1286');

            $this->assertEquals($query, $returnedQuery);
        }
    }    
}
