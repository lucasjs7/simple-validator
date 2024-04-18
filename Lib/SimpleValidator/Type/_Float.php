<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tMin, tMax};

class _Float extends Base {

	use tMin, tMax, tNew;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false);
	}

	public function attrsValidate(mixed $value): void {
		$this->validateMin($value, 'float');
		$this->validateMax($value, 'float');
	}
}
