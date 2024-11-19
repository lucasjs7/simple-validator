<?php

use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Struct;
use Tests\Base;
use Lucasjs7\SimpleValidator\Type\{_Bool, _Date, _Float, _Int, _Interface, _String, TypeParser};

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
        'value' => '0001-01-01',
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
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string | required']),
            'name3' => 'type: string',
        ]),
        'value' => ['name2' => ['name' => 'abc']],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Map::new('type: string | required', 'type: string | required'),
            'name3' => 'type: string',
        ]),
        'value' => ['name2' => ['sl' => 'abc']],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string | required'),
            'name3' => 'type: string',
        ]),
        'value' => ['name2' => ['abc']],
        'result' => true,
        'dataResult' => true,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string | required']),
            'name3' => 'type: string',
        ]),
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Map::new('type: string | required', 'type: string | required'),
            'name3' => 'type: string',
        ]),
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string | required'),
            'name3' => 'type: string',
        ]),
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => TypeParser::new('type: int'),
        'value' => null,
        'result' => true,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => TypeParser::new('type: int | required'),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => TypeParser::new('type: int | required: true'),
        'value' => null,
        'result' => false,
        'dataResult' => false,
    ],
    'Required#' . __LINE__ => [
        'test' => TypeParser::new('type: int | required: false'),
        'value' => null,
        'result' => true,
        'dataResult' => false,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('Required/Slice', $listTests);

Base::testMap('Required/Map', $listTests);

Base::testStruct('Required/Struct', $listTests);
