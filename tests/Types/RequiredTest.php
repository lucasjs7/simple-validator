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
];

$listFalse = [
    'Required#14' => [
        'test' => _Bool::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#15' => [
        'test' => _Int::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#16' => [
        'test' => _Float::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#17' => [
        'test' => _Date::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#18' => [
        'test' => _Date::new()->required(),
        'value' => ' ',
        'result' => false
    ],
    'Required#19' => [
        'test' => _Date::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#20' => [
        'test' => _String::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#21' => [
        'test' => _String::new()->required(),
        'value' => ' ',
        'result' => false
    ],
    'Required#22' => [
        'test' => _String::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#23' => [
        'test' => _Interface::new()->required(),
        'value' => null,
        'result' => false
    ],
    'Required#24' => [
        'test' => _Interface::new()->required(),
        'value' => '',
        'result' => false
    ],
    'Required#25' => [
        'test' => _Interface::new()->required(),
        'value' => '   ',
        'result' => false
    ],
    'Required#26' => [
        'test' => _Interface::new()->required(),
        'value' => [],
        'result' => false
    ],
    'Required#27' => [
        'test' => Slice::new('type: string | required'),
        'value' => [],
        'result' => false
    ],
    'Required#28' => [
        'test' => Map::new('type: string', 'type: string | required'),
        'value' => [],
        'result' => false
    ],
    'Required#29' => [
        'test' => Struct::new(['name' => 'type: string | required']),
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
