<?php

namespace EthicalJobs\Tests\Foundation\Integration\Elasticsearch;

use Mockery;
use Elasticsearch\Client;
use EthicalJobs\Foundation\Elasticsearch\DocumentIndexer;
use EthicalJobs\Tests\Foundation\Fixtures\MockModel;
use EthicalJobs\Foundation\Elasticsearch\Index;

class DocumentIndexerTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_set_class_params()
    {
        $client = Mockery::mock(Client::class);

        $index = app()->make(Index::class);

        $indexer = new DocumentIndexer($client, $index);

        $this->assertInstanceOf(DocumentIndexer::class, $indexer->setClient($client));

        $this->assertInstanceOf(DocumentIndexer::class, $indexer->setChunkSize(5));

        $this->assertInstanceOf(DocumentIndexer::class, $indexer->setLogging(true));
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_index_a_single_entity()
    {
        $entity = new MockModel;

        $client = Mockery::mock(Client::class)
            ->shouldReceive('index')
            ->once()
            ->with([
                'index' => 'my-index',
                'id'    => null,
                'type'  => 'mock_models',
                'body'  => [],
            ])
            ->andReturn('success')
            ->getMock();

        $index = app()->make(Index::class);

        $indexer = new DocumentIndexer($client, $index);            

        $result = $indexer->indexDocument($entity);

        $this->assertEquals('success', $result);
    }

    /**
     * @test
     * @group Integration
     */
    public function it_can_delete_a_single_entity()
    {
        $entity = new MockModel;

        $client = Mockery::mock(Client::class)
            ->shouldReceive('delete')
            ->with([
                'index' => 'my-index',
                'id'    => null,
                'type'  => 'mock_models',
            ])
            ->andReturn('deleted')
            ->getMock();

        $index = app()->make(Index::class);

        $indexer = new DocumentIndexer($client, $index); 

        $result = $indexer->deleteDocument($entity);

        $this->assertEquals('deleted', $result);
    }
}
