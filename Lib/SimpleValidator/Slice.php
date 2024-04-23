<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\TypeBase;

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
			$errorMessage = null;

			if (!$this->typeValues->validate($val, false)) {
				$errorMessage = $this->typeValues->getError();
			}

			if ($errorMessage !== null) {
				$this->setErrorPath(
					message: $errorMessage,
					currentPath: $key,
					field: $this->typeValues,
				);
				return false;
			}
		}

		return true;
	}
}
