<?php

namespace Tests\Unit\Utils;

use Mockery;
use EthicalJobs\Foundation\Utils\ApiResources;

class ApiResourcesTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_return_a_model_class_from_a_REST_resource()
    {
        $this->assertEquals(
            ApiResources::getModelFromResource('organisations'),
            'App\Models\Organisation'
        );

        $this->assertEquals(
            ApiResources::getModelFromResource('invoices'),
            'App\Models\Invoice'
        );

        $this->assertEquals(
            ApiResources::getModelFromResource('jobs'),
            'App\Models\Job'
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_return_a_transformer_class_from_a_REST_resource()
    {
        $this->assertEquals(
            ApiResources::getTransformerFromResource('organisations'),
            'App\Transformers\Organisations\OrganisationTransformer'
        );

        $this->assertEquals(
            ApiResources::getTransformerFromResource('invoices'),
            'App\Transformers\Invoices\InvoiceTransformer'
        );

        $this->assertEquals(
            ApiResources::getTransformerFromResource('jobs'),
            'App\Transformers\Jobs\JobTransformer'
        );
    }
}