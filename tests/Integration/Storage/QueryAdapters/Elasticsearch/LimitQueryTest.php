<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class LimitQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->limitQuery(15)
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_calls_limit_query()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('setSize')
            ->once()
            ->with(22)
            ->getMock();

        (new ElasticsearchQueryAdapter($query))->limitQuery(22);
    }  
}
