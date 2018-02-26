<?php

namespace EthicalJobs\Foundation\QueryLanguage;

use ONGR\ElasticsearchDSL\Query\TermLevel;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;

/**
 * Elasticsearch query language
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ElasticsearchQueryLanguage implements QueryLanguageInterface
{
    /**
     * {@inheritdoc}
     */
    public function rangeQuery($query, string $field, string $string)
    {
        $pieces = $this->explodeRangeOperators(trim($string));

        if (in_array($pieces['operator'], ['gte','lte','gt','lt'])) {
            $query->addQuery(
                new TermLevel\RangeQuery($field, [
                    $pieces['operator'] => $pieces['value'],
                    'boost'             => 2,
                ]), 
                BoolQuery::FILTER
            );
        } else if ($pieces['operator'] === 'not') {
            $query->addQuery(
                new TermLevel\TermQuery($field, $pieces['value']), 
                BoolQuery::MUST_NOT
            );
        } else {
            $query->addQuery(
                new TermLevel\TermQuery($field, $pieces['value']), 
                BoolQuery::MUST
            );            
        }

        return $query;       
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
