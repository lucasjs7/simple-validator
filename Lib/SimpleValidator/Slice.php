<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\TypeBase;

class Slice extends DataStructure {

	public function __construct(
		public readonly TypeBase $typeValues,
	) {
		//
	}

	public static function new(TypeBase $typeValues): static {
		return new static($typeValues);
	}

	public function validate(array $values): bool {
		if (!array_is_list($values)) {
			$this->setError('O valor deve conter uma lista.');
			return false;
		}

		foreach ($values as $val) {
			if (!$this->typeValues->validate($val)) {
				$this->setError($this->typeValues->getError());
				return false;
			}
		}

		return true;
	}
}
