<?php

namespace Tests\Fixtures;

use EthicalJobs\Foundation\Storage;

class OldPeopleCriteria implements Storage\Criteria
{
    public function apply(Storage\Repository $repository)
    {
    	$repository
    		->where('age', '>', 50);

        return $this;
    }     
}