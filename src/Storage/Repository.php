<?php

namespace EthicalJobs\Foundation\Storage;

interface Repository
{
    /**
     * Return a single entity by identity
     *
     * @param Integer|App\Model $id
     * @return Illuminate\Database\Eloquent\Model|ArrayObject
     */
    public function findById($identifer);

    /**
     * Return the result of the query
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function find();
}
