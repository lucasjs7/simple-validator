<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Interface;

$listTests = [
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 'test un.',
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 1,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => -1,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 0,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 1.5,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => -1.5,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => true,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => false,
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 'true',
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => 'false',
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => [1, 2, 3],
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => ['a', 'b', 'c'],
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => ['key' => 1],
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => ['key' => 'a'],
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => ['key' => []],
        'result' => true,
        'dataResult' => true,
    ],
    '_Interface#' . __LINE__ => [
        'test' => _Interface::new(),
        'value' => new _Interface,
        'result' => true,
        'dataResult' => true,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('_Interface/Slice', $listTests);

Base::testMap('_Interface/Map', $listTests);

Base::testStruct('_Interface/Struct', $listTests);
