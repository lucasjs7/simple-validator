<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use DateTime;
use Lucasjs7\SimpleValidator\ValidatorException;

trait tFormat {

	public function format(string $value): static {
		$this->attr->format->setValue($value);

		return $this;
	}

	public function validateFormat(string $value): void {
		if (self::isEmpty($this->attr->format->getValue())) {
			return;
		}

		$isValid = (DateTime::createFromFormat($this->attr->format->getValue(), $value) !== false);

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "format".');
		};
	}
}
