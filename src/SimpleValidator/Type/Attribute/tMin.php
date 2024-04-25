<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;

trait tMin {

	public function min(float $value): static {
		$this->attr->min->setValue($value);

		return $this;
	}

	public function validateMin(mixed $value, string $type): void {
		$minIsEmpty = self::isEmpty($this->attr->min->getValue());

		if ($minIsEmpty) {
			return;
		}

		$maxIsEmpty = self::isEmpty($this->attr->max->getValue());

		if (!$maxIsEmpty && $this->attr->min->getValue() > $this->attr->max->getValue()) {
			$this->attr->min->setError(true);
			$this->attr->max->setError(true);
			AttrError::buildError($this->attr, 'O atributo "min" não pode ser superior ao atributo "max".');
		}

		$isValid = match ($type) {
			'int', 'float'  => ($value >= $this->attr->min->getValue()),
			'string' 		=> (mb_strlen($value) >= $this->attr->min->getValue()),
		};

		if (!$isValid) {
			throw new ValidatorException('O valor é inválido para o atributo "min".');
		};
	}
}
