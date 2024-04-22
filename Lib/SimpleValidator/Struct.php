<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\_String;
use Lib\SimpleValidator\Type\TypeBase;

class Struct extends DataStructure {

	public function __construct(
		public readonly array &$structure
	) {
		foreach ($structure as $val) {
			if (!($val instanceof DataStructure) && !($val instanceof TypeBase)) {
				Core::exitError()
			}
		}
	}

	public static function new(array $structure): static {
		return new self($structure);
	}

	public function validate(
		mixed $values,
		bool  $exception = true,
	): bool {
		$this->exception = $exception;

		if (!is_array($values)) {
			$this->setError('O valor deve conter uma estrutura chave-valor.', []);
			return false;
		}

		$typeKey = _String::new()->min(1)->required();
		$pathStruct = [];

		foreach ($values as $key => $value) {
			if (!$typeKey->validate($key)) {
				$this->setError('Erro na chave: ' . $typeKey->getError());
			}
		}

		return true;
	}
}
