<?php

namespace EthicalJobs\Tests\Foundation\Fixtures;

use Illuminate\Database\Eloquent\Model;
use EthicalJobs\Foundation\Elasticsearch\Indexable;
use EthicalJobs\Foundation\Elasticsearch\Document;

class MockModel extends Model implements Indexable
{
    use Document;

    /**
     * {@inheritdoc}
     */
    public function getDocumentMappings()
    {
        return [
            'name' 	=> ['type' => 'text'],
            'email'	=> ['type' => 'text'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentRelations()
    {
        return [];
    }    
}