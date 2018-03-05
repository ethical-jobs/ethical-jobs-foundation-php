<?php

namespace App\Services\Elasticsearch\Hydrators;

/**
 * Document Hydrator Interface
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface HydratorInterface
{
    /**
     * Hydrates eloquent models from elasticsearch response
     *
     * @param Array $response
     * @param \App\Models\Interfaces\Indexable $indexable
     * @return \Illuminate\Support\Collection
     */
    public function hydrateFromResponse(Array $response, $indexable);
}
