<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\TypeBase;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

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
			$this->setError(Lng::get([], 'slice', 'error-list'));
			return false;
		}

		foreach ($values as $key => $val) {
			if (!$this->typeValues->validate($val, false)) {
				$this->setErrorPath(
					message: $this->typeValues->getError(),
					currentPath: $key,
					field: $this->typeValues,
					prefix: Lng::get([], 'slice', 'error-prefix-key'),
				);
				return false;
			}
		}

		return true;
	}
}
