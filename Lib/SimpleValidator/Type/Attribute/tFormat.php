<?php

namespace Lib\SimpleValidator\Type\Attribute;

use DateTime;

trait tFormat {

	public function format(string $value) {
		$this->format = $value;

		return $this;
	}

	public function validateFormat(mixed $value): bool {
		if (!isset($this->format)) {
			return true;
		}

		return (!is_string($value) && DateTime::createFromFormat($this->format, $value) !== false);
	}
}
