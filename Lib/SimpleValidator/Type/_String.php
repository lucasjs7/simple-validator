<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tOptions, tMin, tMax};

class _String extends Base {

	use tOptions, tMin, tMax;

	public function validate(mixed $value, bool $exception = true): bool {
		if (!parent::validate($value, $exception)) {
			return false;
		}
		if (!$this->validateOptions($value)) {
			$this->setError('O atributo "options" é inválido.');
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
