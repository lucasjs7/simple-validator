<?php

use Lucasjs7\SimpleValidator\Type\_Bool;
use Tests\Base;

$listTests = [
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'true',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'True',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'TRUE',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => true,
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 1,
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => '1',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'false',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'False',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'FALSE',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => false,
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 0,
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => '0',
        'result' => true,
        'dataResult' => true,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => '2',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 2,
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => '-1',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => -1,
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 't',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'T',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'f',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 'F',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => null,
        'result' => true,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => '',
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => 1.2,
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    '_Bool#' . __LINE__ => [
        'test' => _Bool::new(),
        'value' => function () {
        },
        'result' => false,
        'dataResult' => false,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('_Bool/Slice#1', $listTests);

Base::testMap('_Bool/Map#1', $listTests);

Base::testStruct('_Bool/Struct#1', $listTests);
