<?php

namespace EthicalJobs\Foundation\Fractal;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\ArraySerializer;

class Normalizr extends ArraySerializer
{
    /**
     * Normalized structure
     *
     * @var array
     */
    protected $normalised = [
        'data' => [
            'entities'  => [],
            'result'    => [],
        ],
    ];

    /**
     * Current working resource
     *
     * @var array
     */
    protected $resource = null;

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        $this->normalised['data']['result'] = [];

        foreach ($data as $item) {
            $this->normalised['data']['result'][] = $item['id'];
        }

        return [$resourceKey => $data];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        $this->normalised['data']['result'] = $data['id'];

        return [$resourceKey => $data];
    }

    /**
     * Hook for the serializer to inject custom data based on the relationships of the resource.
     *
     * @param array $data
     * @param array $rawIncludedData
     *
     * @return array
     */
    public function injectData($data, $rawIncludedData)
    {
        $entityKey = key($data);

        // Normalise entity
        foreach ($data as $entity) {
            if (isset($entity[0])) { // is a collection
                foreach ($entity as $collectionItem) {
                    $this->insertEntity($entityKey, $collectionItem, $rawIncludedData);
                }
            } else { // is a single item
                $this->insertEntity($entityKey, $entity, $rawIncludedData);
            }
        }

        return $this->normalised;
    }

    protected function insertEntity($key, $entity, $relations)
    {
        if (!empty($entity)) {

            // Insert entity
            $this->normalised['data']['entities'][$key][$entity['id']] = $entity;

            // Normalise relations
            $groupedRelations = end($relations);
            reset($relations);
            // $groupedRelations = end(array_values(end(array_values($relations))));

            if (isset($groupedRelations['data'], $groupedRelations['data']['entities'])) {

                $entityRelations = $groupedRelations['data']['entities'];

                foreach ($entityRelations as $relationKey => $relations) {
                    // dump($relations);
                    foreach ($relations as $relation) {
                        if (isset($relation['id'])) {
                            $this->normalised['data']['entities'][$key][$entity['id']][$relationKey][] = $relation['id'];
                        }
                    }
                }
            }

            // remove hidden relations
            if ($transformer = $this->resource->getTransformer()) {
                if (isset($transformer->hiddenRelations)) {
                    foreach ($transformer->hiddenRelations as $hiddenRelation) {
                        unset($this->normalised['data']['entities'][$key][$entity['id']][$hiddenRelation]);
                    }
                }
            }
        }
    }

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource
     * @param array             $data
     *
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        $this->resource = $resource;

        return $this->null();
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return [];
    }

    /**
     * Indicates if includes should be side-loaded.
     *
     * @return bool
     */
    public function sideloadIncludes()
    {
        return true;
    }
}