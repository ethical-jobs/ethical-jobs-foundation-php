<?php

namespace EthicalJobs\Tests\Foundation;

use Orchestra\Database\ConsoleServiceProvider;
use EthicalJobs\Foundation\Testing\InteractsWithElasticsearch;
use EthicalJobs\Foundation\Testing\ExtendsAssertions;
use EthicalJobs\Foundation\Laravel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
	use InteractsWithElasticsearch, ExtendsAssertions;

	/**
	 * Setup the test environment.
	 */
	protected function setUp()
	{
	    parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');        

        // $this->artisan('migrate', [
        // 	'--database' 	=> 'testing',
        // 	'--path' 		=> 'tests/database/migrations',
        // ]);

	    $this->withFactories(__DIR__.'/database/factories');

	    // $this->artisan('migrate', ['--database' => 'testing']);
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
	    	Laravel\ElasticsearchServiceProvider::class,
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