<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tMin {

	public function min(float $value) {
		$this->min = $value;

		return $this;
	}

	public function validateMin(mixed $value): bool {
		if (!isset($this->min)) {
			return true;
		}

		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= $this->min);
	}
}
