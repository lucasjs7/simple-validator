<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\ValidatorException;

trait tUnsigned {

	public function unsigned(bool $value = true): static {
		$this->attr->unsigned->setValue($value);

		return $this;
	}

	public function validateUnsigned(mixed $value): void {
		if ($this->attr->unsigned->getValue() !== true) {
			return;
		}

		$isValid = ($value >= 0);

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "unsigned".');
		};
	}
}
