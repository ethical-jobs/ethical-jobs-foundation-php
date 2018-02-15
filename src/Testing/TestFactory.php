<?php

namespace EthicalJobs\Foundation\Testing;

use Illuminate\Support\Collection;

/**
 * base class for test factories
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

abstract class TestFactory implements TestFactoryInterface
{
    /**
     * How many models to create
     *
     * @var Integer
     */
    protected $numberOfModels = 1;

    /**
     * {@inheritdoc}
     */
    abstract public function create($attributes = []);

    /**
     * {@inheritdoc}
     */
    public function times($numberOfModels)
    {
        $this->numberOfModels = $numberOfModels;

        return $this;
    }

    /**
     * Populates a m-2-m relationship
     *
     * @param App\Models\Model $model
     * @param string $relation
     * @return App\Models\Model
     */
    protected function fillManyToManyRelation($model, $relation)
    {
        if (isset($this->relations[$relation])) {
            if ($this->relations[$relation] instanceof Collection) {
                $model->$relation()->saveMany($this->relations[$relation]);
            } else {
                $model->$relation()->save($this->relations[$relation]);
            }
        }

        return $model;
    }
}
