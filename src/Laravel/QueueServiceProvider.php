<?php

namespace EthicalJobs\Foundation\Laravel;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;

/**
 * Queue service provider
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class QueueServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot() 
    {
       Queue::failing(function (JobFailed $event) {
            Log::queue("ej:queue:fail", [
                'job'           => $event->job->resolveName() ?? null,
                'service'       => config('app.name') ?? null,
                'connection'    => $event->connectionName ?? null,
                'exception' => [
                    'message' => $event->exception->getMessage() ?? null,
                    'file'    => $event->exception->getFile() ?? null,
                    'line'    => $event->exception->getLine() ?? null,
                    'trace'   => $event->exception->getTraceAsString() ?? null,                    
                ],
            ], 'critical');
        });        
    }

    /**
     * Bind Repository interfaces to their appropriate implementations.
     *
     * @return void
     */
    public function register() { }   
}