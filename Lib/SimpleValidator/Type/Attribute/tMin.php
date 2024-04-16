<?php

namespace Lib\SimpleValidator\Type\Attribute;

trait tMin {

	public function min(float $value) {
		$this->attr->min->setValue($value);

		return $this;
	}

	public function validateMin(mixed $value): array {
		if ($this->attr->min->getValue() === null) {
			return [true, 'ok'];
		} elseif ($this->attr->min->getValue() > $this->attr->max->getValue()) {
			$this->attr->min->setError(true);
			$this->attr->max->setError(true);
			AttrError::buildError($this->attr, 'O atributo "min" não pode ser superior ao atributo "max".');
		}

		$isValid = (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= $this->attr->min->getValue());

		return match ($isValid) {
			true  => [true, 'ok'],
			false => [false, 'O atributo "min" é inválido.'],
		};
	}
}
