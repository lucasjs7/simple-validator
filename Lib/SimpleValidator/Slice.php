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

	public function validate(array $values, bool $exception = true): bool {
		$this->exception = $exception;

		if (!array_is_list($values)) {
			$this->setError('O valor deve conter uma lista.');
			return false;
		}

		foreach ($values as $key => $val) {
			$errorMessage = null;

			if (!$this->typeValues->validate($val, false)) {
				$errorMessage = $this->typeValues->getError();
			}

			if ($errorMessage !== null) {
				$this->setErrorPath(
					message: $errorMessage,
					currentPath: [$key],
					field: $this->typeValues
				);
				return false;
			}
		}

		return true;
	}
}
