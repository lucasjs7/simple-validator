<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tMax {

	public function max(float $value) {
		$this->max = $value;

		return $this;
	}

	public function validateMax(mixed $value): bool {
		if (!isset($this->max)) {
			return true;
		}

		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value <= $this->max);
	}
}
