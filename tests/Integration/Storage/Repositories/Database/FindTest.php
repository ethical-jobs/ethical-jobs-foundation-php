<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\DatabaseRepository;
use Tests\Fixtures\MockModel;

class FindTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = collect([
            new MockModel, new MockModel, new MockModel,
        ]);

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn($expected)
             ->getMock();

        $result = (new DatabaseRepository)
            ->setQuery($query)
            ->find();

        $this->assertEquals($expected, $result);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_throws_exception_on_empty_results()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        
        $expected = collect([]);

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn($expected)
             ->getMock();

        $result = (new DatabaseRepository)
            ->setQuery($query)
            ->find();

        $this->assertEquals($expected, $result);
    }      
}
