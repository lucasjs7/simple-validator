<?php

use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Struct;
use Tests\Base;
use Lucasjs7\SimpleValidator\Type\{_Bool, _Date, _Float, _Int, _Interface, _String};

$listTrue = [
    'Required#1' => [
        'test' => _Bool::new()->required(),
        'value' => false,
        'result' => true
    ],
    'Required#2' => [
        'test' => _Bool::new()->required(),
        'value' => true,
        'result' => true
    ],
    'Required#3' => [
        'test' => _Int::new()->required(),
        'value' => 0,
        'result' => true
    ],
    'Required#4' => [
        'test' => _Int::new()->required(),
        'value' => -1,
        'result' => true
    ],
    'Required#5' => [
        'test' => _Float::new()->required(),
        'value' => 0,
        'result' => true
    ],
    'Required#6' => [
        'test' => _Float::new()->required(),
        'value' => -0.1,
        'result' => true
    ],
    'Required#7' => [
        'test' => _Date::new()->required(),
        'value' => '01-01-0001',
        'result' => true
    ],
    'Required#8' => [
        'test' => _String::new()->required(),
        'value' => '.',
        'result' => true
    ],
    'Required#9' => [
        'test' => _Interface::new()->required(),
        'value' => false,
        'result' => true
    ],
    'Required#10' => [
        'test' => _Interface::new()->required(),
        'value' => [null],
        'result' => true
    ],
    'Required#11' => [
        'test' => Slice::new('type: string'),
        'value' => [],
        'result' => true
    ],
    'Required#12' => [
        'test' => Map::new('type: string', 'type: string'),
        'value' => [],
        'result' => true
    ],
    'Required#13' => [
        'test' => Struct::new(['name' => 'type: string']),
        'value' => [],
        'result' => true
    ],
    'Required#14' => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string')
        ]),
        'value' => [],
        'result' => true
    ],
    'Required#15' => [
        'test' => Struct::new([
            'name2' => Map::new('type: string', 'type: string')
        ]),
        'value' => [],
        'result' => true
    ],
    'Required#16' => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string'])
        ]),
        'value' => [],
        'result' => true
    ],
];

$listFalse = [
    'Required#201' => [
        'test' => _Bool::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#202' => [
        'test' => _Int::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#203' => [
        'test' => _Float::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#204' => [
        'test' => _Date::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#205' => [
        'test' => _Date::new()->required(),
        'value' => ' ',
        'result' => false
    ],
    'Required#206' => [
        'test' => _Date::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#207' => [
        'test' => _String::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#208' => [
        'test' => _String::new()->required(),
        'value' => ' ',
        'result' => false
    ],
    'Required#209' => [
        'test' => _String::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#210' => [
        'test' => _Interface::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#211' => [
        'test' => _Interface::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#212' => [
        'test' => _Interface::new()->required(),
        'value' => '   ',
        'result' => false
    ],
    'Required#213' => [
        'test' => _Interface::new()->required(),
        'value' => [],
        'result' => false
    ],
    'Required#214' => [
        'test' => Slice::new('type: string | required'),
        'value' => [],
        'result' => false
    ],
    'Required#215' => [
        'test' => Map::new('type: string', 'type: string | required'),
        'value' => [],
        'result' => false
    ],
    'Required#216' => [
        'test' => Struct::new(['name' => 'type: string | required']),
        'value' => [],
        'result' => false
    ],
    'Required#217' => [
        'test' => Struct::new([
            'name2' => Slice::new('type: string | required')
        ]),
        'value' => [],
        'result' => false
    ],
    'Required#218' => [
        'test' => Struct::new([
            'name2' => Map::new('type: string', 'type: string | required')
        ]),
        'value' => [],
        'result' => false
    ],
    'Required#219' => [
        'test' => Struct::new([
            'name2' => Struct::new(['name' => 'type: string | required'])
        ]),
        'value' => [],
        'result' => false
    ],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testSlice('Required/Slice#1', $listTrue, true);
Base::testSlice('Required/Slice#2', $listFalse, false);

Base::testMap('Required/Map#1', $listTrue, true);
Base::testMap('Required/Map#2', $listFalse, false);

Base::testStruct('Required/Struct#1', $listTrue, true);
Base::testStruct('Required/Struct#2', $listFalse, false);
