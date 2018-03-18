<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Person;

class FindTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $expected = factory(Person::class, 10)->create();

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn($expected)
             ->getMock();

        $results = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->find();

        $results->each(function($result) {
            $this->assertInstanceOf(Person::class, $result);
        });
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

        $result = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->find();

        $this->assertEquals($expected, $result);
    }      
}
