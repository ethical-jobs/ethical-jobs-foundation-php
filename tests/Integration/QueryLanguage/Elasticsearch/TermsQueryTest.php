<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\QueryLanguage\ElasticsearchQueryLanguage;

class TermsQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_single_term_query()
    {
        $query = Mockery::mock('query')
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

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->termsQuery($query, 'countries', 'BW');

        $this->assertEquals($query, $returnedQuery);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_multi_term_query()
    {
        $query = Mockery::mock('query')
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

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->termsQuery($query, 'countries', ['BW','ET','SA']);

        $this->assertEquals($query, $returnedQuery);
    }    
}
