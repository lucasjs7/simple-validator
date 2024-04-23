<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\{TypeBase, _Date, _Int, _String};

class Map extends DataStructure {

	public function __construct(
		public readonly TypeBase 			   $typeKeys,
		public readonly TypeBase|DataStructure $typeValues,
	) {
		//
	}

	public static function new(
		_Date|_Int|_String 	   $typeKeys,
		TypeBase|DataStructure $typeValues
	): static {
		return new static($typeKeys, $typeValues);
	}

	public function validate(
		mixed $values,
		bool  $exception = true,
	): bool {
		$this->exception = $exception;

		if (!is_array($values) || !is_array($values)) {
			$this->setError('O valor deve conter uma estrutura chave-valor.');
			return false;
		}

		foreach ($values as $key => $val) {
			if (!$this->typeKeys->validate($key, false)) {
				$this->setErrorPath(
					message: "Erro na chave: {$this->typeKeys->getError()}",
					currentPath: $key,
					field: $this->typeKeys,
				);
				return false;
			}
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
