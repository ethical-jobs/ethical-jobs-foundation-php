<?php

namespace EthicalJobs\Foundation\Storage;

use ReflectionMethod;

/**
 * Parent repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait QueriesByParameters
{
	/**
	 * Parameter mapper instance
	 *
	 * @var ParameterMapper
	 */
	protected $parameterMapper;

	/**
	 * Query adapter instance
	 *
	 * @var QueryAdapter
	 */
	protected $queryAdapter;

	/**
	 * Returns the query adapter instance
	 * 
	 * @return QueryAdapter
	 */
    public function getQueryAdapter(): QueryAdapter
    {	
    	return $this->queryAdapter;
    }    	

	/**
	 * Sets the query adapter instance
	 *
	 * @return $this
	 */
    public function setQueryAdapter(QueryAdapter $queryAdapter)
    {	
    	$this->queryAdapter = $queryAdapter;

    	return $this;
    }

	/**
	 * Sets the query adapter instance
	 *
	 * @param  mixed $query
	 * @return $this
	 */
    public function setQuery($query)
    {	
    	$this->queryAdapter->setQuery($query);

    	return $this;
    }    

	/**
	 * Returns the parameter mapper instance
	 * 
	 * @return ParameterMapper
	 */
    public function getParameterMapper(): ParameterMapper
    {	
    	return $this->parameterMapper;
    }     

	/**
	 * Sets the parameter mapper instance
	 * 
	 * @param  ParameterMapper $parameterMapper 
	 * @return $this
	 */
    public function setParameterMapper(ParameterMapper $parameterMapper)
    {	
    	$this->parameterMapper = $parameterMapper;

    	return $this;
    }    

	/**
	 * Sets the parameter map array
	 * 
	 * @param  array $parameterMap 
	 * @return $this
	 */
    public function setParameterMap(array $parameterMap)
    {	
    	$this->parameterMapper->setParameterMap($parameterMap);

    	return $this;
    }        

	/**
	 * Sets the parameter map default values array
	 * 
	 * @param  array $defaultValues 
	 * @return $this
	 */
    public function setDefaultValues(array $defaultValues)
    {	
    	$this->parameterMapper->setDefaultValues($defaultValues);

    	return $this;
    }              

	/**
	 * Call a query functions by query parameters
	 * 
	 * @param  array $parameters 
	 * @return $this
	 */
    public function queryByParameters(array $parameters)
    {
    	$parameters = $this->parameterMapper->getDefaultValues($parameters);

        foreach ($parameters as $parameterName => $parameterValue) {
        	$this->queryByParameter($parameterName, $parameterValue);
        }
        
        return $this;  
    }	

	/**
	 * Dynamically call a query function via its query parameter
	 * 
	 * @param  string $name 
	 * @param  array $arguments 
	 * @return $this
	 */
    public function __call(string $name, array $arguments)
    {
        return $this->queryByParameter($name, ...$arguments);
    }  

	/**
	 * Call a query function by query parameter
	 * 
	 * @param  string $parameterName 
	 * @param  array $arguments
	 * @return mixed
	 */
    protected function queryByParameter(string $parameterName, ...$arguments)
    {
        if ($functionName = $this->parameterMapper->mapQueryFunction($parameterName)) {
        	if ($this->queryAdapter->hasQueryFunction($functionName)) {

        		$numberOfArgs = $this->getNumberOfArguments($functionName);

        		if ($numberOfArgs === 1) {
        			$this->queryAdapter->$functionName($arguments[0]);	
        		} else {
        			$this->queryAdapter->$functionName($parameterName, ...$arguments);
        		}
        	}
        } else if (method_exists($this, $parameterName)) {
        	return $this->$parameterName(...$arguments);
        }
        
        return $this;  
    }          

	/**
	 * Returns the number of arguments to a query function
	 * 
	 * @param  string $functionName 
	 * @return int
	 */
    protected function getNumberOfArguments(string $functionName): int
    {
		$reflection = new ReflectionMethod($this->queryAdapter, $functionName);

		return count($reflection->getParameters());
    }               	      
}