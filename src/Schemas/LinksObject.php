<?php

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\ArraySchema\SchemaInterface;

/**
 * See: https://jsonapi.org/format/#document-links
 *
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class LinksObject implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        // Remove base URL from links

        foreach ($array as $k => $v) {

            if (is_string($v)) {

                $array[$k] = str_replace(Arr::get($config, 'base_url', ''), '', $v);

            }

        }

        return $array;

    }

}