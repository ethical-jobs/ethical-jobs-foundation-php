<?php

namespace EthicalJobs\Foundation\Testing;

/**
 * Test Factory interface
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface TestFactoryInterface
{
    /**
     * Creates a model
     *
     * @param Array $attributes
     * @return Illuminate\Database\Eloquent\Collection|Illuminate\Database\Eloquent\Model
     */
    public function create($attributes = []);

    /**
     * How many models to create
     *
     * @param Integer $numberOfModels
     * @return Self
     */
    public function times($numberOfModels);
}
