<?php

namespace Tests\Fixtures;

use EthicalJobs\Foundation\Storage\Repositories;

/**
 * Repository mock - for testing combined traits
 *
 * @author  Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class DatabaseRepository extends Repositories\DatabaseRepository
{
    /**
     * Object constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new MockModel);
    }
}