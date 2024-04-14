<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tMin {

	public function min(float $value) {
		$this->attr->min->setValue($value);

		return $this;
	}

	public function validateMin(mixed $value): bool {
		if ($this->attr->min->getValue() === null) {
			return true;
		}

		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= $this->attr->min->getValue());
	}
}
