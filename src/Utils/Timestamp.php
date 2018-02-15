<?php

namespace EthicalJobs\Foundation\Utils;

use Carbon\Carbon;

/**
 * Timestamp utility class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Timestamp
{
    /**
     * Converts carbon instance to milliseconds
     *
     * @param PHP unix timestamp (seconds) $timestamp
     */
    public static function toMilliseconds($value = null)
    {
        if (! $value) {
            return null;
        }

        if (! $value instanceof Carbon) {
            $value = Carbon::parse($value); // attempt to parse it
        }

        return (int) $value->timestamp * 1000;
    }

    /**
     * Converts timestamp to carbon instance
     *
     * @param Carbon\Carbon $timestamp
     */
    public static function fromMilliseconds($timestamp = null)
    {
        if (! $timestamp) {
            return null;
        }

        return Carbon::createFromTimestamp(self::toSeconds($timestamp));
    }

    /**
     * Converts timestamp to seconds
     *
     * @param Javascript unix timestamp (miniseconds) $timestamp
     */
    public static function toSeconds($timestamp = null)
    {
        if (! $timestamp) {
            return null;
        }

        return (int) $timestamp / 1000;
    }

    /**
     * Truthy for checking if a timestamp is in milliseconds
     *
     * @param Javascript unix timestamp (miniseconds) $timestamp
     * @return Bool
     */
    public static function isMilliseconds($timestamp = null)
    {
        if (! $timestamp || $timestamp instanceof Carbon) {
            return false;
        }

        if (is_numeric($timestamp) && strlen((string) $timestamp) >= 12) {
            return true;
        }

        return false;
    }

    /**
     * Attempts to parse a date into Carbon
     *
     * @param  Carobon|String|Integer $timestamp
     * @return \Carbon\Carbon
     */
    public static function parse($timestamp = null)
    {
        if (static::isMilliseconds($timestamp)) {
            return static::fromMilliseconds($timestamp);
        }

        if ($timestamp instanceof Carbon) {
            return $timestamp;
        }

        return Carbon::parse($timestamp);
    }

    /**
     * Determines if a date is past
     *
     * @param  Carobon|String|Integer $date
     * @return boolean
     */
    public static function isExpired($date = null)
    {
        return (bool) self::parse($date)->lte(Carbon::now());
    }
}
