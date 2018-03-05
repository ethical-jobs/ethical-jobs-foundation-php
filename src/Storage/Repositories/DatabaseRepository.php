<?php

namespace EthicalJobs\Foundation\Storage\Repositories;

use Illuminate\Database\Eloquent\Model;
use EthicalJobs\Foundation\Storage\QueriesByParameters;
use EthicalJobs\Foundation\Storage\QueryAdapter;
use EthicalJobs\Foundation\Storage\ParameterMap;

/**
 * Abstract database repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class DatabaseRepository
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
     * @param Illuminate\Database\Eloquent\Model $model
     * @param EthicalJobs\Foundation\Storage\QueryAdapter $queryAdapter
     * @param EthicalJobs\Foundation\Storage\ParameterMapper $parameterMapper
     */
    public function __construct(Model $model, QueryAdapter $queryAdapter, ParameterMapper $parameterMapper)
    {
        $this->setQueryAdapter($queryAdapter)
            ->setQuery($this->model->query());

        $this->setParameterMapper($parameterMapper)
            ->setParameterMap($this->parameterMap)
            ->setDefaultValues($this->defaultValues);
    }
}