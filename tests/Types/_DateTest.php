<?php

use Lucasjs7\SimpleValidator\Type\_Date;

describe('Date', function () {

    it('True', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'short date DMY'      => [_Date::new()->format('d/m/Y'), '01/01/0001', true, true],
            'short date YMD'      => [_Date::new()->format('y-m-d'), '01-01-01', true, true],
            'hour only'           => [_Date::new()->format('H'), '1', true, true],
            'full datetime'       => [_Date::new()->format('Y-m-d H:i:s'), '2014-02-28 12:12:12', true, true],
            'standard date YMD'   => [_Date::new()->format('Y-m-d'), '2015-06-26', true, true],
            'standard date DMY'   => [_Date::new()->format('d/m/Y'), '28/02/2014', true, true],
            'hour and minute'     => [_Date::new()->format('H:i'), '14:50', true, true],
            'two digit hour'      => [_Date::new()->format('H'), '14', true, true],
        ]);

    it('False', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'integer instead of string' => [_Date::new()->format('H'), 14, false, false],
            'invalid short year'        => [_Date::new()->format('y-m-d'), '1-1-1', false, false],
            'invalid DMY format'        => [_Date::new()->format('d/m/Y'), '1/1/1', false, false],
            'invalid separator DMY'     => [_Date::new()->format('d/m/Y'), '1-1-1', false, false],
            'invalid separator YMD'     => [_Date::new()->format('y-m-d'), '1/1/1', false, false],
            'letters in date'           => [_Date::new()->format('y-m-d'), 'a1-a1-a1', false, false],
            'negative hour'             => [_Date::new()->format('H'), '-1', false, false],
            'invalid leap day'          => [_Date::new()->format('Y-m-d H:i:s'), '2014-02-30 12:12:12', false, false],
            'wrong separator slash'     => [_Date::new()->format('Y-m-d'), '2015/06/26', false, false],
            'invalid day for month'     => [_Date::new()->format('d/m/Y'), '30/02/2014', false, false],
            'invalid minute'            => [_Date::new()->format('H:i'), '14:77', false, false],
            'boolean true'              => [_Date::new(), true, false, false],
            'empty string'              => [_Date::new(), '', false, false],
            'integer 1'                 => [_Date::new(), 1, false, false],
            'float 1.2'                 => [_Date::new(), 1.2, false, false],
            'empty array'               => [_Date::new(), [], false, false],
            'callable'                  => [_Date::new(), function () {}, false, false],
        ]);

    it('Mixed', validateStructAndType())
        ->with('struct-and-type')
        ->with([
            'null' => [_Date::new(), null, true, false],
        ]);

});

