<?php

use Lucasjs7\SimpleValidator\Type\_Callable;

function MyFunc(mixed $value) {
    return ($value === 'C');
}

class MyClassTest {
    public static function verify(mixed $value): bool {
        return ($value === 'A');
    }
}

$myClassTest = new MyClassTest;

describe('Callable', function () use($myClassTest) {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'anonymous function int'    => [_Callable::new(null, fn ($v) => ($v === 2)), 2, true, true],
            'anonymous function string' => [_Callable::new(null, fn ($v) => ($v === 't')), 't', true, true],
            'global function'           => [_Callable::new(null, '\MyFunc'), 'C', true, true],
            'static method'             => [_Callable::new(null, [MyClassTest::class, 'verify']), 'A', true, true],
            'instance method'           => [_Callable::new(null, [$myClassTest, 'verify']), 'A', true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'anonymous function int mismatch'         => [_Callable::new(null, fn ($v) => ($v === 'a')), 1, false, false],
            'anonymous function string case mismatch' => [_Callable::new(null, fn ($v) => ($v === 'c')), 'C', false, false],
            'static method mismatch'                  => [_Callable::new(null, [MyClassTest::class, 'verify']), 'Z', false, false],
            'instance method mismatch'                => [_Callable::new(null, [$myClassTest, 'verify']), 'Z', false, false],
        ]);

});
