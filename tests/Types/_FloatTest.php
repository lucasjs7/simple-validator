<?php

use Lucasjs7\SimpleValidator\Type\_Float;

describe('Float', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'max exactly 10.3'           => [_Float::new()->max(10.3), 10.3, true, true],
            'min exactly 10.3'           => [_Float::new()->min(10.3), 10.3, true, true],
            'unsigned zero'              => [_Float::new()->unsigned(), 0, true, true],
            'max 10.3 min 5.8 match max' => [_Float::new()->max(10.3)->min(5.8), 10.3, true, true],
            'max 10.3 min 5.8 match min' => [_Float::new()->max(10.3)->min(5.8), 5.8, true, true],
            'max 10.3 unsigned zero'     => [_Float::new()->max(10.3)->unsigned(), 0, true, true],
            'max 10.3 unsigned 10.3'     => [_Float::new()->max(10.3)->unsigned(), 10.3, true, true],
            'int 1 value'                => [_Float::new(), 1, true, true],
            'float 1.2 value'            => [_Float::new(), 1.2, true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'max 10.3 overflow 10.4'     => [_Float::new()->max(10.3), 10.4, false, false],
            'min 10.3 underflow 10.2'    => [_Float::new()->min(10.3), 10.2, false, false],
            'unsigned negative'          => [_Float::new()->unsigned(), -0.1, false, false],
            'max 10.3 min 5.8 overflow'  => [_Float::new()->max(10.3)->min(5.8), 10.4, false, false],
            'max 10.3 min 5.8 underflow' => [_Float::new()->max(10.3)->min(5.8), 5.7, false, false],
            'max 10.3 unsigned negative' => [_Float::new()->max(10.3)->unsigned(), -0.1, false, false],
            'max 10.3 unsigned 10.4'     => [_Float::new()->max(10.3)->unsigned(), 10.4, false, false],
            'bool true'                  => [_Float::new(), true, false, false],
            'empty string'               => [_Float::new(), '', false, false],
            'empty array'                => [_Float::new(), [], false, false],
            'closure'                    => [_Float::new(), function () {}, false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'null value' => [_Float::new(), null, true, false],
        ]);

});
