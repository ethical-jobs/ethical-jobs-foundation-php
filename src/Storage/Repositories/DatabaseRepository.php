<?php

namespace EthicalJobs\Foundation\Storage\Repositories;

use Traversable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EthicalJobs\Foundation\Storage\Repository;
use EthicalJobs\Foundation\Storage\RepositoryCriteria;
use EthicalJobs\Foundation\Storage\CriteriaCollection;
use EthicalJobs\Foundation\Storage\HasCriteria;

/**
 * Database repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class DatabaseRepository implements Repository, RepositoryCriteria
{
    use HasCriteria;

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

        $this->setStorageEngine($model->query());

        $this->criteria = new CriteriaCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageEngine()
    {    
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageEngine($storage)
    {    
        $this->query = $storage;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function findById($id)
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
    public function findByField(string $field, $value)
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
    public function find(): Traversable
    {
        $this->applyCriteria();

        $results = $this->query->get();

        if ($results->isEmpty()) {
            throw new NotFoundHttpException;
        }
        
        return $results;
    }   
}