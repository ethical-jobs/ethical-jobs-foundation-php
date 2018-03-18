<?php

namespace Tests\Unit\Utils;

use Carbon\Carbon;
use EthicalJobs\Foundation\Utils\Timestamp;

class TimestampTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_convert_carbon_instances_to_milliseconds()
    {
        $now = Carbon::now();

        $milliseconds = Carbon::now()->timestamp * 1000;

        $this->assertEquals(Timestamp::toMilliseconds($now), $milliseconds);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_convert_date_string_to_milliseconds()
    {
        $dateString = '1983-09-28 17:55:00';

        $milliseconds = strtotime($dateString) * 1000;

        $this->assertEquals(Timestamp::toMilliseconds($dateString), $milliseconds);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_null_when_converting_an_empty_value_to_milliseconds()
    {
        $this->assertEquals(Timestamp::toMilliseconds(null), null);

        $this->assertEquals(Timestamp::toMilliseconds(''), null);

        $this->assertEquals(Timestamp::toMilliseconds(0), null);

        $this->assertEquals(Timestamp::toMilliseconds(false), null);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_unix_milliseconds_timestamp_to_carbon_instance()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertInstanceOf(Carbon::class, Timestamp::fromMilliseconds($milliseconds));

        $this->assertEquals((Timestamp::fromMilliseconds($milliseconds))->timestamp, ($milliseconds / 1000));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_milliseconds_timestamp_to_seconds_timestamp()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertEquals(Timestamp::toSeconds($milliseconds), ($milliseconds / 1000));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_determine_if_a_timestamp_is_in_miliseconds()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertTrue(Timestamp::isMilliseconds($milliseconds));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_parse_different_date_formats()
    {
        $now = Carbon::now();

        $this->assertEquals((string) Timestamp::parse('1983-09-28 17:55:00'), '1983-09-28 17:55:00');
        $this->assertEquals((string) Timestamp::parse(1465291482000), '2016-06-07 09:24:42');
        $this->assertEquals((string) Timestamp::parse($now), (string) $now);
    }
}
