<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\tFormat;

class _Date extends Base {

	use tFormat;

	public function validate(mixed $value, bool $exception = true): bool {
		if (!parent::validate($value, $exception)) {
			return false;
		}
		if (!$this->validateFormat($value)) {
			$this->setError('O atributo "format" é inválido.');
			return false;
		}

		return true;
	}
}
