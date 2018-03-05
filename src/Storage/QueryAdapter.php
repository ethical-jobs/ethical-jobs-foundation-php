<?php

namespace EthicalJobs\Foundation\Storage;

/**
 * Query adapter interface - unifies our query language
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface QueryAdapter
{
    /**
     * Sets the query instance
     *
     * @param mixed $query
     * @return $this
     */
    public function setQuery($query);

    /**
     * Gets the query instance
     *
     * @return mixed
     */
    public function getQuery();    

    /**
     * Execute a range query with operators: >, <, >=, <=, =, !=
     *
     * @param string $field
     * @param string $string
     * @return mixed
     */
    public function rangeQuery(string $field, string $string);

    /**
     * Execute a date-from query (>= date)
     *
     * @param string $field
     * @param string $dateString
     * @return mixed
     */
    public function dateFromQuery(string $field, string $dateString);    

    /**
     * Execute a date-to query (<= date)
     *
     * @param string $field
     * @param string $dateString
     * @return mixed
     */
    public function dateToQuery(string $field, string $dateString);     

    /**
     * Execute a boolean query (true, 1 || false, 0)
     *
     * @param string $field
     * @param mixed $truthy
     * @return mixed
     */
    public function boolQuery(string $field, $truthy);        

    /**
     * Execute a deleted_at archived query: include, exclude, only
     *
     * @param string $field
     * @param string $inclusion
     * @return mixed
     */
    public function archivedQuery(string $field, string $inclusion);           

    /**
     * Execute a expires_at date bool query
     *
     * @param string $field
     * @param string $truthy
     * @return mixed
     */
    public function expiredQuery(string $field, string $truthy);              

    /**
     * Execute a wildcard query with the * operator
     *
     * @param string $field
     * @param string $string
     * @return mixed
     */
    public function wildcardQuery(string $field, string $string);    

    /**
     * Execute a terms matching query
     *
     * @param string $field
     * @param string|array $terms
     * @return mixed
     */
    public function termsQuery(string $field, $terms);     

    /**
     * Execute a query on belongs to one relationship
     *
     * @param string $field
     * @param string|array $ids
     * @return mixed
     */
    public function belongsToQuery(string $field, $ids);    

    /**
     * Execute a query on belongs to many relationship
     *
     * @param string $field
     * @param string|array $ids
     * @return mixed
     */
    public function belongsToManyQuery(string $field, $ids); 

    /**
     * Execute an order by query
     *
     * @param string $orderBy
     * @return mixed
     */
    public function orderByQuery(string $orderBy);   

    /**
     * Execute an order query
     *
     * @param string $direction
     * @return mixed
     */
    public function orderQuery(string $direction);                

    /**
     * Limit the current query
     *
     * @param int $limit
     * @return mixed
     */
    public function limitQuery(int $limit);                    

    /**
     * Returns true if {queryFunction} is present
     *
     * @param string $functionName
     * @return bool
     */
    public function hasQueryFunction(string $functionName): bool;
}
