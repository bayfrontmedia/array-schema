## Array Schema

A simple library used to force a predefined "schema" for a given array.

- [License](#license)
- [Author](#author)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Included schemas](#included-schemas)

## License

This project is open source and available under the [MIT License](LICENSE).

## Author

<img src="https://cdn1.onbayfront.com/bfm/brand/bfm-logo.svg" alt="Bayfront Media" width="250" />

- [Bayfront Media homepage](https://www.bayfrontmedia.com?utm_source=github&amp;utm_medium=direct)
- [Bayfront Media GitHub](https://github.com/bayfrontmedia)

## Requirements

* PHP >= 7.2.0

## Installation

```
composer require bayfrontmedia/array-schema
```

## Usage

The intended usage is for a custom schema to implement `Bayfront\ArraySchema\SchemaInterface`.
This class ensures that the array conforms to its desired schema, or throws a `Bayfront\ArraySchema\InvalidSchemaException`.

The `SchemaInterface` contains only one static method:

- [create](#create)

### create

**Description:**

Returns an array conforming to the desired schema.

**Parameters:**

- `$array` (array): Input array
- `$config = []` (array): Optional configuration array which can be used to pass options necessary to build the desired schema.

**Returns:**

- (array)

**Throws:**

- `Bayfront\ArraySchema\InvalidSchemaException`

## Included schemas

This library includes some example schemas which aid in building JSON responses in accord with the latest [JSON API specification](https://jsonapi.org/format/).

These are by no means meant to be a "catch-all" solution, nor do they enforce all the JSON:API specifications. 
They are merely included as an example usage reference.

- [ResourceDocument](#resourcedocument)
- [ResourceCollectionDocument](#resourcecollectiondocument)
- [ErrorDocument](#errordocument)

### ResourceDocument

- `$array` is a single resource to return.
- If `$config['base_url']` exists, its value will be removed from any links that are returned.

**Example:**

```
use Bayfront\ArraySchema\Schemas\ResourceDocument;

$resource = [
    'type' => 'item',
    'id' => '1001',
    'attributes' => [
        'key' => 'value'
    ],
    'links' => [
        'self' => 'https://api.example.com/items/1001'
    ]
];

echo json_encode(ResourceDocument::create($resource, [
    'base_url' => 'https://api.example.com'
]));

```

The above example would return:

```
{
  "data": {
    "type": "item",
    "id": "1001",
    "attributes": {
      "key": "value"
    },
    "links": {
      "self": "/items/1001"
    }
  },
  "links": {
    "self": "CURRENT_URL"
  },
  "jsonapi": {
    "version": "1.0"
  }
}
```

<hr />

### ResourceCollectionDocument

- `$array` is an array of resource to return.
- If `$config['base_url']` exists, its value will be removed from any links that are returned.
- If `$config['meta_results']` exists, it will be used to return a `ResourceCollectionMetaResults` and `ResourceCollectionPagination` schema.

**Example:**

```
use Bayfront\ArraySchema\Schemas\ResourceCollectionDocument;

$resources = [
    [
        'type' => 'item',
        'id' => '1001',
        'attributes' => [
            'key' => 'value'
        ],
        'links' => [
            'self' => 'https://api.example.com/items/1001'
        ]
    ],
    [
        'type' => 'item',
        'id' => '1002',
        'attributes' => [
            'key' => 'value'
        ],
        'links' => [
            'self' => 'https://api.example.com/items/1002'
        ]
    ],
    [
        'type' => 'item',
        'id' => '1003',
        'attributes' => [
            'key' => 'value'
        ],
        'links' => [
            'self' => 'https://api.example.com/items/1003'
        ]
    ]
];

echo json_encode(ResourceCollectionDocument::create($resources, [
    'base_url' => 'https://api.example.com',
    'meta_results' => [
        'count' => 3,
        'total' => 10,
        'limit' => 3,
        'offset' => 0
    ]
]));
```

The above example would return:

```
{
  "data": [
    {
      "type": "item",
      "id": "1001",
      "attributes": {
        "key": "value"
      },
      "links": {
        "self": "/items/1001"
      }
    },
    {
      "type": "item",
      "id": "1002",
      "attributes": {
        "key": "value"
      },
      "links": {
        "self": "/items/1002"
      }
    },
    {
      "type": "item",
      "id": "1003",
      "attributes": {
        "key": "value"
      },
      "links": {
        "self": "/items/1003"
      }
    }
  ],
  "meta": {
    "results": {
      "count": 3,
      "total": 10,
      "limit": 3,
      "offset": 0
    }
  },
  "links": {
    "self": "CURRENT_URL",
    "first": "CURRENT_URL",
    "last": "CURRENT_URL?limit=3&offset=9",
    "prev": null,
    "next": "CURRENT_URL?limit=3&offset=3"
  },
  "jsonapi": {
    "version": "1.0"
  }
}
```

<hr />

### ErrorDocument

- `$array` is an array of errors to return.
- If `$config['base_url']` exists, its value will be removed from any links that are returned.

**Example:**

```
use Bayfront\ArraySchema\Schemas\ErrorDocument;

$errors = [
    [
        'status' => '401',
        'title' => 'Unauthorized',
        'detail' => 'Invalid or missing credentials',
        'code' => '0',
        'links' => [
            'about' => 'link to documentation'
        ]
    ]
];

echo json_encode(ErrorDocument::create($errors));

```

The above example would return:

```
{
  "errors": [
    {
      "status": "401",
      "title": "Unauthorized",
      "detail": "Invalid or missing credentials",
      "code": "0",
      "links": {
        "about": "link to documentation"
      }
    }
  ],
  "jsonapi": {
    "version": "1.0"
  }
}
```