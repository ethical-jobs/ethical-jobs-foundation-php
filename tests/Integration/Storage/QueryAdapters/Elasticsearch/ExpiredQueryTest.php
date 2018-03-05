<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Elasticsearch;

use Mockery;
use Carbon\Carbon;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use EthicalJobs\Foundation\Storage\QueryAdapters\ElasticsearchQueryAdapter;

class ExpiredQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new ElasticsearchQueryAdapter(new Search);

        $this->assertInstanceOf(
            ElasticsearchQueryAdapter::class, 
            $adapter->expiredQuery('expires_at', true)
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_includes_expired_when_true()
    {
        $queryAdpater = Mockery::mock(ElasticsearchQueryAdapter::class)
            ->makePartial()
            ->shouldReceive('dateToQuery')
            ->once()
            ->withArgs(function ($arg1, $arg2) {
               $this->assertEquals('expires_at', $arg1);
               $this->assertEquals(Carbon::now()->format('Y-m-d'), Carbon::parse($arg2)->format('Y-m-d'));
               return true;
            })
            ->getMock();

        $queryAdpater->expiredQuery('expires_at', true);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_does_not_include_expired_when_false()
    {
        $queryAdpater = Mockery::mock(ElasticsearchQueryAdapter::class)
            ->makePartial()
            ->shouldReceive('dateFromQuery')
            ->once()
            ->withArgs(function ($arg1, $arg2) {
               $this->assertEquals('expires_at', $arg1);
               $this->assertEquals(Carbon::now()->format('Y-m-d'), Carbon::parse($arg2)->format('Y-m-d'));
               return true;
            })
            ->getMock();

        $queryAdpater->expiredQuery('expires_at', false);
    }      
}
