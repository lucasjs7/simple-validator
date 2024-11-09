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

$listTests = [
    'String#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test', 'birth' => '2019-10-10'],
        'dataResult' => true,
    ],
    'String#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'a', 'birth' => '2019-10-10'],
        'dataResult' => false,
    ],
    'String#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test', 'birth' => '2019-10-45'],
        'dataResult' => false,
    ],
    'String#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['name' => 'test'],
        'dataResult' => true,
    ],
    'String#' . __LINE__ => [
        'test' => StructParser::new(user::class),
        'value' => ['birth' => '2019-10-10'],
        'dataResult' => false,
    ],
];

Base::testStruct('StructParser/Struct', $listTests);
Base::testSlice('StructParser/Slice', $listTests);
Base::testMap('StructParser/Map', $listTests);
