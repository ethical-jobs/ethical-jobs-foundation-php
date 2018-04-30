<?php

namespace Tests\Integration\Storage\Repositories\Database;

use Tests\Fixtures;
use Tests\Fixtures\RepositoryFactory;

class DatabaseRepositoryTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_set_and_get_its_storage_engine()
    {
        // Via constructor
        $repository = RepositoryFactory::build(new Fixtures\Person);
        $this->assertEquals($repository->getStorageEngine(), (new Fixtures\Person)->query());    

        // Via method
        $repository = RepositoryFactory::build(new Fixtures\Person);
        $repository->setStorageEngine((new Fixtures\Family)->query());
        $this->assertEquals($repository->getStorageEngine(), (new Fixtures\Family)->query());            
    }    
}
