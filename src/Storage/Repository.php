<?php

namespace EthicalJobs\Foundation\Storage;

use Traversable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface Repository
{ 
    /**
     * Get the current storage engine instance
     *
     * @return mixed
     */
    public function getStorageEngine();

    /**
     * Sets the current storage engine instance
     *
     * @param mixed $storage
     * @return $this
     */
    public function setStorageEngine($storage);

    /**
     * Find a model by its id
     *
     * @param string|int $id
     * @return mixed
     */
    public function findById($id);   

    /**
     * Find a model by a field
     *
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    public function findByField(string $field, $value);      

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
     * Return the result of the query
     *
     * @return Traversable
     */
    public function find(): Traversable;
}
