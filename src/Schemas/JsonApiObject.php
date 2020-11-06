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
 * See: https://jsonapi.org/format/#document-jsonapi-object
 */
class JsonApiObject implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        $array = Arr::only($array, [
            'version',
            'meta'
        ]);

        if (!isset($array['version'])) {

            $array['version'] = '1.0';

        }

        return $array;

    }

}