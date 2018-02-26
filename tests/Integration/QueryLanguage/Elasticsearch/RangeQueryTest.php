<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\QueryLanguage\ElasticsearchQueryLanguage;

class RangeQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_gte_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'age' => [
                            'gte'   => '1286',
                            'boost' => 2,                            
                        ],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '>=1286');

        $this->assertEquals($query, $returnedQuery);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_lte_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'age' => [
                            'lte'   => '1286',
                            'boost' => 2,                            
                        ],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '<=1286');

        $this->assertEquals($query, $returnedQuery);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_lt_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'age' => [
                            'lt'   => '1286',
                            'boost' => 2,                            
                        ],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '<1286');

        $this->assertEquals($query, $returnedQuery);
    }        

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_gt_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'age' => [
                            'gt'   => '1286',
                            'boost' => 2,                            
                        ],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '>1286');

        $this->assertEquals($query, $returnedQuery);
    }            

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_not_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'age' => '1286',
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::MUST_NOT);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '!=1286');

        $this->assertEquals($query, $returnedQuery);
    }     


    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_eql_range_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'age' => '1286',
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::MUST);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->rangeQuery($query, 'age', '=1286');

        $this->assertEquals($query, $returnedQuery);
    }     
}
