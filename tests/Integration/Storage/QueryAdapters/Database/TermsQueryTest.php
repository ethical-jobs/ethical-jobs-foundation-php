<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class TermsQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->termsQuery('countries', 'BW'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_single_term_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('countries', ['BW'])
             ->getMock();

        (new DatabaseQueryAdapter($query))->termsQuery('countries', 'BW');
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_multi_term_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('countries', ['BW','ET','SA'])
             ->getMock();

        (new DatabaseQueryAdapter($query))->termsQuery('countries', ['BW','ET','SA']);
    }     
}
