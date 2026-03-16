<?php

use Lucasjs7\SimpleValidator\Type\_Bool;

describe('Bool', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'true string'  => [_Bool::new(), 'true', true, true],
            'True string'  => [_Bool::new(), 'True', true, true],
            'TRUE string'  => [_Bool::new(), 'TRUE', true, true],
            'true bool'    => [_Bool::new(), true, true, true],
            '1 int'        => [_Bool::new(), 1, true, true],
            '1 string'     => [_Bool::new(), '1', true, true],
            'false string' => [_Bool::new(), 'false', true, true],
            'False string' => [_Bool::new(), 'False', true, true],
            'FALSE string' => [_Bool::new(), 'FALSE', true, true],
            'false bool'   => [_Bool::new(), false, true, true],
            '0 int'        => [_Bool::new(), 0, true, true],
            '0 string'     => [_Bool::new(), '0', true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            '2 string'     => [_Bool::new(), '2', false, false],
            '2 int'        => [_Bool::new(), 2, false, false],
            '-1 string'    => [_Bool::new(), '-1', false, false],
            '-1 int'       => [_Bool::new(), -1, false, false],
            't string'     => [_Bool::new(), 't', false, false],
            'T string'     => [_Bool::new(), 'T', false, false],
            'f string'     => [_Bool::new(), 'f', false, false],
            'F string'     => [_Bool::new(), 'F', false, false],
            'null'         => [_Bool::new()->required(), null, false, false],
            'empty string' => [_Bool::new(), '', false, false],
            '1.2 float'    => [_Bool::new(), 1.2, false, false],
            'empty array'  => [_Bool::new(), [], false, false],
            'callable'     => [_Bool::new(), function () {}, false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'null' => [_Bool::new(), null, true, false],
        ]);

});
