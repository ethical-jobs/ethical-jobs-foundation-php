<?php

namespace Tests\Integration\Storage\Repositories\Database;

use Tests\Fixtures;
use Tests\Fixtures\RepositoryFactory;
use Tests\Fixtures\OldPeopleCriteria;
use EthicalJobs\Foundation\Storage\CriteriaCollection;

class CriteriaTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function its_criteria_are_an_empty_collection_by_default()
    {
        $repository = RepositoryFactory::build(new Fixtures\Person);
        
        $criteria = $repository->getCriteriaCollection();

        $this->assertInstanceOf(CriteriaCollection::class, $criteria);

        $this->assertTrue($criteria->isEmpty());
    }    

    /**
     * @test
     * @group Integration
     */
    public function it_can_set_and_get_it_criteria_collection()
    {
        $repository = RepositoryFactory::build(new Fixtures\Person);

        $collection = new CriteriaCollection(['foo' => 'bar']);
        
        $repository->setCriteriaCollection($collection);

        $this->assertEquals($repository->getCriteriaCollection(), $collection);
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_can_add_criteria_items()
    {
        $repository = RepositoryFactory::build(new Fixtures\Person);
        
        $expected = $repository->addCriteria(OldPeopleCriteria::class)
            ->getCriteriaCollection()
            ->get(OldPeopleCriteria::class);

        $this->assertEquals(new OldPeopleCriteria, $expected);
    }  

    /**
     * @test
     * @group Integration
     */
    public function it_can_apply_criteria()
    {
        factory(Fixtures\Person::class, 5)
            ->create(['age' => 29]);

        factory(Fixtures\Person::class, 5)
            ->create(['age' => 55]);            

        $repository = RepositoryFactory::build(new Fixtures\Person);
        
        $people = $repository
            ->addCriteria(OldPeopleCriteria::class)
            ->find();

        $people->each(function($person) {
            $this->assertTrue($person->age > 50);
        });
    }      
}
