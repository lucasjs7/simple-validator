<?php

namespace Lib\SimpleValidator;

use \Exception;
use Lib\SimpleValidator\Type\_String;
use Lib\SimpleValidator\Type\TypeBase;

class Struct extends DataStructure {

	public function __construct(
		public readonly array $structure
	) {
		foreach ($structure as $val) {
			if (!($val instanceof DataStructure) && !($val instanceof TypeBase)) {
				Core::exitError(
					title: 'Struct Error',
					message: 'A Struct só pode conter classes filhas de DataStructure ou TypeBase.',
					exception: new Exception,
					backtrace: true,
					tables: null,
				);
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

		foreach ($values as $key => $value) {
			if (!$typeKey->validate($key, false)) {
				$this->setErrorPath(
					message: "Erro na chave: {$typeKey->getError()}",
					currentPath: $key,
					field: $typeKey,
				);
				return false;
			}
			if (!array_key_exists($key, $this->structure)) {
				$this->setErrorPath(
					message: "Chave inexistente.",
					currentPath: $key,
					field: $this,
				);

				return false;
			} elseif (!$this->structure[$key]->validate($value, false)) {
				$this->setErrorPath(
					message: $this->structure[$key]->getError(),
					currentPath: $key,
					field: $this->structure[$key],
					prefix: 'Erro no valor: ',
				);
				return false;
			}
		}

		return true;
	}
}
