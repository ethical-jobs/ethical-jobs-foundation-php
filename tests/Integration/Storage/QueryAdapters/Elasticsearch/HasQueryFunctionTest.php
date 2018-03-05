<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class HasQueryFunctionTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_knows_if_a_query_function_exists()
    {
        $adapter = new ElasticsearchQueryAdapter(new Search);

        $this->assertTrue($adapter->hasQueryFunction('rangeQuery'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_knows_if_a_query_function_does_not_exists()
    {
        $adapter = new ElasticsearchQueryAdapter(new Search);

        $this->assertFalse($adapter->hasQueryFunction('oneRingToRuleThemAll'));
    }    
}
