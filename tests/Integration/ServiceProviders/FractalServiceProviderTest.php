<?php

namespace EthicalJobs\Tests\Foundation\Integration\ServiceProviders;

class FractalServiceProviderTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_registers_normalizer_from_our_config()
    {
        $config = config('fractal');

        $this->assertEquals($config['default_serializer'], \EthicalJobs\Foundation\Fractal\Normalizr::class);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_enables_auto_includes()
    {
        $config = config('fractal');

        $this->assertTrue($config['auto_includes']['enabled']);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_loads_fractal_service_provider()
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertTrue($providers[\Spatie\Fractal\FractalServiceProvider::class]);
    }           
}
