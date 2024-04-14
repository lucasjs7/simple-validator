<?php

namespace Lib\SimpleValidator\Type;

class Type {

	static _String $string;

	public function __construct() {
		self::$string = new _String();
	}
}
