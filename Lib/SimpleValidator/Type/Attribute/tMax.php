<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\ValidatorException;

trait tMax {

	public function max(float $value): static {
		$this->attr->max->setValue($value);

		return $this;
	}

	public function validateMax(mixed $value, string $type): void {
		if ($this->attr->max->getValue() === null) {
			return;
		}

		$isValid = match ($type) {
			'int', 'float'  => ($value <= $this->attr->max->getValue()),
			'string' 		=> (mb_strlen($value) <= $this->attr->max->getValue()),
		};

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "max".');
		};
	}
}
