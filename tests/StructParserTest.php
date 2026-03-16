<?php

use Lucasjs7\SimpleValidator\StructParser;
use Lucasjs7\SimpleValidator\Type\TypeParser;

class user {
    public function __construct(
        #[TypeParser('type: string | min: 3 | max: 8 | required')]
        public string $name = '',
        #[TypeParser('type: date | format: Y-m-d')]
        public string $birth = '',
    ) {
    }
}

class row {
    public function define(
        #[TypeParser('type: string | min: 3 | max: 8 | required')]
        string $name = '',
        #[TypeParser('type: date | format: Y-m-d H:i:s | required')]
        string $created = '',
        #[TypeParser('type: date | format: Y-m-d H:i:s')]
        string $updated = '',
    ) {
    }
}

function rowFunc(
    #[TypeParser('type: string | min: 3 | max: 8 | required')]
    string $name = '',
    #[TypeParser('type: date | format: Y-m-d H:i:s | required')]
    string $created = '',
    #[TypeParser('type: date | format: Y-m-d H:i:s')]
    string $updated = '',
) {
}

describe('StructParser::new', function () {

    it('True', validateStructures())
        ->with('structures')
        ->with([
            'valid user data' => [StructParser::new(user::class), ['name' => 'test', 'birth' => '2019-10-10'], true, true],
            'valid name only' => [StructParser::new(user::class), ['name' => 'test'], true, true],
        ]);

    it('False', validateStructures())
        ->with('structures')
        ->with([
            'short name'    => [StructParser::new(user::class), ['name' => 'a', 'birth' => '2019-10-10'], true, false],
            'invalid birth' => [StructParser::new(user::class), ['name' => 'test', 'birth' => '2019-10-45'], true, false],
            'missing name'  => [StructParser::new(user::class), ['birth' => '2019-10-10'], true, false],
        ]);

});

describe('StructParser::method', function () {

    it('True', validateStructures())
        ->with('structures')
        ->with([
            'full valid row data' => [StructParser::method(row::class, 'define'), ['name' => 'test', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'], true, true],
            'valid optional row'  => [StructParser::method(row::class, 'define'), ['name' => 'test', 'created' => '2019-10-10 00:00:00'], true, true],
        ]);

    it('False', validateStructures())
        ->with('structures')
        ->with([
            'short name row'   => [StructParser::method(row::class, 'define'), ['name' => 'a', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'], true, false],
            'invalid date row' => [StructParser::method(row::class, 'define'), ['name' => 'test', 'created' => '2019-10-10 99:00:00',  'updated' => 'asd'], true, false],
            'missing required' => [StructParser::method(row::class, 'define'), ['updated' => '2019-10-10 00:00:00'], true, false],
        ]);

});

describe('StructParser::function', function () {

    it('True', validateStructures())
        ->with('structures')
        ->with([
            'full valid func data' => [StructParser::function('rowFunc'), ['name' => 'test', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'], true, true],
            'valid optional func'  => [StructParser::function('rowFunc'), ['name' => 'test', 'created' => '2019-10-10 00:00:00'], true, true],
        ]);

    it('False', validateStructures())
        ->with('structures')
        ->with([
            'short name func'   => [StructParser::function('rowFunc'), ['name' => 'a', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'], true, false],
            'invalid date func' => [StructParser::function('rowFunc'), ['name' => 'test', 'created' => '2019-10-10 99:00:00',  'updated' => '2019-10-10 00:00:00'], true, false],
            'missing req func'  => [StructParser::function('rowFunc'), ['updated' => '2019-10-10 00:00:00'], true, false],
        ]);

});
