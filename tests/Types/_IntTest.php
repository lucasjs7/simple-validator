<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Int;

$listTests = [
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10),
		'value' => 10,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->min(10),
		'value' => 10,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->unsigned(),
		'value' => 0,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->min(5),
		'value' => 10,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->min(5),
		'value' => 5,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->unsigned(),
		'value' => 0,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->unsigned(),
		'value' => 10,
		'result' => true,
		'dataResult' => true,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10),
		'value' => 11,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->min(10),
		'value' => 9,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->unsigned(),
		'value' => -1,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->min(5),
		'value' => 11,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->min(5),
		'value' => 4,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->unsigned(),
		'value' => -1,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new()->max(10)->unsigned(),
		'value' => 11,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => null,
		'result' => true,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => true,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => '',
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => 1.2,
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => [],
		'result' => false,
		'dataResult' => false,
	],
	'_Int#' . __LINE__ => [
		'test' => _Int::new(),
		'value' => function () {
		},
		'result' => false,
		'dataResult' => false,
	],
];

Base::testTypeList($listTests);

Base::testSlice('_Int/Slice', $listTests);

Base::testMap('_Int/Map', $listTests);

Base::testStruct('_Int/Struct', $listTests);
