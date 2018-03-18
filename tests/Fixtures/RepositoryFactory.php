<?php

namespace Tests\Fixtures;

use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use EthicalJobs\Foundation\Storage\Repositories\DatabaseRepository;

/**
 * Creates a test Database repository instance
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class RepositoryFactory
{
    /**
     * Builds a repositorry instance for testing
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return MockClient
     */
    public static function build(Model $model)
    {
        return new DatabaseRepository($model);
    } 
}