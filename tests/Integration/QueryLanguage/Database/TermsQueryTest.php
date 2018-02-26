<?php

namespace EthicalJobs\Tests\Foundation\Integration\QueryLanguage\Database;

use Mockery;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\QueryLanguage\DatabaseQueryLanguage;

class TermsQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_single_term_query()
    {
        $query = Mockery::mock('query')
             ->shouldReceive('whereIn')
             ->once()
             ->with('countries', ['BW'])
             ->getMock();

        $returnedQuery = (new DatabaseQueryLanguage)
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
             ->shouldReceive('whereIn')
             ->once()
             ->with('countries', ['BW','ET','SA'])
             ->getMock();

        $returnedQuery = (new DatabaseQueryLanguage)
            ->termsQuery($query, 'countries', ['BW','ET','SA']);

        $this->assertEquals($query, $returnedQuery);
    }     
}
