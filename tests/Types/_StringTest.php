<?php

use Lucasjs7\SimpleValidator\Type\_String;
use Tests\Base;

$listTrue = [
    '_String#1' => [
        'test' => _String::new()->options('a', 'b', 'c'),
        'value' => 'a',
        'result' => true
    ],
    '_String#2' => [
        'test' => _String::new(),
        'value' => 'abc',
        'result' => true
    ],
    '_String#3' => [
        'test' => _String::new()->max(3),
        'value' => '123',
        'result' => true
    ],
    '_String#4' => [
        'test' => _String::new()->min(3),
        'value' => '123',
        'result' => true
    ],
];

$listFalse = [
    '_String#5' => [
        'test' => _String::new()->options('a', 'b', 'c'),
        'value' => 'd',
        'result' => false
    ],
    '_String#6' => [
        'test' => _String::new(),
        'value' => 2,
        'result' => false
    ],
    '_String#7' => [
        'test' => _String::new()->max(3),
        'value' => '1234',
        'result' => false
    ],
    '_String#8' => [
        'test' => _String::new()->min(3),
        'value' => '12',
        'result' => false
    ],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testSlice('_String/Slice#1', $listTrue, true);
Base::testSlice('_String/Slice#2', $listFalse, false);

Base::testMap('_String/Map#1', $listTrue, true);
Base::testMap('_String/Map#2', $listFalse, false);

Base::testStruct('_String/Struct#1', $listTrue, true);
Base::testStruct('_String/Struct#2', $listFalse, false);
