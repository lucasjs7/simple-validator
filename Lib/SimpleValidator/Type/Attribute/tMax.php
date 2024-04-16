<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\Type\BuildException;

trait tMax {

	public function max(float $value) {
		$this->attr->max->setValue($value);

		return $this;
	}

	public function validateMax(mixed $value): array {
		if ($this->attr->max->getValue() === null) {
			return [true, 'ok'];
		}

		$isValid = (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value <= $this->attr->max->getValue());

		return match ($isValid) {
			true  => [true, 'ok'],
			false => [false, 'O atributo "max" é inválido.'],
		};
	}
}
