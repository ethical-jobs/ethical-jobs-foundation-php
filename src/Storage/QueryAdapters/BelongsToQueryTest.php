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
                dd($termQuery->toArray());
                $this->assertEquals($termQuery->toArray(), [
                    'range' => [
                        'created_at' => [
                            'gte' => '2018-09-28T00:00:00+00:00',
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
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('organisation_id', [5151,26,51])
             ->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('organisations', [5151,26,51]);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_normal_id_format_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('author_id', 5151);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('authors', 5151);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_non_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new ElasticsearchQueryAdapter($query))->belongsToQuery('author', 5151);
    }            
}
