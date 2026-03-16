<?php

use Lucasjs7\SimpleValidator\Type\_Int;

describe('Int', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'max exactly 10'          => [_Int::new()->max(10), 10, true, true],
            'min exactly 10'          => [_Int::new()->min(10), 10, true, true],
            'unsigned zero'           => [_Int::new()->unsigned(), 0, true, true],
            'max 10 min 5 exactly 10' => [_Int::new()->max(10)->min(5), 10, true, true],
            'max 10 min 5 exactly 5'  => [_Int::new()->max(10)->min(5), 5, true, true],
            'max 10 unsigned zero'    => [_Int::new()->max(10)->unsigned(), 0, true, true],
            'max 10 unsigned 10'      => [_Int::new()->max(10)->unsigned(), 10, true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'max 10 overflow 11'       => [_Int::new()->max(10), 11, false, false],
            'min 10 underflow 9'       => [_Int::new()->min(10), 9, false, false],
            'unsigned negative'        => [_Int::new()->unsigned(), -1, false, false],
            'max 10 min 5 overflow 11' => [_Int::new()->max(10)->min(5), 11, false, false],
            'max 10 min 5 underflow 4' => [_Int::new()->max(10)->min(5), 4, false, false],
            'max 10 unsigned negative' => [_Int::new()->max(10)->unsigned(), -1, false, false],
            'max 10 unsigned 11'       => [_Int::new()->max(10)->unsigned(), 11, false, false],
            'bool true instead of int' => [_Int::new(), true, false, false],
            'empty string'             => [_Int::new(), '', false, false],
            'float instead of int'     => [_Int::new(), 1.2, false, false],
            'empty array'              => [_Int::new(), [], false, false],
            'closure'                  => [_Int::new(), function () {}, false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'null value' => [_Int::new(), null, true, false],
        ]);

});
