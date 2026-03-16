<?php

use Lucasjs7\SimpleValidator\{iDataStructure, Map, Slice, Struct};
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\iTypeBase;

/*
|--------------------------------------------------------------------------
| Datasets
|--------------------------------------------------------------------------
*/

dataset('structures', [
    'Slice'  => [validateSlice(...)],
    'Map'    => [validateMap(...)],
    'Struct' => [validateStruct(...)],
]);

dataset('struct-and-type', [
    'Type'   => [validateType(...), false],
    'Slice'  => [validateSlice(...), true],
    'Map'    => [validateMap(...), true],
    'Struct' => [validateStruct(...), true],
]);

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function validateStructures(): callable {
    return function(
        callable                 $executor,
        iTypeBase|iDataStructure $test,
        mixed                    $value,
        bool                     $adaptedValue,
        mixed                    $result,
    ): void {
        expect($executor($test, $value, $adaptedValue))->toBe($result);
    };
}

function validateStructAndType(): callable {
    return function(
        callable                 $executor,
        bool                     $isStructTest,
        iTypeBase|iDataStructure $test,
        mixed                    $value,
        mixed                    $typeResult,
        mixed                    $structResult,
    ): void {

        $expected = $isStructTest ? $structResult : $typeResult;

        expect($executor($test, $value, true))->toBe($expected);
    };
}

function validateType(
    iTypeBase|iDataStructure $type,
    mixed                    $value,
): bool {
    return $type->validate(
        value: $value,
        exception: false
    );
}

function validateSlice(
    iTypeBase|iDataStructure $type,
    mixed                    $value,
    bool                     $adaptedValue,
): bool {
    return Slice::new(
        typeValues: $type
    )->validate(
        value    : $adaptedValue ? [$value]: $value,
        exception: false
    );
}

function validateMap(
    iTypeBase|iDataStructure $type,
    mixed                    $value,
    bool                     $adaptedValue,
): bool {
    return Map::new(
        typeKeys  : _String::new(),
        typeValues: $type
    )->validate(
        value    : $adaptedValue ? ['name' => $value]: $value,
        exception: false
    );
}

function validateStruct(
    iTypeBase|iDataStructure $type,
    mixed                    $value,
    bool                     $adaptedValue,
): bool {
    return Struct::new(
        structure: ['A' => $type]
    )->validate(
        value    : $adaptedValue ? ['A' => $value]: $value,
        exception: false
    );
}

function genTmpFile(
    string $filePath,
): array {

    $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
    $fileName = 'file-'.random_int(1000000000, 9999999999).'.'.$ext;
    $tmpName  = sys_get_temp_dir().DIRECTORY_SEPARATOR.$fileName;

    copy($filePath, $tmpName);

    return [
        'name'      => $fileName,
        'full_path' => $tmpName,
        'type'      => mime_content_type($tmpName),
        'tmp_name'  => $tmpName,
        'error'     => 0,
        'size'      => filesize($filePath),
    ];
}