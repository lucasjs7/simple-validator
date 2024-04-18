<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Error;

trait tOptions {

	public function options(string ...$values): static {
		$this->attr->options->setValue($values);

		return $this;
	}

	public function validateOptions(string $value): void {
		if ($this->attr->options->getValue() === null) {
			return;
		}

		$isValid = in_array($value, $this->attr->options->getValue());

		if (!$isValid) {
			throw new Error('O valor é inválido para o atributo "options".');
		};
	}
}
