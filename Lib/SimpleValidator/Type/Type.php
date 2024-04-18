<?php

namespace Lib\SimpleValidator\Type;

class Type {

	public static function String(): _String {
		return new _String;
	}

	public static function Int(): _Int {
		return new _Int();
	}

	public static function Date(): _Date {
		return new _Date();
	}

}
