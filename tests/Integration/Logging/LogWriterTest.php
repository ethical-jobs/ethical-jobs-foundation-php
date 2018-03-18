<?php

namespace Tests\Integration\Logging;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Bus;
use EthicalJobs\Foundation\Logging\QueueLogEntry;

class LogWriterTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_queue_a_log_entry()
    {
        Bus::fake();

        $context = [
            'reason'            => 'The dolphins were hungry',
            'route'             => '/dolphins/214',
            'numberOfDolphins'  => 23,
        ];

        Log::queue('There has been an error!', $context);

        Bus::assertDispatched(QueueLogEntry::class, function ($job) use ($context) {
            if ($job->entry['message'] !== 'There has been an error!') {
                return false;
            }
            if ($job->entry['context'] !== $context) {
                return false;
            }                       
            return true;
        });
    }

    /**
     * @test
     * @group Unit
     */
    public function it_as_default_level_of_info()
    {
        Bus::fake();

        Log::queue('There has been an error!');

        Bus::assertDispatched(QueueLogEntry::class, function ($job) {
            return $job->entry['level'] === 'info';
        });
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_set_a_logging_level()
    {
        Bus::fake();

        Log::queue('There has been an error!', [], 'critical');

        Bus::assertDispatched(QueueLogEntry::class, function ($job) {
            return $job->entry['level'] === 'critical';
        });
    }         
}
