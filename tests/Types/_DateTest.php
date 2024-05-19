<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Date;

$listTrue = [
	'_Date#1' => [
		'test' => _Date::new()->format('d/m/Y'), 'value' => '1/1/1', 'result' => true
	],
	'_Date#2' => [
		'test' => _Date::new()->format('F'), 'value' => 'January', 'result' => true
	],
	'_Date#3' => [
		'test' => _Date::new()->format('y-m-d'), 'value' => '1-1-1', 'result' => true
	],
];

$listFalse = [
	'_Date#4' => [
		'test' => _Date::new()->format('d/m/Y'), 'value' => '1-1-1', 'result' => false
	],
	'_Date#6' => [
		'test' => _Date::new()->format('F'), 'value' => 'te', 'result' => false
	],
	'_Date#7' => [
		'test' => _Date::new()->format('y-m-d'), 'value' => '1/1/1', 'result' => false
	],
	'_Date#8' => [
		'test' => _Date::new()->format('y-m-d'), 'value' => 'a1-a1-a1', 'result' => false
	],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testSlice('_Date/Slice#1', $listTrue, true);
Base::testSlice('_Date/Slice#2', $listFalse, false);

Base::testMap('_Date/Map#1', $listTrue, true);
Base::testMap('_Date/Map#2', $listFalse, false);

Base::testStruct('_Date/Struct#1', $listTrue, true);
Base::testStruct('_Date/Struct#2', $listFalse, false);
