<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Person;

class FindByFieldTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $expected = new Person;

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('first_name', 'Andrew')
             ->andReturn(Mockery::self())
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn(collect([$expected]))
             ->getMock();

        $result = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->findByField('first_name', 'Andrew');

        $this->assertEquals($expected, $result);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_throws_http_404_exception_when_no_model_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $expected = new Person;

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('first_name', 'Andrew')
             ->andReturn(Mockery::self())
             ->shouldReceive('get')
             ->once()
             ->withNoArgs()
             ->andReturn(null)
             ->getMock();

        (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->findByField('first_name', 'Andrew');
    }         
}
