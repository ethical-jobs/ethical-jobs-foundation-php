<?php

namespace EthicalJobs\Foundation\Storage;

/**
 * Parameter map - maps query parameters to query funcitons
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ParameterMapper
{
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
     * Sets query-parameter > query-function map
     * 
     * @param array $parameterMap
     * @return $this
     */
    public function setParameterMap(array $parameterMap)
    {
        $this->parameterMap = $parameterMap;

        return $this;
    }   

    /**
     * Returns query-parameter > query-function map
     * 
     * @return array
     */
    public function getParameterMap(): array
    {
        return $this->parameterMap;
    }  

    /**
     * Sets default parameter values
     * 
     * @param array $defaultValues
     * @return $this
     */
    public function setDefaultValues(array $defaultValues)
    {
        $this->defaultValues = $defaultValues;

        return $this;
    }      

    /**
     * Returns default query-parameter values
     *
     * @param array $merge
     * @return array
     */
    public function getDefaultValues(array $merge = []): array
    {
        return array_merge($this->defaultValues, $merge);
    }     

    /**
     * Returns the mapped query function name from a parameter
     * 
     * @param  string $parameterName
     * @return string
     */
    public function mapQueryFunction($parameterName): string
    {
        return $this->getParameterMap()[$parameterName] ?? '';
    }    
}
