<?php

namespace EthicalJobs\Foundation\Utils;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Genreal Date helper class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Dates
{
    /**
     * Defines what a "recently" created date is in minutes.
     *
     * @var const
     */
    const RECENTLY = 2;

    /**
     * Returns true if $model was created recently
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @return Boolean
     */
    public static function wasCreatedRecently(Model $model)
    {
        if (isset($model->created_at)) {

            $now = Carbon::now();

            if($model->created_at->lte($now) && $model->created_at->gte($now->subMinutes(static::RECENTLY))) {
                return true;
            }
        }

        return false;
    }
}
