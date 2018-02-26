<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\QueryLanguage\ElasticsearchQueryLanguage;

class WildcardQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_wildcard_query()
    {
        $query = Mockery::mock('query')
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'wildcard' => [
                        'postcode' => [
                            'value' => '127*8',
                            'boost' => 2,                            
                        ],
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::FILTER);
                return true;
            })->getMock();

        $returnedQuery = (new ElasticsearchQueryLanguage)
            ->wildcardQuery($query, 'postcode', '127*8');

        $this->assertEquals($query, $returnedQuery);
    }
}
