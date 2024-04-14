<?php

namespace Lib\SimpleValidator\Type\Attribute;

use DateTime;

trait tFormat {

	public function format(string $value) {
		$this->attr->format->setValue($value);

		return $this;
	}

	public function validateFormat(mixed $value): bool {
		if ($this->attr->format->getValue() === null) {
			return true;
		}

		return (!is_string($value) && DateTime::createFromFormat($this->attr->format->getValue(), $value) !== false);
	}
}
