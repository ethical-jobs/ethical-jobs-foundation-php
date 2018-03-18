<?php

namespace EthicalJobs\Foundation\Storage;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface Repository
{ 
    /**
     * Get the current query instance
     *
     * @return mixed
     */
    public function getQuery();

    /**
     * Sets the current query instance
     *
     * @param query $query
     * @return $this
     */
    public function setQuery($query);

    /**
     * Find a model by its id
     *
     * @param string|int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findById($id): Model;   

    /**
     * Find a model by a field
     *
     * @param string $field
     * @param mixed $value
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findByField(string $field, $value): Model;      

    /**
     * Executes a where query on a field.
     * - As a shortcut $operator can be $value for an assumed = operator
     * - Valid operators [>=, <=, >, <, !=, like]
     *
     * @param string $field
     * @param mixed $operator
     * @param mixed $value
     * @return $this
     */
    public function where(string $field, $operator, $value = null): Repository;  

    /**
     * Executes a whereIn query matching an array of values.
     *
     * @param string $field
     * @param array $values
     * @return $this
     */
    public function whereIn(string $field, array $values): Repository;

    /**
     * Execute an order by query
     *
     * @param string $field
     * @param  string $direction
     * @return $this
     */
    public function orderBy(string $field, string $direction): Repository;             

    /**
     * Limit the current query
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): Repository;   

    /**
     * Hydrate results as Eloquent models
     *
     * @return $self
     */   
    public function asModels(): Repository;    

    /**
     * Hydrate results as ArrayObjects
     *
     * @return $self
     */   
    public function asObjects(): Repository;    
    
    /**
     * Hydrate results as associative arrays
     *
     * @return $self
     */   
    public function asArrays(): Repository;                      

    /**
     * Return the result of the query
     *
     * @return Illuminate\Support\Collection
     */
    public function find();
}
