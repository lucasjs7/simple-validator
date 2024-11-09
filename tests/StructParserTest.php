<?php

use Lucasjs7\SimpleValidator\StructParser;
use Tests\Base;
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

$listTests = [

    // StructParser::new
    'new#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test', 'birth' => '2019-10-10'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'a', 'birth' => '2019-10-10'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test', 'birth' => '2019-10-45'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['birth' => '2019-10-10'],
        'dataResult' => false,
    ],

    // StructParser::method
    'new#' . __LINE__ => [
        'test' => StructParser::method(row::class, 'define'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::method(row::class, 'define'),
        'value' => ['name' => 'a', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::method(row::class, 'define'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 99:00:00',  'updated' => 'asd'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::method(row::class, 'define'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 00:00:00'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::method(row::class, 'define'),
        'value' => ['updated' => '2019-10-10 00:00:00'],
        'dataResult' => false,
    ],

    // StructParser::function
    'new#' . __LINE__ => [
        'test' => StructParser::function('rowFunc'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::function('rowFunc'),
        'value' => ['name' => 'a', 'created' => '2019-10-10 00:00:00',  'updated' => '2019-10-10 00:00:00'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::function('rowFunc'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 99:00:00',  'updated' => '2019-10-10 00:00:00'],
        'dataResult' => false,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::function('rowFunc'),
        'value' => ['name' => 'test', 'created' => '2019-10-10 00:00:00'],
        'dataResult' => true,
    ],
    'new#' . __LINE__ => [
        'test' => StructParser::function('rowFunc'),
        'value' => ['updated' => '2019-10-10 00:00:00'],
        'dataResult' => false,
    ],
];

Base::testStruct('StructParser/Struct', $listTests);
Base::testSlice('StructParser/Slice', $listTests);
Base::testMap('StructParser/Map', $listTests);
