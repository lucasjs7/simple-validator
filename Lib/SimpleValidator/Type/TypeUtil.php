<?php

namespace Lib\SimpleValidator\Type;

class TypeUtil {

	public static function String(): _String {
		return new _String;
	}

	public static function Int(): _Int {
		return new _Int();
	}

	public static function Float(): _Float {
		return new _Float();
	}

	public static function Date(): _Date {
		return new _Date();
	}

	public static function Bool(): _Bool {
		return new _Bool();
	}
}
