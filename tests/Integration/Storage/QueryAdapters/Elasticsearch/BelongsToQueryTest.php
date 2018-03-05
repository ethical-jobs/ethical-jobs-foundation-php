<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class BelongsToQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->belongsToQuery('organisations', [12,82,84])
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_a_single_relation()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'organisation_id' => [
                            0 => 5151,
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('organisations', 5151);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_multiple_relations()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'organisation_id' => [
                            0 => 5151,
                            1 => 26,
                            2 => 51,
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('organisations', [5151,26,51]);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_normal_id_format_field_names()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'author_id' => [
                            0 => 5151,
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('author_id', 5151);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'author_id' => [
                            0 => 5151,
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('authors', 5151);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_non_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'terms' => [
                        'author_id' => [
                            0 => 5151,
                        ]
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('author', 5151);
    }            
}
