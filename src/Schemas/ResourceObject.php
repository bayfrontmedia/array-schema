<?php

/**
 * @package array-schema
 * @link https://github.com/bayfrontmedia/array-schema
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\ArraySchema\InvalidSchemaException;
use Bayfront\ArraySchema\SchemaInterface;

/**
 * See: https://jsonapi.org/format/#document-resource-objects
 *
 * $array is the resource to return.
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ResourceObject implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        $array = Arr::only($array, [
            'id',
            'type',
            'attributes',
            'relationships',
            'links',
            'meta'
        ]);

        if (!isset($array['type']) || !isset($array['id'])) {
            throw new InvalidSchemaException('Invalid schema (Resource): missing required keys');
        }

        if (!is_string($array['type']) || !is_string($array['id'])) {
            throw new InvalidSchemaException('Invalid schema (Resource): invalid key type');
        }

        // Remove base URL from links

        if (isset($array['links'])) {

            $array['links'] = LinksObject::create($array['links'], $config);

        }

        return $array;

    }

}