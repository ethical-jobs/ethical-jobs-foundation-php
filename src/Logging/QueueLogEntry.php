<?php

namespace EthicalJobs\Foundation\Logging;

use Illuminate\Log\Writer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Queable log entry for async logging
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class QueueLogEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3; 

    /**
     * Log entry
     *
     * @var Array
     */
    public $entry = [];

    /**
     * Create a new job instance.
     *
     * @param String $message
     * @param Arary $context
     * @param String $level
     * @return void
     */
    public function __construct(string $message, array $context = [], $level = 'info')
    {
        $this->entry = [
            'message'   => $message,
            'context'   => $context,
            'level'     => $level,
        ];
    }

    /**
     * Execute the job.
     *
     * @param  Illuminate\Log\Writer  $logger
     * @return void
     */
    public function handle(Writer $logger)
    {
        $logger->write(
            $this->entry['level'],
            $this->entry['message'],
            $this->entry['context']
        );
    } 
}