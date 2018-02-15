<?php

namespace EthicalJobs\Foundation\Laravel;

use Illuminate\Support\ServiceProvider;

/**
 * Fractal service provider
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot() { }

    /**
     * Bind Repository interfaces to their appropriate implementations.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Spatie\Fractal\FractalServiceProvider::class);

        $this->extendConfig();
    }   

    /**
     * Override fractals config
     *
     * @return void
     */
    protected function extendConfig()
    {    
        $source = realpath(__DIR__.'/../../config/fractal.php');

        $this->mergeConfigFrom($source, 'fractal');
    }
}