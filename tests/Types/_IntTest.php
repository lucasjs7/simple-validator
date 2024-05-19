<?php

use Tests\Base;
use Lucasjs7\SimpleValidator\Type\_Int;

$listTrue = [
	'_Int#1' => [
		'test' => _Int::new()->max(10), 'value' => 10, 'result' => true
	],
	'_Int#2' => [
		'test' => _Int::new()->min(10), 'value' => 10, 'result' => true
	],
	'_Int#3' => [
		'test' => _Int::new()->unsigned(), 'value' => 0, 'result' => true
	],
	'_Int#4' => [
		'test' => _Int::new()->max(10)->min(5), 'value' => 10, 'result' => true
	],
	'_Int#5' => [
		'test' => _Int::new()->max(10)->min(5), 'value' => 5, 'result' => true
	],
	'_Int#6' => [
		'test' => _Int::new()->max(10)->unsigned(), 'value' => 0, 'result' => true
	],
	'_Int#7' => [
		'test' => _Int::new()->max(10)->unsigned(), 'value' => 10, 'result' => true
	],
];

$listFalse = [
	'_Int#8' => [
		'test' => _Int::new()->max(10), 'value' => 11, 'result' => false
	],
	'_Int#9' => [
		'test' => _Int::new()->min(10), 'value' => 9, 'result' => false
	],
	'_Int#10' => [
		'test' => _Int::new()->unsigned(), 'value' => -1, 'result' => false
	],
	'_Int#11' => [
		'test' => _Int::new()->max(10)->min(5), 'value' => 11, 'result' => false
	],
	'_Int#12' => [
		'test' => _Int::new()->max(10)->min(5), 'value' => 4, 'result' => false
	],
	'_Int#13' => [
		'test' => _Int::new()->max(10)->unsigned(), 'value' => -1, 'result' => false
	],
	'_Int#14' => [
		'test' => _Int::new()->max(10)->unsigned(), 'value' => 11, 'result' => false
	],
];

Base::testTypeList($listTrue);
Base::testTypeList($listFalse);

Base::testSlice('_Int/Slice#1', $listTrue, true);
Base::testSlice('_Int/Slice#2', $listFalse, false);

Base::testMap('_Int/Map#1', $listTrue, true);
Base::testMap('_Int/Map#2', $listFalse, false);

Base::testStruct('_Int/Struct#1', $listTrue, true);
Base::testStruct('_Int/Struct#2', $listFalse, false);
