<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class ArchivedQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_includes_trashed_when_true()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('withTrashed')
             ->once()
             ->withNoArgs()
             ->getMock();

        (new DatabaseQueryAdapter($query))->archivedQuery('archived', true);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_does_not_include_trashed_when_false()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldNotReceive('withTrashed')
             ->getMock();

        (new DatabaseQueryAdapter($query))->archivedQuery('archived', false);
    }      
}
