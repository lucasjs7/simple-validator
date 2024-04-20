<?php

namespace Lib\SimpleValidator\Type\Attribute;

use DateTime;
use Lib\SimpleValidator\ValidatorException;

trait tFormat {

	public function format(string $value): static {
		$this->attr->format->setValue($value);

		return $this;
	}

	public function validateFormat(string $value): void {
		if ($this->attr->format->getValue() === null) {
			return;
		}

		$isValid = (DateTime::createFromFormat($this->attr->format->getValue(), $value) !== false);

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "format".');
		};
	}
}
