<?php

/**
 * @package array-schema
 * @link https://github.com/bayfrontmedia/array-schema
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArraySchema\SchemaInterface;

/**
 * See: https://jsonapi.org/format/#errors
 *
 * Array is an array of errors to return.
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ErrorDocument implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        foreach ($array as $k => $v) {

            $array[$k] = ErrorObject::create($v, $config);

        }

        return [
            'errors' => $array,
            'jsonapi' => JsonApiObject::create([
                'version' => '1.0'
            ], $config)
        ];

    }

}