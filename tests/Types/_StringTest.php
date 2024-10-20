<?php

use Lucasjs7\SimpleValidator\Type\_String;
use Tests\Base;

$listTests = [
    '_String#' . __LINE__ => [
        'test' => _String::new()->options('a', 'b', 'c'),
        'value' => 'a',
        'result' => true,
        'dataResult' => true,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => 'abc',
        'result' => true,
        'dataResult' => true,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new()->max(3),
        'value' => '123',
        'result' => true,
        'dataResult' => true,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new()->min(3),
        'value' => '123',
        'result' => true,
        'dataResult' => true,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new()->options('a', 'b', 'c'),
        'value' => 'd',
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => 2,
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new()->max(3),
        'value' => '1234',
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new()->min(3),
        'value' => '12',
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => null,
        'result' => true,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => true,
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => '',
        'result' => true,
        'dataResult' => true,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => 1,
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => 1.2,
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    '_String#' . __LINE__ => [
        'test' => _String::new(),
        'value' => function () {
        },
        'result' => false,
        'dataResult' => false,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('_String/Slice', $listTests);

Base::testMap('_String/Map', $listTests);

Base::testStruct('_String/Struct', $listTests);
