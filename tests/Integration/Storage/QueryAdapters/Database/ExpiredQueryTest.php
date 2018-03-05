<?php

namespace EthicalJobs\Tests\Foundation\Integration\Storage\QueryAdapters\Database;

use Mockery;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapters\DatabaseQueryAdapter;

class ExpiredQueryTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {    
        $adapter = new DatabaseQueryAdapter(\DB::query());

        $this->assertInstanceOf(DatabaseQueryAdapter::class, $adapter->expiredQuery('expires_at', true));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_includes_expired_when_true()
    {
        $queryAdpater = Mockery::mock(DatabaseQueryAdapter::class)
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
        $queryAdpater = Mockery::mock(DatabaseQueryAdapter::class)
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
