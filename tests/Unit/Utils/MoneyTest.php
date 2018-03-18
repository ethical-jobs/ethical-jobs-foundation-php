<?php

namespace Tests\Unit\Utils;

use EthicalJobs\Foundation\Utils\Money;

class MoneyTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_calculate_gst()
    {
        $this->assertEquals(Money::gst(1000), (1000 * 0.1));

        $this->assertEquals(Money::gst(198.87), (198.87 * 0.1));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_calculate_value_with_gst()
    {
        $this->assertEquals(Money::withGst(1000), (1000+(1000 * 0.1)));

        $this->assertEquals(Money::withGst(198.87), (198.87+(198.87 * 0.1)));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_format_numbers_to_money()
    {
        $this->assertEquals(Money::format(100), '$100.00');

        $this->assertEquals(Money::format(1000), '$1,000.00');

        $this->assertEquals(Money::format(10000), '$10,000.00');

        $this->assertEquals(Money::format(1000000), '$1,000,000.00');

        $this->assertEquals(Money::format(150.57), '$150.57');

        $this->assertEquals(Money::format(150.598777), '$150.60');

        $this->assertEquals(Money::format(1050.48779979), '$1,050.49');
    }
}
