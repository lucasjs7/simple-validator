<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Error;

trait tMin {

	public function min(float $value): static {
		$this->attr->min->setValue($value);

		return $this;
	}

	public function validateMin(mixed $value, string $type): void {
		if ($this->attr->min->getValue() === null) {
			return;
		} elseif ($this->attr->min->getValue() > $this->attr->max->getValue()) {
			$this->attr->min->setError(true);
			$this->attr->max->setError(true);
			AttrError::buildError($this->attr, 'O atributo "min" não pode ser superior ao atributo "max".');
		}

		$isValid = match ($type) {
			'int', 'float'  => ($value >= $this->attr->min->getValue()),
			'string' 		=> (mb_strlen($value) >= $this->attr->min->getValue()),
		};

		if (!$isValid) {
			throw new Error('O valor é inválido para o atributo "min".');
		};
	}
}
