<?php

use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\{_Bool, _Date, _Float, _Int, _Interface, _String, TypeParser};

describe('Required', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'bool false'             => [_Bool::new()->required(), false, true, true],
            'bool true'              => [_Bool::new()->required(), true, true, true],
            'int 0'                  => [_Int::new()->required(), 0, true, true],
            'int negative'           => [_Int::new()->required(), -1, true, true],
            'float 0'                => [_Float::new()->required(), 0, true, true],
            'float negative'         => [_Float::new()->required(), -0.1, true, true],
            'date valid string'      => [_Date::new()->required(), '0001-01-01', true, true],
            'string valid'           => [_String::new()->required(), '.', true, true],
            'interface bool'         => [_Interface::new()->required(), false, true, true],
            'interface array'        => [_Interface::new()->required(), [null], true, true],
            'slice empty optional'   => [Slice::new('type: string'), [], true, true],
            'map empty optional'     => [Map::new('type: string', 'type: string'), [], true, true],
            'struct empty optional'  => [Struct::new(['name' => 'type: string']), [], true, true],
            'struct slice optional'  => [Struct::new(['name2' => Slice::new('type: string')]), [], true, true],
            'struct map optional'    => [Struct::new(['name2' => Map::new('type: string', 'type: string')]), [], true, true],
            'struct struct optional' => [Struct::new(['name2' => Struct::new(['name' => 'type: string'])]), [], true, true],
            'struct nested required' => [Struct::new(['name2' => Struct::new(['name' => 'type: string | required']), 'name3' => 'type: string']), ['name2' => ['name' => 'abc']], true, true],
            'struct map required'    => [Struct::new(['name2' => Map::new('type: string | required', 'type: string | required'), 'name3' => 'type: string']), ['name2' => ['sl' => 'abc']], true, true],
            'struct slice required'  => [Struct::new(['name2' => Slice::new('type: string | required'), 'name3' => 'type: string']), ['name2' => ['abc']], true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'bool null'                    => [_Bool::new()->required(), null, false, false],
            'int null'                     => [_Int::new()->required(), null, false, false],
            'float null'                   => [_Float::new()->required(), null, false, false],
            'date empty'                   => [_Date::new()->required(), '', false, false],
            'date space'                   => [_Date::new()->required(), ' ', false, false],
            'date null'                    => [_Date::new()->required(), null, false, false],
            'string null'                  => [_String::new()->required(), null, false, false],
            'slice empty required'         => [Slice::new('type: string | required'), [], false, false],
            'map empty required'           => [Map::new('type: string', 'type: string | required'), [], false, false],
            'struct field required'        => [Struct::new(['name' => 'type: string | required']), [], false, false],
            'struct slice required empty'  => [Struct::new(['name2' => Slice::new('type: string | required')]), [], false, false],
            'struct map required empty'    => [Struct::new(['name2' => Map::new('type: string', 'type: string | required')]), [], false, false],
            'struct struct required empty' => [Struct::new(['name2' => Struct::new(['name' => 'type: string | required'])]), [], false, false],
            'struct nested empty'          => [Struct::new(['name2' => Struct::new(['name' => 'type: string | required']), 'name3' => 'type: string']), [], false, false, false],
            'struct map empty'             => [Struct::new(['name2' => Map::new('type: string | required', 'type: string | required'), 'name3' => 'type: string']), [], false, false, false],
            'struct slice empty'           => [Struct::new(['name2' => Slice::new('type: string | required'), 'name3' => 'type: string']), [], false, false, false],
            'type parser int req'          => [TypeParser::new('type: int | required'), null, false, false],
            'type parser strict req'       => [TypeParser::new('type: int | required: true'), null, false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'string empty'          => [_String::new()->required(), '', false, true],
            'string spaces'         => [_String::new()->required(), ' ', false, true],
            'interface null'        => [_Interface::new()->required(), null, false, true],
            'interface empty'       => [_Interface::new()->required(), '', false, true],
            'interface spaces'      => [_Interface::new()->required(), '   ', false, true],
            'interface empty array' => [_Interface::new()->required(), [], false, true],
            'parser type int'       => [TypeParser::new('type: int'), null, true, false],
            'parser not required'   => [TypeParser::new('type: int | required: false'), null, true, false],
        ]);

});
