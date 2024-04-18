<?php

namespace Lib\SimpleValidator\Type;

class _Bool extends Base {

	private static array $patterns;

	use tNew, tPattern;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_BOOL) !== false);
	}

	public function attrsValidate(mixed $value): void {
		//
	}
}
