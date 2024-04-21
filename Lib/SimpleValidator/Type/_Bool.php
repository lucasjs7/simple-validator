<?php

namespace Lib\SimpleValidator\Type;

class _Bool extends TypeBase {

	private static array $patterns;

	use tNew, tPattern, tRequired;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_BOOL) !== false);
	}

	public function attrsValidate(mixed $value): void {
		//
	}
}
