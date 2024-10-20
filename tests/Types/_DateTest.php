<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Date;

$listTests = [
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('d/m/Y'),
		'value' => '01/01/0001',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('y-m-d'),
		'value' => '01-01-01',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H'),
		'value' => '1',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('Y-m-d H:i:s'),
		'value' => '2014-02-28 12:12:12',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('Y-m-d'),
		'value' => '2015-06-26',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('d/m/Y'),
		'value' => '28/02/2014',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H:i'),
		'value' => '14:50',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H'),
		'value' => '14',
		'result' => true,
		'dataResult' => true,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H'),
		'value' => 14,
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('y-m-d'),
		'value' => '1-1-1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('d/m/Y'),
		'value' => '1/1/1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('d/m/Y'),
		'value' => '1-1-1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('y-m-d'),
		'value' => '1/1/1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('y-m-d'),
		'value' => 'a1-a1-a1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H'),
		'value' => '-1',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('Y-m-d H:i:s'),
		'value' => '2014-02-30 12:12:12',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('Y-m-d'),
		'value' => '2015/06/26',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('d/m/Y'),
		'value' => '30/02/2014',
		'result' => false,
		'dataResult' => false,
	],
	'_Date#' . __LINE__ => [
		'test' => _Date::new()->format('H:i'),
		'value' => '14:77',
		'result' => false,
		'dataResult' => false,
	],
];

Base::testTypeList($listTests);

Base::testSlice('_Date/Slice#1', $listTests);

Base::testMap('_Date/Map#1', $listTests);

Base::testStruct('_Date/Struct#1', $listTests);
