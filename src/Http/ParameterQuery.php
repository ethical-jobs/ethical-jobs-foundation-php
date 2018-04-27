<?php

namespace EthicalJobs\Foundation\Http;

use EthicalJobs\Foundation\Storage\Repository;

/**
 * Parameter query interface - maps HTTP parameters to storage layer (repositories)
 */

interface ParameterQuery
{
    /**
     * Set the data store (repository)
     *
     * @param EthicalJobs\Foundation\Storage\Repository $repository
     * @return $this
     */
    public function setRepository(Repository $repository): ParameterQuery;

    /**
     * Set the http parameters and values
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters): ParameterQuery;
}