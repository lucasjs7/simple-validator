<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tMin, tMax};

class _Int extends Base {

	use tMin;
	use tMax;

	public function validate(mixed $value, bool $exception = true): bool {
		if (!parent::validate($value, $exception)) {
			return false;
		}
		if (!$this->validateMin($value)) {
			$this->setError('O atributo "min" é inválido.');
			return false;
		}
		if (!$this->validateMax($value)) {
			$this->setError('O atributo "max" é inválido.');
			return false;
		}

		return true;
	}
}
