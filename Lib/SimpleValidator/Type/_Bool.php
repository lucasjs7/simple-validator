<?php

namespace Lib\SimpleValidator\Type;

class _Bool extends Base {

	use tNew;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_BOOL) !== false);
	}

	public function attrsValidate(mixed $value): void {
		//
	}
}
