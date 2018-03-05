<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class BelongsToManyQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(
            DatabaseQueryAdapter::class, 
            $adapter->belongsToManyQuery('sectors', [12,82,84])
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_belongs_to_many()
    {
        // This test needs to be extended.

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereHas')
             ->once()
             ->withArgs(function($fieldName, $callback) {
                $this->assertEquals('sectors', $fieldName);
                return true;
             })
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToManyQuery('sectors', 5151);
    }  
}
