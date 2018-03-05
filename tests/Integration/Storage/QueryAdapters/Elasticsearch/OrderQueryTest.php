<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class OrderQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new ElasticsearchQueryAdapter(new Search);

        $this->assertInstanceOf(
            ElasticsearchQueryAdapter::class, 
            $adapter->orderQuery('ASC')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_calls_orderBy_with_default_field()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addSort')->once()
            ->withArgs(function ($termQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    1 => [
                        'order' => 'ASC',
                    ],
                ]);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->orderQuery('ASC');
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_specify_orderBy_field_by_calling_orderBy_query_function()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addSort')->once()
            ->withArgs(function ($termQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'expires_at' => [
                        'order' => 'asc',
                    ],
                ]);
                return true;
            })
            ->andReturn(Mockery::self())
            ->shouldReceive('addSort')->once()
            ->withArgs(function ($termQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    '_score' => [
                        'order' => 'desc',
                    ],
                ]);
                return true;
            })         
            ->andReturn(Mockery::self())        
            ->shouldReceive('addSort')->once()
            ->withArgs(function ($termQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    1 => [
                        'order' => 'ASC',
                    ],
                ]);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))
            ->orderByQuery('expires_at')
            ->orderQuery('ASC');
    }      
}
