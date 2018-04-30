<?php

namespace EthicalJobs\Foundation\Storage;

use EthicalJobs\Foundation\Storage\Repository;

/**
 * Interface Criteria
 * 
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface Criteria
{
    /**
     * Apply criteria to repository query
     *
     * @param EthicalJobs\Foundation\Storage\Repository $repository
     * @return mixed
     */
    public function apply(Repository $repository);
}