<?php

namespace EthicalJobs\Foundation\Logging;

use EthicalJobs\Foundation\Logging\QueueLogEntry;

/**
 * Extends the base logging class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Writer extends \Illuminate\Log\Writer
{
    /**
     * Creates an async log item
     *
     * @param  string  $message
     * @param  array  $context
     * @param  string  $info
     * @return void
     */
    public function queue($message, array $context = [], $level = 'info')
    {
        QueueLogEntry::dispatch($message, $context, $level);
    }
}