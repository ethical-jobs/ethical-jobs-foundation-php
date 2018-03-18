<?php

namespace Tests\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class DateToQueryTest extends \Tests\TestCase
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
            $adapter->dateToQuery('created_at', '2018-09-28')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_date_from_query_on_normal_field()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'created_at' => [
                            'lte' => '2018-09-28T00:00:00+00:00',
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->dateToQuery('created_at', '2018-09-28');
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_date_from_query_on_a_parameter_like_field()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'created_at' => [
                            'lte' => '2018-09-28T00:00:00+00:00',
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->dateToQuery('createdTo', '2018-09-28');
    }      
}
