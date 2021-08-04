<?php

use function Technically\Json\json_decode;

describe('json_decode', function () {
    $inputDatasets = [
        'null'         => 'null',
        'false'        => 'false',
        'true'         => 'true',
        'zero'         => '0',
        'negative'     => '-1000',
        'PHP_INT_MAX'  => '9223372036854775807',
        'float'        => '24.5',
        'empty array'  => '[]',
        'empty object' => '{}',
        'array'        => '["technically/json"]',
        'object'       => '{"name":"technically/json","type":"library"}',
        'nested'       => '{"level 1":{"level 2":{"level 3":[1,2,3]}}}',
    ];

    $flagDatasets = [
        'JSON_FORCE_OBJECT'      => JSON_FORCE_OBJECT,
        'JSON_UNESCAPED_SLASHES' => JSON_UNESCAPED_SLASHES,
        'JSON_UNESCAPED_UNICODE' => JSON_UNESCAPED_UNICODE,
    ];

    foreach ($inputDatasets as $inputLabel => $input) {
        it("should decode JSON same as native json_decode() ($inputLabel)", function () use ($input) {
            assert(json_decode($input) == \json_decode($input));
        });
    }

    foreach ($flagDatasets as $flagsLabel => $flags) {
        foreach ($inputDatasets as $inputLabel => $input) {
            it("should support flags same as native json_decode() ($flagsLabel x $inputLabel)", function () use ($input, $flags) {
                assert(json_decode($input, $flags) == \json_decode($input, $flags));
            });
        }
    }

    it('should throw on max depth limit', function () use ($inputDatasets) {
        try {
            json_decode($inputDatasets['nested'], 0, $depth = 2);
        } catch (JsonException $exception) {
            // passthru
        }

        assert(isset($exception));
        assert($exception instanceof JsonException);
    });

    it('should throw on malformed JSON', function () use ($inputDatasets) {
        try {
            json_decode('{[');
        } catch (JsonException $exception) {
            // passthru
        }

        assert(isset($exception));
        assert($exception instanceof JsonException);
    });
});
