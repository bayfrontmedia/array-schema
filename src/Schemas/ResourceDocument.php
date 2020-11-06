<?php

/**
 * @package array-schema
 * @link https://github.com/bayfrontmedia/array-schema
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArraySchema\SchemaInterface;
use Bayfront\HttpRequest\Request;

/**
 * Array is a single resource to return.
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ResourceDocument implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        return [
            'data' => ResourceObject::create($array, $config),
            'links' => LinksObject::create([
                'self' => Request::getUrl(true)
            ], $config),
            'jsonapi' => JsonApiObject::create([
                'version' => '1.0'
            ], $config)
        ];

    }

}