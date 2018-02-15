<?php

namespace EthicalJobs\Foundation\Exceptions;

use Illuminate\Validation\ValidationException;
use EthicalJobs\Foundation\Utils\Arrays;

/**
 * Handles exceptions & transforms into JSON
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $jsonResponse = parent::invalidJson($request, $exception);

        $original = (array) $jsonResponse->getData();

        $jsonResponse->setData(array_merge($original, [
            'statusCode'    => $exception->status,
            'errors'        => Arrays::expandDotNotationKeys((array) $original['errors']),
        ]));

        return $jsonResponse;
    }
}
