<?php

namespace EthicalJobs\Foundation\Utils;

/**
 * General HTTP request utility
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class RequestUtil
{
    /**
     * Parses request select fields into an array
     *
     * @return array
     */
    public static function getSelectFields()
    {
        if ($select = request()->input('fields')) {
            $httpRequestSelectFields = explode(',', $select);

            if (strpos($select, '*') !== false) {
                $httpRequestSelectFields = ['*'];
            }
        }

        return $httpRequestSelectFields ?? [];
    }
}
