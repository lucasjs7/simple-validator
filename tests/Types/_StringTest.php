<?php

use Lucasjs7\SimpleValidator\Type\_String;

describe('String', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'options match'    => [_String::new()->options('a', 'b', 'c'), 'a', true, true],
            'simple string'    => [_String::new(), 'abc', true, true],
            'max length match' => [_String::new()->max(3), '123', true, true],
            'min length match' => [_String::new()->min(3), '123', true, true],
            'empty string'     => [_String::new(), '', true, true],
            'regex match'      => [_String::new()->regex('/[A-Z]/'), 'A', true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'options mismatch'      => [_String::new()->options('a', 'b', 'c'), 'd', false, false],
            'int 2 value'           => [_String::new(), 2, false, false],
            'max length overflow'   => [_String::new()->max(3), '1234', false, false],
            'min length underflow'  => [_String::new()->min(3), '12', false, false],
            'bool true'             => [_String::new(), true, false, false],
            'int 1 value'           => [_String::new(), 1, false, false],
            'float value'           => [_String::new(), 1.2, false, false],
            'empty array'           => [_String::new(), [], false, false],
            'closure'               => [_String::new(), function () {}, false, false],
            'regex no match'        => [_String::new()->regex('/[0-9]/'), 'Abc', false, false],
            'invalid regex pattern' => [_String::new()->regex('invalid_regex'), '1', false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'null value' => [_String::new(), null, true, false],
        ]);

});
