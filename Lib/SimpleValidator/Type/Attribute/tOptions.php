<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tOptions {

	public function options(string ...$values) {
		$this->attr->options->setValue($values);

		return $this;
	}

	public function validateOptions(mixed $value): array {
		if ($this->attr->options->getValue() === null) {
			return [true, 'ok'];
		}

		$isValid = (is_string($value) && in_array($value, $this->attr->options->getValue()));

		return match ($isValid) {
			true  => [true, 'ok'],
			false => [false, 'O atributo "options" é inválido.'],
		};
	}
}
