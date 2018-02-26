<?php

namespace EthicalJobs\Foundation\QueryLanguage;

use Illuminate\Database\Query\Builder;
use ONGR\ElasticsearchDSL\Search;

/**
 * Query language interface, unifies our HTTP query language
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface QueryLanguageInterface
{
    /**
     * Execute a range query with operators: >, <, >=, <=, =, !=
     *
     * @param mixed $query
     * @param string $field
     * @param string $string
     * @return mixed
     */
    public function rangeQuery($query, string $field, string $string);

    /**
     * Execute a wildcard query with the * operator
     *
     * @param mixed $query
     * @param string $field
     * @param string $string
     * @return mixed
     */
    public function wildcardQuery($query, string $field, string $string);    

    /**
     * Execute a terms matching query
     *
     * @param mixed $query
     * @param string $field
     * @param string|array $terms
     * @return mixed
     */
    public function termsQuery($query, string $field, $terms);      
}
