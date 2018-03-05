<?php

namespace EthicalJobs\Foundation\Storage\Repositories;

use ONGR\ElasticsearchDSL\Search;
use EthicalJobs\Foundation\Storage\QueriesByParameters;
use EthicalJobs\Foundation\Storage\QueryAdapter;
use EthicalJobs\Foundation\Storage\ParameterMap;

/**
 * Abstract elasticsearch repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class ElasticsearchRepository
{
    use QueriesByParameters;

    /**
     * Query param to Query function map
     *
     * @var Array
     */
    protected $parameterMap = [];

    /**
     * Default parameter values
     *
     * @var Array
     */
    protected $defaultValues = [];

    /**
     * Object constructor
     *
     * @param Illuminate\Database\Eloquent\Search $search
     * @param EthicalJobs\Foundation\Storage\QueryAdapter $queryAdapter
     * @param EthicalJobs\Foundation\Storage\ParameterMapper $parameterMapper
     */
    public function __construct(Search $search, QueryAdapter $queryAdapter, ParameterMapper $parameterMapper)
    {
        $this->setQueryAdapter($queryAdapter)
            ->setQuery($search);

        $this->setParameterMapper($parameterMapper)
            ->setParameterMap($this->parameterMap)
            ->setDefaultValues($this->defaultValues);
    }
}