<?php

namespace Lib\SimpleValidator\Type;

use Error;
use Lib\SimpleValidator\Type\Attribute\{tMin, tMax};

class _Int extends Base {

	private static array $patterns;

	use tMin, tMax, tNew, tPattern;

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
