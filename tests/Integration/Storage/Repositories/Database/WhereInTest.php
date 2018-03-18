<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use EthicalJobs\Foundation\Storage\Repositories\DatabaseRepository;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Person;

class WhereInTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $query = Mockery::mock(Builder::class)->shouldIgnoreMissing();

        $isFluent = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->whereIn('status', ['APPROVED','DRAFT']);

        $this->assertInstanceOf(DatabaseRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_where_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('status', ['APPROVED','DRAFT'])
             ->getMock();

        $result = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->whereIn('status', ['APPROVED','DRAFT']);
    }    
}
