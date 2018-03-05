<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class BelongsToQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
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
            $adapter->belongsToQuery('organisations', [12,82,84])
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_a_single_relation()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('organisation_id', [5151])
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToQuery('organisations', 5151);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_can_query_multiple_relations()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('organisation_id', [5151,26,51])
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToQuery('organisations', [5151,26,51]);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_normal_id_format_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToQuery('author_id', 5151);
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_can_use_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToQuery('authors', 5151);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_non_plural_parameter_like_field_names()
    {
        $query = Mockery::mock(Builder::class)
             ->shouldReceive('whereIn')
             ->once()
             ->with('author_id', [5151])
             ->getMock();

        (new DatabaseQueryAdapter($query))->belongsToQuery('author', 5151);
    }            
}
