<?php

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArraySchema\SchemaInterface;

/**
 * Array is an array of resources to return.
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 * If $config['meta_results'] exists, it will be used to return a ResourceCollectionMetaResults and
 * ResourceCollectionPagination schema.
 */
class ResourceCollectionDocument implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        foreach ($array as $k => $v) {
            $array[$k] = ResourceObject::create($v, $config);
        }

        $return = [
            'data' => $array
        ];

        if (isset($config['meta_results']) && is_array($config['meta_results'])) {

            $return['meta']['results'] = ResourceCollectionMetaResults::create($config['meta_results']);

            $return['links'] = ResourceCollectionPagination::create($return['meta']['results'], $config);

        }

        $return['jsonapi'] = JsonApiObject::create([
            'version' => '1.0'
        ], $config);

        return $return;

    }

}