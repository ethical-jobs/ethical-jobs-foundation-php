<?php

namespace EthicalJobs\Foundation\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StoreResourceException extends HttpException
{
    /**
     * Create a new resource exception instance.
     *
     * @param string                               $message
     * @param \Exception                           $previous
     * @param array                                $headers
     * @param int                                  $code
     *
     * @return void
     */
    public function __construct($message = null, Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct(422, $message, $previous, $headers, $code);
    }
}