<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tOptions {

	public function options(string ...$values) {
		array_push($this->options, ...$values);

		return $this;
	}

	public function validateOptions(mixed $value): bool {
		if (!isset($this->options)) {
			return true;
		}

		return (is_string($value) && in_array($value, $this->options));
	}
}
