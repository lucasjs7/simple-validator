<?php

namespace Lib\SimpleValidator\Type\Attribute;

use DateTime;

trait tFormat {

	public function format(string $value) {
		$this->attr->format->setValue($value);

		return $this;
	}

	public function validateFormat(mixed $value): array {
		if ($this->attr->format->getValue() === null) {
			return [true, 'ok'];
		}

		$isValid = (!is_string($value) && DateTime::createFromFormat($this->attr->format->getValue(), $value) !== false);

		return match ($isValid) {
			true  => [true, 'ok'],
			false => [false, 'O atributo "format" é inválido.'],
		};
	}
}
