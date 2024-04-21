<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tOptions, tMin, tMax, tRegex};

class _String extends TypeBase {

	private static array $patterns;

	use tOptions, tMin, tMax, tNew, tPattern, tRequired, tRegex;

	public function typeValidate(mixed $value): bool {
		return is_string($value);
	}

	public function attrsValidate(mixed $value): void {
		$this->validateOptions($value);
		$this->validateMin($value, 'string');
		$this->validateMax($value, 'string');
		$this->validateRegex($value);
	}
}
