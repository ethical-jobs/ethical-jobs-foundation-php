<?php

namespace EthicalJobs\Tests\Foundation\Integration\Elasticsearch;

use EthicalJobs\Foundation\Elasticsearch\IndexSettings;
use EthicalJobs\Tests\Foundation\Fixtures\MockModel;

class IndexSettingsTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_set_its_name_settings_and_mappings()
    {
        $settings = new IndexSettings('anderws-index', ['host' => 'localhost:9200'], ['dogs' => '123']);

        $this->assertEquals('anderws-index', $settings->name);
        $this->assertEquals(['host' => 'localhost:9200'], $settings->settings);
        $this->assertEquals(['dogs' => '123'], $settings->mappings);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_get_and_set_its_indexable_models()
    {
        $settings = new IndexSettings('anderws-index', ['host' => 'localhost:9200'], ['dogs' => '123']);

        $settings->setIndexables([
            MockModel::class,
        ]);

        $this->assertEquals($settings->getIndexables(), [
            MockModel::class,
        ]);
    }    
}
