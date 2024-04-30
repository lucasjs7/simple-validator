<?php

namespace Lucasjs7\SimpleValidator;

use \Exception;
use Lucasjs7\SimpleValidator\Type\{TypeBase, TypeParser, _String};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class Struct extends DataStructure {

	public function __construct(
		public array $structure
	) {
		foreach ($this->structure as &$val) {
			if (!is_string($val) && !($val instanceof DataStructure) && !($val instanceof TypeBase)) {
				Core::exitError(
					title: 'Struct Error',
					message: Lng::get([], 'struct', 'error-data'),
					exception: new Exception,
					backtrace: true,
					tables: null,
				);
			}

			if (is_string($val)) {
				$val = TypeParser::new($val);
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
			$this->setError(Lng::get([], 'struct', 'error-list'), []);
			return false;
		}

		$typeKey = _String::new()->min(1)->required();

		foreach ($values as $key => $value) {
			if (!$typeKey->validate($key, false)) {
				$this->setErrorPath(
					message: Lng::get([], 'struct', 'error-prefix-key') . $typeKey->getError(),
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
					prefix: Lng::get([], 'struct', 'error-prefix-value'),
				);
				return false;
			}
		}

		return true;
	}

	public function info(): array {
		$rtn = [];

		foreach ($this->structure as $key => $value) {
			$rtn[$key] = $value->info();
		}

		return $rtn;
	}
}
