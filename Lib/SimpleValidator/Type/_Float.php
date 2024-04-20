<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tMin, tMax, tUnsigned};

class _Float extends Base {

	private static array $patterns;

	use tMin, tMax, tNew, tPattern, tUnsigned;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false);
	}

	public function attrsValidate(mixed $value): void {
		$this->validateUnsigned($value);
		$this->validateMin($value, 'float');
		$this->validateMax($value, 'float');
	}
}
