<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\TypeParser;

$listTests = [
    'String#' . __LINE__ => [
        'test' => TypeParser::new('type: string | min: 1'),
        'value' => null,
        'dataResult' => false,
    ],
    'String#' . __LINE__ => [
        'test' => TypeParser::new('type: string'),
        'dataResult' => true,
    ],
    'String#' . __LINE__ => [
        'test' => TypeParser::new('type: string | required'),
        'dataResult' => false,
    ],
    'String#' . __LINE__ => [
        'test' => TypeParser::new('type: string | min: 1'),
        'value' => '',
        'dataResult' => false,
    ],
    'Int#' . __LINE__ => [
        'test' => TypeParser::new('type: int | min: 1'),
        'value' => null,
        'dataResult' => false,
    ],
    'Int#' . __LINE__ => [
        'test' => TypeParser::new('type: int'),
        'dataResult' => true,
    ],
    'Int#' . __LINE__ => [
        'test' => TypeParser::new('type: int | required'),
        'dataResult' => false,
    ],
    'Int#' . __LINE__ => [
        'test' => TypeParser::new('type: int | min: 1'),
        'value' => '',
        'dataResult' => false,
    ],
    'Float#' . __LINE__ => [
        'test' => TypeParser::new('type: float | min: 1'),
        'value' => null,
        'dataResult' => false,
    ],
    'Float#' . __LINE__ => [
        'test' => TypeParser::new('type: float'),
        'dataResult' => true,
    ],
    'Float#' . __LINE__ => [
        'test' => TypeParser::new('type: float | required'),
        'dataResult' => false,
    ],
    'Float#' . __LINE__ => [
        'test' => TypeParser::new('type: float | min: 1'),
        'value' => '',
        'dataResult' => false,
    ],
    'Bool#' . __LINE__ => [
        'test' => TypeParser::new('type: bool'),
        'value' => null,
        'dataResult' => false,
    ],
    'Bool#' . __LINE__ => [
        'test' => TypeParser::new('type: bool'),
        'dataResult' => true,
    ],
    'Bool#' . __LINE__ => [
        'test' => TypeParser::new('type: bool | required'),
        'dataResult' => false,
    ],
    'Bool#' . __LINE__ => [
        'test' => TypeParser::new('type: bool'),
        'value' => '',
        'dataResult' => false,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: date'),
        'value' => null,
        'dataResult' => false,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: date'),
        'dataResult' => true,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: date | required'),
        'dataResult' => false,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: date'),
        'value' => '',
        'dataResult' => false,
    ],
    'Interface#' . __LINE__ => [
        'test' => TypeParser::new('type: interface'),
        'value' => null,
        'dataResult' => true,
    ],
    'Interface#' . __LINE__ => [
        'test' => TypeParser::new('type: interface'),
        'dataResult' => true,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: interface | required'),
        'dataResult' => false,
    ],
    'Date#' . __LINE__ => [
        'test' => TypeParser::new('type: interface'),
        'value' => '',
        'dataResult' => true,
    ],
];

Base::testStruct('DataStruct/Struct', $listTests);
Base::testSlice('DataStruct/Slice', $listTests);
Base::testMap('DataStruct/Map', $listTests);
