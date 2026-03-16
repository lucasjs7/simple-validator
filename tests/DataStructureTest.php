 <?php

use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\TypeParser;

describe('DataStruct', function () {

    it('True', validateStructures())
        ->with('structures')
        ->with([
            'empty list parser string' => [TypeParser::new('type: string'), [], false, true],
            'empty list parser int'    => [TypeParser::new('type: int'), [], false, true],
            'empty list parser float'  => [TypeParser::new('type: float'), [], false, true],
            'empty list parser bool'   => [TypeParser::new('type: bool'), [], false, true],
            'empty list parser date'   => [TypeParser::new('type: date'), [], false, true],
            'null interface value'     => [TypeParser::new('type: interface'), null, true, true],
            'empty list interface'     => [TypeParser::new('type: interface'), [], false, true],
            'empty string interface'   => [TypeParser::new('type: interface'), '', true, true],
        ]);

    it('False', validateStructures())
        ->with('structures')
        ->with([
            'string min null'            => [TypeParser::new('type: string | min: 1'), null, true, false],
            'string required empty list' => [TypeParser::new('type: string | required'), [], false, false],
            'string min empty string'    => [TypeParser::new('type: string | min: 1'), '', true, false],
            'int min null'               => [TypeParser::new('type: int | min: 1'), null, true, false],
            'int required empty list'    => [TypeParser::new('type: int | required'), [], false, false],
            'int min empty string'       => [TypeParser::new('type: int | min: 1'), '', true, false],
            'float min null'             => [TypeParser::new('type: float | min: 1'), null, true, false],
            'float required empty list'  => [TypeParser::new('type: float | required'), [], false, false],
            'float min empty string'     => [TypeParser::new('type: float | min: 1'), '', true, false],
            'bool null'                  => [TypeParser::new('type: bool'), null, true, false],
            'bool required empty list'   => [TypeParser::new('type: bool | required'), [], false, false],
            'bool empty string'          => [TypeParser::new('type: bool'), '', true, false],
            'date null'                  => [TypeParser::new('type: date'), null, true, false],
            'date required empty list'   => [TypeParser::new('type: date | required'), [], false, false],
            'date empty string'          => [TypeParser::new('type: date'), '', true, false],
            'interface required empty'   => [TypeParser::new('type: interface | required'), [], false, false],
            'struct required missing'    => [Struct::new(['B' => 'type: string | required']), [], false, false],
            'slice required empty'       => [Slice::new('type: string | required'), [], false, false],
            'map required empty'         => [Map::new('type: string', 'type: string | required'), [], false, false],
        ]);

});
