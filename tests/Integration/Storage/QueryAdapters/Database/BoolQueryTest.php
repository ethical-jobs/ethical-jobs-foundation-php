<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class BoolQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->boolQuery('featured', true));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_true_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('featured', true)
             ->getMock();

        (new DatabaseQueryAdapter($query))->boolQuery('featured', true);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_executes_a_false_query()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('featured', false)
             ->getMock();

        (new DatabaseQueryAdapter($query))->boolQuery('featured', false);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_accepts_url_like_truthies()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('featured', true)
             ->getMock();

        (new DatabaseQueryAdapter($query))->boolQuery('featured', '1');

        $query = Mockery::mock(Builder::class)
             ->shouldReceive('where')
             ->once()
             ->with('featured', false)
             ->getMock();

        (new DatabaseQueryAdapter($query))->boolQuery('featured', '0');        
    }      
}
