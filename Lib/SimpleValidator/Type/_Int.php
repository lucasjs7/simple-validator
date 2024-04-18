<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tMin, tMax};

class _Int extends Base {

	use tMin, tMax, tNew;

	public function typeValidate(mixed $value): bool {
		return (filter_var($value, FILTER_VALIDATE_INT) !== false);
	}

	public function attrsValidate(mixed $value): void {
		if (!self::isEmpty($value) && filter_var($value, FILTER_VALIDATE_INT) === false) {
			throw new Error();
		}

		$this->validateMin($value, 'int');
		$this->validateMax($value, 'int');
	}
}
