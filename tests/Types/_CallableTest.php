<?php

use Lucasjs7\SimpleValidator\Type\_Callable;
use Tests\Base;

function MyFunc(mixed $value) {
    return ($value === 'C');
}

class MyClassTest {
    public static function verify(mixed $value): bool {
        return ($value === 'A');
    }
}

$myClassTest = new MyClassTest;

$listTests = [
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, function ($value) {
            return ($value === 2);
        }),
        'value' => 2,
        'result' => true,
        'dataResult' => true,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, function ($value) {
            return ($value === 't');
        }),
        'value' => 't',
        'result' => true,
        'dataResult' => true,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, function ($value) {
            return ($value === 'a');
        }),
        'value' => 1,
        'result' => false,
        'dataResult' => false,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, function ($value) {
            return ($value === 'c');
        }),
        'value' => 'C',
        'result' => false,
        'dataResult' => false,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, '\MyFunc'),
        'value' => 'C',
        'result' => true,
        'dataResult' => true,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, [MyClassTest::class, 'verify']),
        'value' => 'A',
        'result' => true,
        'dataResult' => true,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, [MyClassTest::class, 'verify']),
        'value' => 'Z',
        'result' => false,
        'dataResult' => false,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, [$myClassTest, 'verify']),
        'value' => 'A',
        'result' => true,
        'dataResult' => true,
    ],
    '_Callable#' . __LINE__ => [
        'test' => _Callable::new(null, [$myClassTest, 'verify']),
        'value' => 'Z',
        'result' => false,
        'dataResult' => false,
    ],
];

Base::testTypeList($listTests);

Base::testSlice('_Callable/Slice#1', $listTests);

Base::testMap('_Callable/Map#1', $listTests);

Base::testStruct('_Callable/Struct#1', $listTests);
