<?php

namespace Lib\SimpleValidator\Type;

use Error;
use Lib\SimpleValidator\Type\Attribute\{tOptions, tMin, tMax};

class _String extends Base {

	use tOptions, tMin, tMax, tNew;

	public function typeValidate(mixed $value): bool {
		return is_string($value);
	}

	public function attrsValidate(mixed $value): void {
		$this->validateOptions($value);
		$this->validateMin($value, 'string');
		$this->validateMax($value, 'string');
	}
}
