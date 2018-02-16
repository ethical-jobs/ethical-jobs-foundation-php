<?php

namespace EthicalJobs\Tests\Foundation\Integration\ServiceProviders;

use Mockery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use EthicalJobs\Tests\Foundation\Fixtures;

class QueueServiceProviderTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_loads_queue_service_provider()
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertTrue($providers[\EthicalJobs\Foundation\Laravel\QueueServiceProvider::class]);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_logs_failing_queue_items()
    {        
        $this->expectException(\Exception::class);

        $validateArguments = function ($arg1, $arg2, $arg3) {
            $this->assertEquals('ej:queue:fail', $arg1);
            $this->assertEquals('critical', $arg3);
            $this->assertEquals('critical', $arg3);
            $this->assertEquals($arg2['job'], Fixtures\FailingQueueJob::class);
            $this->assertEquals($arg2['service'], 'Laravel');
            $this->assertEquals($arg2['connection'], 'sync');
            $this->assertEquals($arg2['exception']['message'], 'We have run out of milk!');
            $this->assertEquals($arg2['exception']['file'], "/usr/src/tests/Fixtures/FailingQueueJob.php");
            $this->assertEquals($arg2['exception']['line'], 22);
            $this->assertTrue(is_string($arg2['exception']['trace']));
            return true;
        };

        Log::shouldReceive('queue')
            ->once()
            ->withArgs($validateArguments);

        Fixtures\FailingQueueJob::dispatch();
    }      
}
