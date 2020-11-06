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
 * $array must contain: count, total, limit and offset.
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ResourceCollectionMetaResults implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        $array = Arr::only($array, [
            'count',
            'total',
            'limit',
            'offset'
        ]);

        if (Arr::isMissing($array, [
            'count',
            'total',
            'limit',
            'offset'
        ])) {
            throw new InvalidSchemaException('Invalid schema (CollectionMetaResults): missing required keys');
        }

        return $array;

    }

}