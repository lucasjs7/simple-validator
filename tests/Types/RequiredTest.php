<?php

use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Struct;
use Tests\Base;
use Lucasjs7\SimpleValidator\Type\{_Bool, _Date, _Float, _Int, _Interface, _String};

$listTests = [
    'Required#' . __LINE__ => [
        'test' => _Bool::new()->required(),
        'value' => false,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Bool::new()->required(),
        'value' => true,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Int::new()->required(),
        'value' => 0,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Int::new()->required(),
        'value' => -1,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Float::new()->required(),
        'value' => 0,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Float::new()->required(),
        'value' => -0.1,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Date::new()->required(),
        'value' => '01-01-0001',
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _String::new()->required(),
        'value' => '.',
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => false,
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => [null],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Slice::new('type: string'),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Map::new('type: string', 'type: string'),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new(['name' => 'type: string']),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string')
        ]),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Map::new('type: string', 'type: string')
        ]),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string'])
        ]),
        'value' => [],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Bool::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Int::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Float::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Date::new()->required(),
        'value' => '',
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Date::new()->required(),
        'value' => ' ',
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Date::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _String::new()->required(),
        'value' => '',
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _String::new()->required(),
        'value' => ' ',
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _String::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => null,
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => '',
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => '   ',
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => _Interface::new()->required(),
        'value' => [],
        'result' => false,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Slice::new('type: string | required'),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Map::new('type: string', 'type: string | required'),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new(['name' => 'type: string | required']),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string | required')
        ]),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Map::new('type: string', 'type: string | required')
        ]),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string | required'])
        ]),
        'value' => [],
        'result' => false,
        'dataResult' => false,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('Required/Slice', $listTests);

Base::testMap('Required/Map', $listTests);

Base::testStruct('Required/Struct', $listTests);
