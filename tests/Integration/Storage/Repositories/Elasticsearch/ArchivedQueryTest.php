<?php

namespace Tests\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class ArchivedQueryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_includes_trashed_when_true()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'exists' => [
                        'field' => 'deleted_at',
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::MUST);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->archivedQuery('archived', true);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_does_not_include_trashed_when_false()
    {
        $query = Mockery::mock(Search::class)
            ->shouldReceive('addQuery')->once()
            ->withArgs(function ($termQuery, $boolQuery) {
                $this->assertEquals($termQuery->toArray(), [
                    'exists' => [
                        'field' => 'deleted_at',
                    ],
                ]);
                $this->assertEquals($boolQuery, BoolQuery::MUST_NOT);
                return true;
            })->getMock();

        (new ElasticsearchQueryAdapter($query))->archivedQuery('archived', false);
    }      
}
