<?php

namespace EthicalJobs\Tests\Foundation\Unit\Utils;

use Carbon\Carbon;
use EthicalJobs\Tests\Foundation\Fixtures\MockModel;
use EthicalJobs\Foundation\Utils\Dates;

class DatesTest extends \EthicalJobs\Tests\Foundation\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_false_when_checking_for_recent_and_date_is_null()
    {
        $model = new MockModel;

        $model->created_at = null;

        $this->assertTrue(Dates::wasCreatedRecently($model) === false);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_check_if_a_model_was_created_recently()
    {
        $model = new MockModel;

        $model->created_at = Carbon::now();
        $this->assertTrue(Dates::wasCreatedRecently($model) === true);

        $model->created_at = Carbon::now()->subMinutes(1);
        $this->assertTrue(Dates::wasCreatedRecently($model) === true);

        $model->created_at = Carbon::now()->subMinutes(1)->subSeconds(55);
        $this->assertTrue(Dates::wasCreatedRecently($model) === true);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_check_if_a_model_was_NOT_created_recently()
    {
        $model = new MockModel;

        $model->created_at = Carbon::now()->addMinutes(5);
        $this->assertTrue(Dates::wasCreatedRecently($model) === false);

        $model->created_at = Carbon::now()->subMinutes(5);
        $this->assertTrue(Dates::wasCreatedRecently($model) === false);
    }
}
