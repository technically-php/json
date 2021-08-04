# Technically JSON

`Technically\Json` is a minimalistic wrapper around PHP native `json_encode` and `json_decode` functions,
which always throws an exception in case of an error. 

![Tests Status][badge]

## Features

- PHP 7.3+
- PHP 8.0
- Semver
- Tests

## Problem

Look, if an error occurs with `json_decode()`, by default, it sets the global error state
that can be retrieved with `json_last_error()` and `json_last_error_msg()`. 
Alternatively, developers can use `JSON_THROW_ON_ERROR` option to make `json_decode()` throw
an exception in case of invalid input.

Proper way of using the native `json_decode()` function, though many developers forget about it:

```php
try {
    $data = json_decode($input, false, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $exception) {
    // handle invalid input
}
```

Or this:

```php
$data = \json_decode($input);
$error = \json_last_error();

if ($error !== JSON_ERROR_NONE) {
    throw new \JsonException(\json_last_error_msg(), $error);
}
```

I believe it should be the default behavior of `json_decode()` and `json_encode()` to throw on errors. 
We don't have to remember about it.

## Solution

```php
use function Technically\Json\json_decode;

try {
    $data = json_decode($input);
} catch (JsonException $exception) {
    // handle invalid input
}
```

## Installation

Use [Composer][getcomposer] package manager to add the library to your project:

```
composer require technically/json
```


## Usage

The namespaced `json_encode()` and `json_decode()` functions do always add `JSON_THROW_ON_ERROR` flag,
but in the rest they work identically to the native functions: same arguments, same options, same result. 

```php
<?php

use JsonException;
use function Technically\Json\json_decode;
use function Technically\Json\json_encode;

// encode
echo json_encode(['name' => 'technically/json', 'type' => 'library']);

// decode with safety check exception to protected
try {
    $data = json_decode('[{ invalid JSON');
} catch (JsonException $exception) {
    // handle invalid data
}
```


## Changelog

All notable changes to this project will be documented in the [CHANGELOG](./CHANGELOG.md) file.


## Credits

- Implemented by [Ivan Voskoboinyk][author]


[getcomposer]: https://getcomposer.org/
[author]: https://github.com/e1himself?utm_source=web&utm_medium=github&utm_campaign=technically/json
[badge]: https://github.com/technically-php/json/actions/workflows/test.yml/badge.svg
