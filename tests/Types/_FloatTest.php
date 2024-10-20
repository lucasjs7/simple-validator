<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Float;

$listTests = [
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3),
		'value' => 10.3,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->min(10.3),
		'value' => 10.3,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->unsigned(),
		'value' => 0,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->min(5.8),
		'value' => 10.3,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->min(5.8),
		'value' => 5.8,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->unsigned(),
		'value' => 0,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->unsigned(),
		'value' => 10.3,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3),
		'value' => 10.4,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->min(10.3),
		'value' => 10.2,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->unsigned(),
		'value' => -0.1,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->min(5.8),
		'value' => 10.4,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->min(5.8),
		'value' => 5.7,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->unsigned(),
		'value' => -0.1,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new()->max(10.3)->unsigned(),
		'value' => 10.4,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => null,
		'result' => true,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => true,
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => '',
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => 1,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => 1.2,
		'result' => true,
		'dataResult' => true,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => [],
		'result' => false,
		'dataResult' => false,
	],
	'_Float#' . __LINE__ => [
		'test' => _Float::new(),
		'value' => function () {
		},
		'result' => false,
		'dataResult' => false,
	],
];

Base::testTypeList($listTests);

Base::testSlice('_Float/Slice#1', $listTests);

Base::testMap('_Float/Map#1', $listTests);

Base::testStruct('_Float/Struct#1', $listTests);
