<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\ValidatorException;

trait tRegex {

	public function regex(string $pattern) {
		$this->attr->regex->setValue($pattern);

		return $this;
	}

	public function validateRegex(mixed $value): void {
		if (self::isEmpty($this->attr->regex->getValue())) {
			return;
		}

		$isValid = preg_match($this->attr->regex->getValue(), $value);

		if ($isValid === 0) {
			throw new ValidatorException('O valor é inválido para o atributo "regex".');
		} elseif ($isValid === false) {
			AttrError::buildError($this->attr, 'O padrão regex usado é inválido.');
		};
	}
}
