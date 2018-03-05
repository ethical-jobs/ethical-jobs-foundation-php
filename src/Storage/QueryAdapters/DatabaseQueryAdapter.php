<?php

namespace EthicalJobs\Foundation\Storage\QueryAdapters;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use EthicalJobs\Foundation\Storage\QueryAdapter;
use EthicalJobs\Foundation\Utils;

/**
 * Database query adapter
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class DatabaseQueryAdapter implements QueryAdapter
{
    /**
     * Query buidler instance
     *
     * @param Illuminate\Database\Query\Builder
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
     * @param Illuminate\Database\Query\Builder
     */
    public function __construct(Builder $query)
    {
        $this->setQuery($query);
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
        $search = $this->explodeRangeOperators($string);

        if ($search['operator']) {
            $this->query->where($field, $search['operator'], $search['string']);
        }

        return $this;        
    }    

    /**
     * {@inheritdoc}
     */
    public function dateFromQuery(string $field, string $dateString)
    {
        $field = str_finish(str_before($field, 'From'), '_at');

        $this->query->where($field, '>=', Utils\Timestamp::parse($dateString));

        return $this;
    }   

    /**
     * {@inheritdoc}
     */
    public function dateToQuery(string $field, string $dateString)
    {
        $field = str_finish(str_before($field, 'To'), '_at');

        $this->query->where($field, '<=', Utils\Timestamp::parse($dateString));

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function boolQuery(string $field, $truthy)
    {
        $this->query->where($field, $truthy ? true : false);

        return $this;
    }   

    /**
     * {@inheritdoc}
     */
    public function archivedQuery(string $field, $truthy)
    {
        if ($truthy) {
            $this->query->withTrashed();
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
        $string = trim(str_replace('*', '%', $string));

        $this->query->where($field, 'like', $string);

        return $this;        
    }       

    /**
     * {@inheritdoc}
     */
    public function termsQuery(string $field, $terms)
    {
        $terms = is_array($terms) ? $terms : [$terms];

        $this->query->whereIn($field, $terms);

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

        $this->query->whereIn($field, $ids);

        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function belongsToManyQuery(string $field, $ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];

        $this->query->whereHas($field, function ($query) use ($ids) {
            $query->whereIn("{$field}.id", $ids);
        });

        return $this;
    }  

    /**
     * {@inheritdoc}
     */
    public function orderByQuery(string $orderBy)
    {
        $this->orderByField = $orderBy;

        $this->query->orderBy($orderBy);

        return $this;
    } 

    /**
     * {@inheritdoc}
     */
    public function orderQuery(string $direction)
    {
        $this->query->orderBy($this->orderByField || 'created_at', $direction);

        return $this;
    }               

    /**
     * {@inheritdoc}
     */
    public function limitQuery(int $limit)
    {
        $this->query->limit($limit);

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
        $operators = ['>=','<=','!=','=','<','>'];

        $matched = '';
        
        foreach ($operators as $operator) {
            if (str_contains($string, $operator)) {
                $string = str_replace($operator, '', $string);
                $matched = $operator;
                break;
            }
        }

        return [
            'operator'  => $matched,
            'string'    => $string,
        ];
    }
}
