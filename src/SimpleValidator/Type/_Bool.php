<?php

namespace Lucasjs7\SimpleValidator\Type;

class _Bool extends TypeBase {

	private static array $patterns;

	use tPattern, tRequired;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) !== null);
	}

	public function attrsValidate(mixed $value): void {
		//
	}
}
