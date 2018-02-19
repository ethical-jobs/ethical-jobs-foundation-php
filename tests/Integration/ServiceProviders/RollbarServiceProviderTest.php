<?php

namespace EthicalJobs\Tests\Foundation\Integration\ServiceProviders;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Bus;
use EthicalJobs\Foundation\Logging\QueueLogEntry;

class RollbarServiceProviderTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_loads_rollbar_service_provider_in_correct_envs()
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertTrue($providers['Rollbar\Laravel\RollbarServiceProvider']);
    }     

    /**
     * @test
     * @group Unit
     */
    public function it_loads_package_config()
    {
        $config = config('services');

        $this->assertTrue(array_has($config, 'rollbar'));

        $this->assertTrue(array_has($config, 'rollbar.access_token'));
    }        
}
