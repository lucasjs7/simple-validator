<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Lib\SimpleValidator\Type\BuildException;

trait tMax {

	public function max(float $value) {
		$this->attr->max->setValue($value);

		return $this;
	}

	public function validateMax(mixed $value): bool {
		if ($this->attr->max->getValue() === null) {
			return true;
		} elseif ($this->attr->min->getValue() > $this->attr->max->getValue()) {
			AttrError::buildError($this->attr, 'O atributo "min" não pode ser superior ao atributo "max".');
		}

		return (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value <= $this->attr->max->getValue());
	}
}
