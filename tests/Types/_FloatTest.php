<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Float;

$listTrue = [
	'_Float#1 - T' => [
		'test' => _Float::new()->max(10.3), 'value' => 10.3, 'result' => true
	],
	'_Float#2 - T' => [
		'test' => _Float::new()->min(10.3), 'value' => 10.3, 'result' => true
	],
	'_Float#3 - T' => [
		'test' => _Float::new()->unsigned(), 'value' => 0, 'result' => true
	],
	'_Float#4 - T' => [
		'test' => _Float::new()->max(10.3)->min(5.8), 'value' => 10.3, 'result' => true
	],
	'_Float#5 - T' => [
		'test' => _Float::new()->max(10.3)->min(5.8), 'value' => 5.8, 'result' => true
	],
	'_Float#6 - T' => [
		'test' => _Float::new()->max(10.3)->unsigned(), 'value' => 0, 'result' => true
	],
	'_Float#7 - T' => [
		'test' => _Float::new()->max(10.3)->unsigned(), 'value' => 10.3, 'result' => true
	],
];

$listFalse = [
	'_Float#1 - F' => [
		'test' => _Float::new()->max(10.3), 'value' => 10.4, 'result' => false
	],
	'_Float#2 - F' => [
		'test' => _Float::new()->min(10.3), 'value' => 10.2, 'result' => false
	],
	'_Float#3 - F' => [
		'test' => _Float::new()->unsigned(), 'value' => -0.1, 'result' => false
	],
	'_Float#4 - F' => [
		'test' => _Float::new()->max(10.3)->min(5.8), 'value' => 10.4, 'result' => false
	],
	'_Float#5 - F' => [
		'test' => _Float::new()->max(10.3)->min(5.8), 'value' => 5.7, 'result' => false
	],
	'_Float#6 - F' => [
		'test' => _Float::new()->max(10.3)->unsigned(), 'value' => -0.1, 'result' => false
	],
	'_Float#7 - F' => [
		'test' => _Float::new()->max(10.3)->unsigned(), 'value' => 10.4, 'result' => false
	],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testMap('_Float/Map#1', $listTrue, true);
Base::testMap('_Float/Map#2', $listFalse, false);

Base::testStruct('_Float/Struct#1', $listTrue, true);
Base::testStruct('_Float/Struct#2', $listFalse, false);
