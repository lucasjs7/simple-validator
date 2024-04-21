<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\ValidatorException;

trait tOptions {

	public function options(string ...$values): static {
		$this->attr->options->setValue($values);

		return $this;
	}

	public function validateOptions(string $value): void {
		if (self::isEmpty($this->attr->options->getValue())) {
			return;
		}

		$isValid = in_array($value, $this->attr->options->getValue());

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "options".');
		};
	}
}
