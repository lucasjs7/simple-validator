<?php

use Lucasjs7\SimpleValidator\Type\_Interface;

describe('Interface', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'string'             => [_Interface::new(), 'test un.', true, true],
            'int positive'       => [_Interface::new(), 1, true, true],
            'int negative'       => [_Interface::new(), -1, true, true],
            'int zero'           => [_Interface::new(), 0, true, true],
            'float positive'     => [_Interface::new(), 1.5, true, true],
            'float negative'     => [_Interface::new(), -1.5, true, true],
            'bool true'          => [_Interface::new(), true, true, true],
            'bool false'         => [_Interface::new(), false, true, true],
            'string true'        => [_Interface::new(), 'true', true, true],
            'string false'       => [_Interface::new(), 'false', true, true],
            'array list int'     => [_Interface::new(), [1, 2, 3], true, true],
            'array list string'  => [_Interface::new(), ['a', 'b', 'c'], true, true],
            'array assoc int'    => [_Interface::new(), ['key' => 1], true, true],
            'array assoc string' => [_Interface::new(), ['key' => 'a'], true, true],
            'array assoc empty'  => [_Interface::new(), ['key' => []], true, true],
            'object instance'    => [_Interface::new(), new _Interface, true, true],
        ]);

});
