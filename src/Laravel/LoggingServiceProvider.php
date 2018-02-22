<?php

namespace EthicalJobs\Foundation\Laravel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use EthicalJobs\Foundation\Logging\Writer;

/**
 * Logging service provider
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Bind Repository interfaces to their appropriate implementations.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogger();

        $this->registerRollbar();
    }

    /**
     * Extend the logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function registerLogger()
    {
        $this->app->extend('log', function($log) {
            return new Writer($log->getMonolog(), $log->getEventDispatcher());
        });
    }   

    /**
     * Register rollbar logger
     *
     * @return \Illuminate\Log\Writer
     */
    public function registerRollbar()
    {
        dump(App::environment());
        if (in_array(App::environment(), ['production', 'staging'])) {
            dd(1);
            $this->extendConfig();

            $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }        
    }   

    /**
     * Override fractals config
     *
     * @return void
     */
    protected function extendConfig()
    {    
        $source = realpath(__DIR__.'/../../config/rollbar.php');

        $this->mergeConfigFrom($source, 'services');
    }       
}