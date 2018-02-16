<?php

namespace EthicalJobs\Tests\Foundation;

use EthicalJobs\Foundation\Laravel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
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