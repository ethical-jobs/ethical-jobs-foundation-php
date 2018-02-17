<?php

namespace EthicalJobs\Foundation\Testing;

use Illuminate\Support\Collection;

/**
 * Mocks the elasticsearch client
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

trait ExtendsAssertions
{
     /**
      * Determine if two associative arrays are similar
      *
      * Both arrays must have the same indexes with identical values
      * without respect to key ordering
      *
      * @param Array|Collection $expected
      * @param Array|Collection $actual
      * @return bool
      */
    function assertArrayEquals(Array $expected, Array $actual, $message = null)
    {
        if ($expected instanceof Collection) {
            $expected = $expected->toArray();
        }
        if ($actual instanceof Collection) {
            $actual = $actual->toArray();
        }

        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual, $message);
    }

     /**
      * Determine if two associative arrays are similar
      *
      * Both arrays must have the same indexes with identical values
      * without respect to key ordering
      *
      * @param Array|Collection $expected
      * @param Array|Collection $actual
      * @return bool
      */
    function assertArrayNotEquals(Array $expected, Array $actual, $message = null)
    {
        if ($expected instanceof Collection) {
            $expected = $expected->toArray();
        }
        if ($actual instanceof Collection) {
            $actual = $actual->toArray();
        }

        ksort($expected);
        ksort($actual);

        $this->assertNotEquals($expected, $actual, $message);
    }    
}