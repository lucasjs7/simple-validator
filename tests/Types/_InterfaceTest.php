<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Interface;

$listTrue = [
    '_Interface#1' => [
        'test' => _Interface::new(), 'value' => 'test un.', 'result' => true
    ],
    '_Interface#2' => [
        'test' => _Interface::new(), 'value' => 1, 'result' => true
    ],
    '_Interface#3' => [
        'test' => _Interface::new(), 'value' => -1, 'result' => true
    ],
    '_Interface#4' => [
        'test' => _Interface::new(), 'value' => 0, 'result' => true
    ],
    '_Interface#5' => [
        'test' => _Interface::new(), 'value' => 1.5, 'result' => true
    ],
    '_Interface#6' => [
        'test' => _Interface::new(), 'value' => -1.5, 'result' => true
    ],
    '_Interface#7' => [
        'test' => _Interface::new(), 'value' => true, 'result' => true
    ],
    '_Interface#8' => [
        'test' => _Interface::new(), 'value' => false, 'result' => true
    ],
    '_Interface#9' => [
        'test' => _Interface::new(), 'value' => 'true', 'result' => true
    ],
    '_Interface#10' => [
        'test' => _Interface::new(), 'value' => 'false', 'result' => true
    ],
    '_Interface#11' => [
        'test' => _Interface::new(), 'value' => [1, 2, 3], 'result' => true
    ],
    '_Interface#12' => [
        'test' => _Interface::new(), 'value' => ['a', 'b', 'c'], 'result' => true
    ],
    '_Interface#13' => [
        'test' => _Interface::new(), 'value' => ['key' => 1], 'result' => true
    ],
    '_Interface#14' => [
        'test' => _Interface::new(), 'value' => ['key' => 'a'], 'result' => true
    ],
    '_Interface#15' => [
        'test' => _Interface::new(), 'value' => ['key' => []], 'result' => true
    ],
    '_Interface#16' => [
        'test' => _Interface::new(), 'value' => new _Interface, 'result' => true
    ],
];

Base::testTypeList($listTrue);

Base::testSlice('_Interface/Slice#1', $listTrue, true);

Base::testMap('_Interface/Map#1', $listTrue, true);

Base::testStruct('_Interface/Struct#1', $listTrue, true);
