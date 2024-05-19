<?php

use Lucasjs7\SimpleValidator\Type\_Bool;
use Tests\Base;

$listTrue = [
    '_Bool#1' => [
        'test' => _Bool::new(), 'value' => 'true', 'result' => true
    ],
    '_Bool#2' => [
        'test' => _Bool::new(), 'value' => 'True', 'result' => true
    ],
    '_Bool#3' => [
        'test' => _Bool::new(), 'value' => 'TRUE', 'result' => true
    ],
    '_Bool#4' => [
        'test' => _Bool::new(), 'value' => true, 'result' => true
    ],
    '_Bool#5' => [
        'test' => _Bool::new(), 'value' => 1, 'result' => true
    ],
    '_Bool#6' => [
        'test' => _Bool::new(), 'value' => '1', 'result' => true
    ],
    '_Bool#7' => [
        'test' => _Bool::new(), 'value' => 'false', 'result' => true
    ],
    '_Bool#8' => [
        'test' => _Bool::new(), 'value' => 'False', 'result' => true
    ],
    '_Bool#9' => [
        'test' => _Bool::new(), 'value' => 'FALSE', 'result' => true
    ],
    '_Bool#10' => [
        'test' => _Bool::new(), 'value' => false, 'result' => true
    ],
    '_Bool#11' => [
        'test' => _Bool::new(), 'value' => 0, 'result' => true
    ],
    '_Bool#12' => [
        'test' => _Bool::new(), 'value' => '0', 'result' => true
    ],
];

$listFalse = [
    '_Bool#13' => [
        'test' => _Bool::new(), 'value' => '2', 'result' => false
    ],
    '_Bool#14' => [
        'test' => _Bool::new(), 'value' => 2, 'result' => false
    ],
    '_Bool#15' => [
        'test' => _Bool::new(), 'value' => '-1', 'result' => false
    ],
    '_Bool#16' => [
        'test' => _Bool::new(), 'value' => -1, 'result' => false
    ],
    '_Bool#17' => [
        'test' => _Bool::new(), 'value' => 't', 'result' => false
    ],
    '_Bool#18' => [
        'test' => _Bool::new(), 'value' => 'T', 'result' => false
    ],
    '_Bool#19' => [
        'test' => _Bool::new(), 'value' => 'f', 'result' => false
    ],
    '_Bool#20' => [
        'test' => _Bool::new(), 'value' => 'F', 'result' => false
    ],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testSlice('_Bool/Slice#1', $listTrue, true);
Base::testSlice('_Bool/Slice#2', $listFalse, false);

Base::testMap('_Bool/Map#1', $listTrue, true);
Base::testMap('_Bool/Map#2', $listFalse, false);

Base::testStruct('_Bool/Struct#1', $listTrue, true);
Base::testStruct('_Bool/Struct#2', $listFalse, false);
