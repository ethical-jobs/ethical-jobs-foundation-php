<?php

namespace EthicalJobs\Foundation\Storage\QueryAdapters;

use Carbon\Carbon;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use EthicalJobs\Foundation\Storage\QueryAdapter;
use EthicalJobs\Foundation\Utils;

/**
 * Elasticsearch query adapter
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ElasticsearchQueryAdapter implements QueryAdapter
{
    /**
     * Query buidler instance
     *
     * @param ONGR\ElasticsearchDSL\Search
     */    
    protected $query;

    /**
     * Current order by field
     *
     * @param string
     */    
    protected $orderByField;        

    /**
     * Object constructor
     *
     * @param ONGR\ElasticsearchDSL\Search
     */
    public function __construct(Search $search)
    {
        $this->setQuery($search);
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
    public function getQuery()
    {
        return $this->query;   
    }

    /**
     * {@inheritdoc}
     */
    public function rangeQuery(string $field, string $string)
    {
        $pieces = $this->explodeRangeOperators(trim($string));

        if (in_array($pieces['operator'], ['gte','lte','gt','lt'])) {
            $this->query->addQuery(
                new TermLevel\RangeQuery($field, [
                    $pieces['operator'] => $pieces['value'],
                    'boost'             => 2,
                ]), 
                BoolQuery::FILTER
            );
        } else if ($pieces['operator'] === 'not') {
            $this->query->addQuery(
                new TermLevel\TermQuery($field, $pieces['value']), 
                BoolQuery::MUST_NOT
            );
        } else {
            $this->query->addQuery(
                new TermLevel\TermQuery($field, $pieces['value']), 
                BoolQuery::MUST
            );            
        }

        return $this;       
    } 

    /**
     * {@inheritdoc}
     */
    public function dateFromQuery(string $field, string $dateString)
    {
        $field = str_finish(str_before($field, 'From'), '_at');

        $query = new TermLevel\RangeQuery($field, [
            'gte' => Utils\Timestamp::parse($dateString)->toIso8601String(),
        ]);

        $this->query->addQuery($query, BoolQuery::FILTER);

        return $this;
    }   

    /**
     * {@inheritdoc}
     */
    public function dateToQuery(string $field, string $dateString)
    {
        $field = str_finish(str_before($field, 'To'), '_at');

        $query = new TermLevel\RangeQuery($field, [
            'lte' => Utils\Timestamp::parse($dateString)->toIso8601String(),
        ]);

        $this->query->addQuery($query, BoolQuery::FILTER);

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function boolQuery(string $field, $truthy)
    {
        $query = new TermLevel\TermQuery('featured', (bool) $truthy);

        $this->query->addQuery($query, BoolQuery::FILTER);        

        return $this;
    }   

    /**
     * {@inheritdoc}
     */
    public function archivedQuery(string $field, $truthy)
    {
        if ($truthy) {
            $this->query->addQuery(new TermLevel\ExistsQuery('deleted_at'), BoolQuery::MUST);
        } else {
            $this->query->addQuery(new TermLevel\ExistsQuery('deleted_at'), BoolQuery::MUST_NOT);
        }

        return $this;
    }     

    /**
     * {@inheritdoc}
     */
    public function expiredQuery(string $field, $truthy)
    {
        if ($truthy) {
            $this->dateToQuery('expires_at', Carbon::now());
        } else {
            $this->dateFromQuery('expires_at', Carbon::now());
        }        

        return $this;
    }             

    /**
     * {@inheritdoc}
     */
    public function wildcardQuery(string $field, string $string)
    {
        $this->query->addQuery(new TermLevel\WildcardQuery($field, trim($string), [
            'boost' => 2,
        ]), BoolQuery::FILTER);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function termsQuery(string $field, $terms)
    {
        if (is_array($terms)) {
            $queryObject = new TermLevel\TermsQuery($field, $terms);
        } else {
            $queryObject = new TermLevel\TermQuery($field, $terms);
        }

        $this->query->addQuery($queryObject, BoolQuery::FILTER);

        return $this;
    }    


    /**
     * {@inheritdoc}
     */
    public function belongsToQuery(string $field, $ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        if (! str_contains($field, '_id')) {
            $field = str_singular($field).'_id';
        }

        $query = new TermLevel\TermsQuery($field, $ids);

        $this->query->addQuery($query, BoolQuery::FILTER);

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function belongsToManyQuery(string $field, $ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        $query = new TermLevel\TermsQuery($field, $ids);

        $this->query->addQuery($query, BoolQuery::FILTER);

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function orderByQuery(string $orderBy)
    {
        $this->orderByField = $orderBy;

        $this->query->addSort(new FieldSort($orderBy, 'asc'));

        $this->query->addSort(new FieldSort('_score', 'desc'));        

        return $this;
    } 

    /**
     * {@inheritdoc}
     */
    public function orderQuery(string $direction)
    {
        $this->query->addSort(new FieldSort($this->orderByField || 'created_at', $direction));        

        return $this;
    }               

    /**
     * {@inheritdoc}
     */
    public function limitQuery(int $limit)
    {
        $this->query->setSize($limit);

        return $this;
    }        

    /**
     * {@inheritdoc}
     */
    public function hasQueryFunction(string $functionName): bool
    {
        return method_exists($this, $functionName);
    }        

    /**
     * Return range query operators + search from a string
     *
     * @param string $string
     * @return array
     */
    protected function explodeRangeOperators(string $string)
    {    
        $operatorMap = [
            '>=' => 'gte',
            '<=' => 'lte',
            '<'  => 'lt',
            '>'  => 'gt',
            '!=' => 'not', // Term Query
            '='  => 'eql', // Term Query            
        ];

        $matched = '';
        $value = '';
        
        foreach ($operatorMap as $operator => $mapped) {
            if (str_contains($string, $operator)) {
                $value = str_replace($operator, '', $string);
                $matched = $mapped;
                break;
            }
        }

        return [
            'operator'  => $matched,
            'value'     => $value,
        ];
    }
}
