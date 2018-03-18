<?php

namespace Tests;

use Orchestra\Database\ConsoleServiceProvider;
use EthicalJobs\Foundation\Testing\ExtendsAssertions;
use EthicalJobs\Foundation\Laravel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
	use ExtendsAssertions;

	/**
	 * Setup the test environment.
     *
     * @return void
     */
	protected function setUp(): void
	{
	    parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');        

	    $this->withFactories(__DIR__.'/../database/factories');
	}		

	/**
	 * Inject package service provider
	 * 
	 * @param  Application $app
	 * @return Array
	 */
	protected function getPackageProviders($app)
	{
	    return [
	    	Laravel\LoggingServiceProvider::class,
	    	Laravel\FractalServiceProvider::class,
	    	Laravel\QueueServiceProvider::class,
	    	ConsoleServiceProvider::class,
	   	];
	}

	/**
	 * Inject package facade aliases
	 * 
	 * @param  Application $app
	 * @return Array
	 */
	protected function getPackageAliases($app)
	{
	    return [
	    	'Fractal' => \Spatie\Fractal\FractalFacade::class,
	    ];
	}	
}