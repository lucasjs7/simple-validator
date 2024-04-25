<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\TypeBase;

class Slice extends DataStructure {

	public function __construct(
		public readonly DataStructure|TypeBase $typeValues,
	) {
		//
	}

	public static function new(DataStructure|TypeBase $typeValues): static {
		return new static($typeValues);
	}

	public function validate(
		mixed $values,
		bool  $exception = true,
	): bool {
		$this->exception = $exception;

		if (!is_array($values) || !array_is_list($values)) {
			$this->setError('O valor deve conter uma lista.');
			return false;
		}

		foreach ($values as $key => $val) {
			if (!$this->typeValues->validate($val, false)) {
				$this->setErrorPath(
					message: $this->typeValues->getError(),
					currentPath: $key,
					field: $this->typeValues,
					prefix: 'Erro no valor: ',
				);
				return false;
			}
		}

		return true;
	}
}
