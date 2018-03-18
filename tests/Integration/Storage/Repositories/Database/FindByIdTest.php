<?php

namespace Tests\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\Person;

class FindByIdTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_a_model_if_one_is_passed_in()
    {
        $repository = RepositoryFactory::build(new Person);

        $id = new Person;

        $result = $repository->findById($id);

        $this->assertEquals($id, $result);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $expected = new Person;

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('find')
             ->once()
             ->with(1337)
             ->andReturn($expected)
             ->getMock();

        $result = (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->findById(1337);

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
             ->shouldReceive('find')
             ->once()
             ->with(1337)
             ->andReturn(null)
             ->getMock();

        (RepositoryFactory::build(new Person))
            ->setQuery($query)
            ->findById(1337);
    }         
}
