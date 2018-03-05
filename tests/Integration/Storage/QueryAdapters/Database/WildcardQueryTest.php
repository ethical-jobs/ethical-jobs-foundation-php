<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class WildcardQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->wildcardQuery('postcode', '1282'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_a_wildcard_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('postcode', 'like', '127%8')
             ->getMock();

        (new DatabaseQueryAdapter($query))->wildcardQuery('postcode', '127*8');
    }
}
