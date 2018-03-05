<?php

namespace EthicalJobs\Tests\Foundation\Integration\Elasticsearch\Hydrators;

use ArrayObject;
use Illuminate\Support\Collection;
use EthicalJobs\Tests\Foundation\Fixtures\MockModel;
use EthicalJobs\Foundation\Elasticsearch\Hydrators\ArrayObjectHydrator;

class ArrayObjectHydratorTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_returns_a_collection_of_array_objects()
    {
        $models = factory(MockModel::class, 5)->create();

        $response = $this->getMockSearchResults($models);

        $collection = (new ArrayObjectHydrator)
            ->hydrateFromResponse($response, new MockModel);

        $this->assertInstanceOf(Collection::class, $collection);

        $collection->each(function ($entity) {
            $this->assertInstanceOf(ArrayObject::class, $entity);
        });
    }

    /**
     * @test
     * @group Integration
     */
    public function it_sets_a_score_property_on_models()
    {
        $models = factory(MockModel::class, 3)->create();

        $response = $this->getMockSearchResults($models);

        $collection = (new ArrayObjectHydrator)
            ->hydrateFromResponse($response, new MockModel);

        $collection->each(function ($entity) {
            $this->assertEquals(1, $entity->_score);
        });
    }

    /**
     * @test
     * @group Integration
     */
    public function it_sets_a_isDocument_property_on_models()
    {
        $models = factory(MockModel::class, 3)->create();

        $response = $this->getMockSearchResults($models);

        $collection = (new ArrayObjectHydrator)
            ->hydrateFromResponse($response, new MockModel);

        $collection->each(function ($entity) {
            $this->assertTrue($entity->_isDocument);
        });
    }

    /**
     * @test
     * @group Integration
     */
    public function it_returns_empty_collection_when_there_are_no_results()
    {
        $response = [];

        $collection = (new ArrayObjectHydrator)
            ->hydrateFromResponse($response, new MockModel);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);

        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @group Integration
     * @group skipped
     */
    public function it_builds_document_relations()
    {
        $this->markTestSkipped("Test is incomplete, there are no document relations associated with the Organisation before the test is run. ");

        $modelRelations = ['users', 'jobs', 'invoices', 'credits'];

        $documentRelations = (new Models\Organisation)->getDocumentRelations();

        $organisations = factory(Models\Organisation::class, 2)
            ->create()
            ->each(function ($organisation) {
                factory(Models\Credit::class, 2)->create(['organisation_id' => $organisation->id]);
                factory(Models\Job::class, 2)->create(['organisation_id' => $organisation->id]);
            });

        $organisations->load(array_merge($modelRelations, $documentRelations));

        $response = $this->getMockSearchResults($organisations);

        $collection = (new ArrayObjectHydrator)
            ->hydrateFromResponse($response, new Models\Organisation);

        // Check that document relations are built
        foreach ($collection as $organisation) {
            foreach ($documentRelations as $relation) {
                $this->assertTrue($organisation->relationLoaded($relation));
            }
        }

        // Check that non document relations are NOT built
        foreach ($collection as $organisation) {
            foreach ($modelRelations as $relation) {
                $this->assertFalse($organisation->relationLoaded($relation));
            }
        }
    }
}
