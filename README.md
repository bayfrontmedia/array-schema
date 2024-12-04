## Array Schema

A simple library used to force a predefined "schema" for a given array.

- [License](#license)
- [Author](#author)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)

## License

This project is open source and available under the [MIT License](LICENSE).

## Author

<img src="https://cdn1.onbayfront.com/bfm/brand/bfm-logo.svg" alt="Bayfront Media" width="250" />

- [Bayfront Media homepage](https://www.bayfrontmedia.com?utm_source=github&amp;utm_medium=direct)
- [Bayfront Media GitHub](https://github.com/bayfrontmedia)

## Requirements

* PHP `^8.0`

## Installation

```shell
composer require bayfrontmedia/array-schema
```

## Usage

The intended usage is for a custom schema to implement `Bayfront\ArraySchema\SchemaInterface`.
The `Bayfront\ArraySchema\InvalidSchemaException` is provided for any exceptions thrown from a `SchemaInterface` 
to optionally extend, which can simplify the process of catching exceptions.

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