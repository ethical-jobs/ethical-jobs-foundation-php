<?php

namespace EthicalJobs\Foundation\Storage\Repositories;

use Traversable;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EthicalJobs\Foundation\Storage\Repository;

/**
 * Database repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class DatabaseRepository implements Repository
{
    /**
     * Eloquent model 
     * 
     * @var Illuminate\Database\Eloquent\Model
     */    
    protected $model;

    /**
     * Eloquent model query builder
     * 
     * @var Illuminate\Database\Eloquent\Builder
     */    
    protected $query;    

    /**
     * Object constructor
     *
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->query = $model->query();
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {    
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery($query)
    {    
        $this->query = $query;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function findById($id): Model
    {
        if ($id instanceof Model) {
            return $id;
        }

        if ($entity = $this->query->find($id)) {
            return $entity;
        }

        throw new NotFoundHttpException("Entity with id: $id not found");
    }  

    /**
     * {@inheritdoc}
     */
    public function findByField(string $field, $value): Model
    {
        if ($results = $this->query->where($field, $value)->get()) {
            return $results->first();
        }

        throw new NotFoundHttpException("Entity with field $field and value $value not found");
    }     

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Repository
    {
        $this->query->where($field, $operator, $value);

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Repository
    {
        $this->query->whereIn($field, $values);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, $direction = 'asc'): Repository
    {
        $this->query->orderBy($field, $direction);

        return $this;
    }            

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Repository
    {
        $this->query->limit($limit);

        return $this;
    }   

    /**
     * {@inheritdoc}
     */  
    public function asModels(): Repository
    {
        return $this;
    }    

    /**
     * {@inheritdoc}
     */ 
    public function asObjects(): Repository
    {
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */ 
    public function asArrays(): Repository
    {
        return $this;
    }                      

    /**
     * {@inheritdoc}
     */
    public function find(): Traversable
    {
        $results = $this->query->get();

        if ($results->isEmpty()) {
            throw new NotFoundHttpException;
        }
        
        return $results;
    }   
}