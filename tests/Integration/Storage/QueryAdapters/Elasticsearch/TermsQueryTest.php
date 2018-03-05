<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class TermsQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new ElasticsearchQueryAdapter(new Search);

        $this->assertInstanceOf(ElasticsearchQueryAdapter::class, $adapter->termsQuery('countries', 'BW'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_single_term_query()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'countries' => 'BW',
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->termsQuery('countries', 'BW');
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_multi_term_query()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'countries' => ['BW','ET','SA'],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->termsQuery('countries', ['BW','ET','SA']);
    }    
}
