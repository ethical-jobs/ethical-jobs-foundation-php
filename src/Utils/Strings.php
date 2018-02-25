<?php

namespace EthicalJobs\Foundation\Utils;

/**
 * Genreal string helper class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Strings
{
    /**
     * 
     * 
     *
     * @param string $string
     * @return array
     */
    public static function getSearchOperator(string $string)
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
