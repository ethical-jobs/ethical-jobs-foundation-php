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
     * Returns model class from a REST resource identifier
     *
     * @param String $resource
     * @return String
     */
    public static function getModelFromResource($resource)
    {
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
        $resourceName = studly_case(str_singular($resource));

        return 'App\Transformers\\'.$resourceName.'s\\'.$resourceName.'Transformer';
    }
}
