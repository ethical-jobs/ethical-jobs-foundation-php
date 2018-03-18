<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\DatabaseRepository;
use Tests\Fixtures\MockModel;

class WhereInTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $query = Mockery::mock(Builder::class)->shouldIgnoreMissing();

        $isFluent = (new DatabaseRepository)
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

        $result = (new DatabaseRepository)
            ->setQuery($query)
            ->whereIn('status', ['APPROVED','DRAFT']);
    }    
}
