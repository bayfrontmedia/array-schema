<?php

/**
 * @package array-schema
 * @link https://github.com/bayfrontmedia/array-schema
 * @author John Robinson <john@bayfrontmedia.com>
 * @copyright 2020 Bayfront Media
 */

namespace Bayfront\ArraySchema;

interface SchemaInterface
{

    /**
     * Returns an array conforming to the desired schema.
     *
     * @param array $array (Input array)
     * @param array $config (Optional configuration array which can be used to pass options necessary to build the
     *     desired schema)
     *
     * @return array
     *
     * @throws InvalidSchemaException
     */

    public static function create(array $array, array $config = []): array;

}