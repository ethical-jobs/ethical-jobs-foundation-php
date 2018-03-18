<?php

namespace Tests\Integration\Storage;

use Mockery;
use EthicalJobs\Foundation\Storage\ParameterMapper;

class ParameterMapperTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_can_return_a_query_function_name()
    {
        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'q'             => 'search',
            'orderBy'       => 'orderBy',
            'dateFrom'      => 'dateRangeQuery',
            'categories'    => 'termsQuery',
        ]);

        $this->assertEquals('search', $parameterMapper->mapQueryFunction('q'));
        $this->assertEquals('orderBy', $parameterMapper->mapQueryFunction('orderBy'));
        $this->assertEquals('dateRangeQuery', $parameterMapper->mapQueryFunction('dateFrom'));
        $this->assertEquals('termsQuery', $parameterMapper->mapQueryFunction('categories'));
    }

    /**
     * @test
     * @group Integration
     */
    public function it_returns_empty_string_on_failed_map()
    {
        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'q' => 'search',
        ]);

        $this->assertEquals('', $parameterMapper->mapQueryFunction('does_not_exist'));
    } 

    /**
     * @test
     * @group Integration
     */
    public function it_can_merge_default_parameter_values()
    {
        $parameterMapper = (new ParameterMapper)
            ->setDefaultValues([
                'limit'     => 261,
                'dateFrom'  => '2018-09-28 15:30:00',
                'order'     => 'DESC',
            ])
            ->setParameterMap([
                'limit'     => 'limit',
                'dateFrom'  => 'dateRangeQuery',
                'order'     => 'order'
            ]);

        $defaults = $parameterMapper->getDefaultValues([
            'order' => 'ASC',       
            'limit' => 10,
        ]);

        $this->assertEquals($defaults, [
            'limit'     => 10,
            'dateFrom'  => '2018-09-28 15:30:00',
            'order'     => 'ASC',
        ]);
    }       

    /**
     * @test
     * @group Integration
     */
    public function it_can_return_its_parameter_map()
    {
        $parameterMapper = (new ParameterMapper)->setParameterMap([
            'q'             => 'search',
            'orderBy'       => 'orderBy',
            'limit'         => 'limit',
            'dateFrom'      => 'dateRangeQuery',
            'dateTo'        => 'dateRangeQuery',
            'categories'    => 'termsQuery',
        ]);

        $this->assertEquals($parameterMapper->getParameterMap(), [
            'q'             => 'search',
            'orderBy'       => 'orderBy',
            'limit'         => 'limit',
            'dateFrom'      => 'dateRangeQuery',
            'dateTo'        => 'dateRangeQuery',
            'categories'    => 'termsQuery',
        ]);
    }      

    /**
     * @test
     * @group Integration
     */
    public function it_can_return_its_default_values()
    {
        $parameterMapper = (new ParameterMapper)->setDefaultValues([
            'limit'     => 261,
            'dateFrom'  => '2018-09-28 15:30:00',
            'order'     => 'DESC',
        ]);

        $this->assertEquals($parameterMapper->getDefaultValues(), [
            'limit'     => 261,
            'dateFrom'  => '2018-09-28 15:30:00',
            'order'     => 'DESC',
        ]);
    }         
}
