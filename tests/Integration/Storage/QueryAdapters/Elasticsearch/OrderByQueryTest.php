<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class OrderByQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->orderByQuery('created_at')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_belongs_to_many()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addSort')->once()
            ->withArgs(function ($termQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'created_at' => [
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
            ->getMock();

        (new ElasticsearchQueryAdapter($query))->orderByQuery('created_at');
    }  
}
