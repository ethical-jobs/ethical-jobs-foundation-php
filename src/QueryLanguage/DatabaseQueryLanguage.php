<?php

namespace EthicalJobs\Foundation\QueryLanguage;

/**
 * Database query language
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class DatabaseQueryLanguage implements QueryLanguageInterface
{
    /**
     * {@inheritdoc}
     */
    public function rangeQuery($query, string $field, string $string)
    {
        $search = $this->explodeRangeOperators($string);

        if ($search['operator']) {
            $query->where($field, $search['operator'], $search['string']);
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
