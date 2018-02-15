<?php

namespace EthicalJobs\Foundation\Utils;

/**
 * API resource utility class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ApiResources
{
    /**
     * Returns API resources
     *
     * @return Array
     */
    public static function getResources()
    {
        return [
            'jobs',
            'organisations',
            'users',
            'media',
            'invoices',
            'taxonomies',
            'roles',
            'credits',                                    
        ];
    }

    /**
     * Returns model class from a REST resource identifier
     *
     * @param String $resource
     * @return String
     */
    public static function getModelFromResource($resource)
    {
        if (! in_array($resource, static::getResources())) {
            return '';
        }

        return 'App\Models\\' . studly_case(str_singular($resource));
    }

    /**
     * Returns transformer class from a REST resource identifier
     *
     * @param String $resource
     * @return String
     */
    public static function getTransformerFromResource($resource)
    {
        if (! in_array($resource, static::getResources())) {
            return '';
        }

        $resourceName = studly_case(str_singular($resource));

        return 'App\Transformers\\'.$resourceName.'s\\'.$resourceName.'Transformer';   
    }
}
