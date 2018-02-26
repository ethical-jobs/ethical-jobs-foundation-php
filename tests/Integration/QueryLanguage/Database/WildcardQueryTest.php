<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Database;

use Mockery;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\QueryLanguage\DatabaseQueryLanguage;

class WildcardQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_wildcard_query()
    {
        $query = Mockery::mock('query')
             ->shouldReceive('where')
             ->once()
             ->with('postcode', 'like', '127%8')
             ->getMock();

        $returnedQuery = (new DatabaseQueryLanguage)
            ->wildcardQuery($query, 'postcode', '127*8');

        $this->assertEquals($query, $returnedQuery);
    }
}
