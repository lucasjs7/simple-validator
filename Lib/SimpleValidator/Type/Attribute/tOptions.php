<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tOptions {

	public function options(string ...$values) {
		$this->attr->options->setValue($values);

		return $this;
	}

	public function validateOptions(mixed $value): bool {
		if ($this->attr->options->getValue() === null) {
			return true;
		}

		return (is_string($value) && in_array($value, $this->attr->options->getValue()));
	}
}
