<?php

namespace EthicalJobs\Foundation\Storage\Repositories;

use Elasticsearch\Client;
use ONGR\ElasticsearchDSL\Search;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract elasticsearch repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class ElasticsearchRepository
{
    /**
     * Elasticsearch client
     * 
     * @var 
     */
    protected $client;

    /**
     * Name of the working Elasticsearch index
     * 
     * @var string
     */    
    protected $indexName;
    
    /**
     * Eloquent model 
     * 
     * @var Illuminate\Database\Eloquent\Model
     */    
    protected $model;
    
    /**
     * Elasticsearch query DSL
     * 
     * @var ONGR\ElasticsearchDSL\Search
     */    
    protected $search;

    /**
     * Object constructor
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @param Elasticsearch\Client $client
     * @param string $indexName
     * @return void
     */
    public function __construct(Model $model, Client $client, string $indexName)
    {
        $this->model = $model;

        $this->client = $client;

        $this->indexName = $indexName;

        $this->search = new Search;
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id): Model
    {
        $query = new TermLevel\TermQuery('id', $id);

        $this->query->addQuery($query, BoolQuery::FILTER);        

        return $this->find();
    }  

    /**
     * {@inheritdoc}
     */
    public function findBy(string $field, $value): Model
    {
        $query = new TermLevel\TermQuery($field, $value);

        $this->query->addQuery($query, BoolQuery::FILTER);        

        return $this->find();
    }     

    /**
     * {@inheritdoc}
     */
    public function where(string $field, $operator, $value = null): Repository
    {
        switch ($operator) {
            case '<=':
            case '>=':
            case '<':
            case '>':
                $query = new TermLevel\RangeQuery($field, [$operator => $value]);
                $bool = BoolQuery::FILTER;
                break;
            case 'like':
                $query = new TermLevel\WildcardQuery($field, str_replace('%', '*', $value));
                $bool = BoolQuery::FILTER;
                break;    
            case '!=':
                $query = new TermLevel\TermQuery($field, $value);
                $bool = BoolQuery::MUST_NOT;
                break; 
            case '=':
            default:
                $query = new TermLevel\TermQuery($field, $value);
                $bool = BoolQuery::FILTER;
                break;                                             
        }

        $this->query->addQuery($query, $bool); 

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function whereIn(string $field, array $values): Repository
    {
        $query = new TermLevel\TermsQuery($field, $values);

        $this->query->addQuery($query, BoolQuery::FILTER);        

        return $this->find();
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $field, string $direction = 'asc'): Repository
    {
        $this->query->addSort(new FieldSort($field, $direction));

        $this->query->addSort(new FieldSort('_score', $direction));  

        return $this;
    }               

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit): Repository
    {
        $this->query->setSize($limit);

        return $this;
    }   

    /**
     * {@inheritdoc}
     */  
    public function asModels(): Repository
    {
        $this->hydrator = Hydrators\EloquentHydrator::class;

        return $this;
    }    

    /**
     * {@inheritdoc}
     */ 
    public function asObjects(): Repository
    {
        $this->hydrator = Hydrators\ArrayObjectHydrator::class;

        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */ 
    public function asArrays(): Repository
    {
        $this->hydrator = Hydrators\ArrayHydrator::class;

        return $this;
    }                      

    /**
     * {@inheritdoc}
     */
    public function find(): Collection
    {
        $response = $this->client->search([
            'index' => $this->indexName,
            'type'  => $this->model->getDocumentType(),
            'body'  => $this->search->toArray(),
        ]);

        if ($response['hits']['total'] < 1) {
            throw new NotFoundHttpException;
        }

        return (new $this->hydrator)->hydrateFromResponse($response, $this->model);    
    }   
}