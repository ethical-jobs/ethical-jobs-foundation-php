<?php

namespace EthicalJobs\Tests\Foundation\Integration\ServiceProviders;

use Elasticsearch\Client;
use EthicalJobs\Foundation\Elasticsearch\Index;

class ElasticsearchServiceProviderTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_loads_es_service_provider()
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertTrue($providers[\EthicalJobs\Foundation\Laravel\ElasticsearchServiceProvider::class]);
    }  

    /**
     * @test
     * @group Unit
     */
    public function it_loads_package_config()
    {
        $this->assertTrue(array_has(config('elasticsearch'), [
            'defaultConnection',
            'connections.default.hosts',
            'index',
            'settings',
            'mappings',
            'indexables',
        ]));
    }          

    /**
     * @test
     * @group Unit
     */
    public function it_registers_client_instance()
    {
        $client = $this->app->make(Client::class);

        $this->assertInstanceOf(Client::class, $client);
    }     

    /**
     * @test
     * @group Unit
     */
    public function it_registers_index_instance()
    {
        $index = $this->app->make(Index::class);

        $this->assertInstanceOf(Index::class, $index);
        $this->assertEquals('my-index', $index->getIndexName());
        $this->assertEquals(config('elasticsearch.settings'), $index->getSettings()->settings);
        $this->assertEquals(config('elasticsearch.mappings'), $index->getSettings()->mappings);
    }              
}
