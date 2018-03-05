<?php

namespace EthicalJobs\Tests\Foundation\Fixtures;

use EthicalJobs\Foundation\Storage;

/**
 * Repository mock - for testing combined traits
 *
 * @author  Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class MockRepository
{
    use Storage\QueriesByParameters;
}