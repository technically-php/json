<?php
declare(strict_types=1);

namespace Technically\Json;

use JsonException;

/**
 * @param mixed $value
 * @param int $flags
 * @param int $depth
 * @return string
 * @throws JsonException
 */
function json_encode($value, int $flags = 0, int $depth = 512): string {
    return \json_encode($value, $flags | JSON_THROW_ON_ERROR, $depth);
}

/**
 * @param string $json
 * @param bool $associative
 * @param int $depth
 * @param int $flags
 * @return mixed
 * @throws JsonException
 */
function json_decode(string $json, bool $associative = false, int $depth = 512, int $flags = 0) {
    return \json_decode($json, $associative, $depth, $flags | JSON_THROW_ON_ERROR);
}
