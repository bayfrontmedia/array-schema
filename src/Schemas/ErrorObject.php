<?php

/**
 * @package array-schema
 * @link https://github.com/bayfrontmedia/array-schema
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\ArraySchema\SchemaInterface;

/**
 * See: https://jsonapi.org/format/#errors
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ErrorObject implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        $array = Arr::only($array, [
            'id',
            'links',
            'status',
            'code',
            'title',
            'detail',
            'source',
            'meta'
        ]);

        // Remove base URL from links

        if (isset($array['links'])) {

            $array['links'] = LinksObject::create($array['links'], $config);

        }

        return $array;

    }

}