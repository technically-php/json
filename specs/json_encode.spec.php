<?php

use function Technically\Json\json_encode;

describe('json_encode', function () {
    $inputDatasets = [
        'null'         => null,
        'false'        => false,
        'true'         => true,
        'zero'         => 0,
        'negative'     => -1000,
        'PHP_INT_MAX'  => PHP_INT_MAX,
        'float'        => 24.5,
        'empty array'  => [],
        'empty object' => (object) [],
        'array'        => ['technically/json'],
        'assoc array'  => ['name' => 'technically/json', 'type' => 'library'],
        'object'       => (object) ['name' => 'technically/json', 'type' => 'library'],
        'nested'       => [
            'level 1' => [
                'level 2' => [
                    'level 3' => [1, 2, 3],
                ],
            ],
        ],
    ];

    $flagDatasets = [
        'JSON_FORCE_OBJECT'      => JSON_FORCE_OBJECT,
        'JSON_UNESCAPED_SLASHES' => JSON_UNESCAPED_SLASHES,
        'JSON_UNESCAPED_UNICODE' => JSON_UNESCAPED_UNICODE,
    ];

    foreach ($inputDatasets as $inputLabel => $input) {
        it("should encode JSON same as native json_encode() ($inputLabel)", function () use ($input) {
            assert(json_encode($input) === \json_encode($input));
        });
    }

    foreach ($flagDatasets as $flagsLabel => $flags) {
        foreach ($inputDatasets as $inputLabel => $input) {
            it("should support flags same as native json_encode() ($flagsLabel x $inputLabel)", function () use ($input, $flags) {
                assert(json_encode($input, $flags) === \json_encode($input, $flags));
            });
        }
    }

    it('should throw on max depth limit', function () use ($inputDatasets) {
        try {
            json_encode($inputDatasets['nested'], 0, $max_depth = 2);
        } catch (JsonException $exception) {
            // passthru
        }

        assert(isset($exception));
        assert($exception instanceof JsonException);
    });
});
