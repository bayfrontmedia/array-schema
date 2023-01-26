<?php

namespace Bayfront\ArraySchema\Schemas;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\ArraySchema\InvalidSchemaException;
use Bayfront\ArraySchema\SchemaInterface;
use Bayfront\HttpRequest\Request;

/**
 * See: https://jsonapi.org/format/#fetching-pagination
 *
 * $array should be a CollectionMetaResults schema
 * If $config['base_url'] exists, its value will be removed from any links that are returned.
 */
class ResourceCollectionPagination implements SchemaInterface
{

    /**
     * @inheritDoc
     */

    public static function create(array $array, array $config = []): array
    {

        if (Arr::isMissing($array, [
            'count',
            'total',
            'limit',
            'offset'
        ])) {
            throw new InvalidSchemaException('Invalid schema (PaginationLinks): missing required keys');
        }

        $links = [ // "first" and "last" are always added
            'self' => Request::getUrl(),
            'prev' => NULL,
            'next' => NULL
        ];

        $count = (int)$array['count'];

        $total = (int)$array['total'];

        $limit = (int)$array['limit'];

        $offset = (int)$array['offset'];

        if ($total < $limit) { // If total results are less than paged limit

            $links['first'] = Request::getUrl(true);

            $links['last'] = Request::getUrl(true);

        } else { // If more than one page of results

            $total_pages = ceil($total / $count) - 1; // Subtract 1 since offset begins with 0

            $max_offset = $total_pages * $limit; // Offset in # of results

            $request_query_keys = Request::getQuery(NULL, []);

            $remaining_query_keys = Arr::except($request_query_keys, [
                'limit',
                'offset'
            ]);

            if (empty($remaining_query_keys)) { // No remaining query parameters exist on the request

                $links['first'] = Request::getUrl();

            } else { // Additional query parameters exist on the request

                $links['first'] = Request::getUrl() . '?' . http_build_query($remaining_query_keys);

            }

            $links['last'] = Request::getUrl() . '?' . http_build_query(array_merge($remaining_query_keys, [
                    'limit' => $limit,
                    'offset' => $max_offset
                ]));

            if ($offset > 0) { // Results have been paged

                $offset_minus_limit = $offset - $limit;

                if ($offset_minus_limit == 0) { // If the previous page is the first page

                    $links['prev'] = $links['first'];

                } else {

                    /*
                     * Ensure $offset_minus_limit does not exceed $max_offset
                     */

                    $prev_offset = min($offset_minus_limit, $max_offset);

                    $links['prev'] = Request::getUrl() . '?' . http_build_query(array_merge($remaining_query_keys, [
                            'limit' => $limit,
                            'offset' => $prev_offset
                        ]));

                }

            }

            if ($offset < $max_offset) {

                $links['next'] = Request::getUrl() . '?' . http_build_query(array_merge($remaining_query_keys, [
                        'limit' => $limit,
                        'offset' => $offset + $limit
                    ]));

            }

        }

        // Remove base URL from links

        return LinksObject::create($links, $config);

    }

}