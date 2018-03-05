<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class BoolQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->boolQuery('featured', true)
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_true_query()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'featured' => true,
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->boolQuery('featured', true);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_false_query()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'featured' => false,
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->boolQuery('featured', false);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_accepts_url_like_truthies()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'featured' => true,
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->boolQuery('featured', '1');

        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'term' => [
                        'featured' => false,
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->boolQuery('featured', '0');        
    }      
}
