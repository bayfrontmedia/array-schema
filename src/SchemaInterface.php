<?php

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