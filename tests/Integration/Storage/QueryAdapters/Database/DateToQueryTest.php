<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;
use EthicalJobs\Foundation\Utils;

class DateToQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->dateToQuery('created_at', '2018-09-28'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_date_from_query_on_normal_field()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->withArgs(function ($arg1, $arg2, $arg3) {
                $this->assertEquals('created_at', $arg1);
                $this->assertEquals('<=', $arg2);
                $this->assertEquals('2018-09-28', $arg3->format('Y-m-d'));
                return true;
             })
             ->getMock();

        (new DatabaseQueryAdapter($query))->dateToQuery('created_at', '2018-09-28');
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_date_from_query_on_a_parameter_like_field()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->withArgs(function ($arg1, $arg2, $arg3) {
                $this->assertEquals('created_at', $arg1);
                $this->assertEquals('<=', $arg2);
                $this->assertEquals('2018-09-28', $arg3->format('Y-m-d'));
                return true;
             })
             ->getMock();

        (new DatabaseQueryAdapter($query))->dateToQuery('createdTo', '2018-09-28');
    }      
}
