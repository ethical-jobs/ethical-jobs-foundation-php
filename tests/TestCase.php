<?php

namespace Tests;

use Orchestra\Database\ConsoleServiceProvider;
use EthicalJobs\Foundation\Testing\ExtendsAssertions;
use EthicalJobs\Foundation\Laravel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
	use ExtendsAssertions;

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