<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\TypeBase;

abstract class DataStructure extends Core {

	protected array $errorPath;

	public function getErrorPath(): array {
		return $this->errorPath;
	}

	protected function setErrorPath(
		string 		  $message,
		string  	  $currentPath,
		self|TypeBase $field,
	): void {
		$this->errorPath = match ($field instanceof self) {
			true  => [$currentPath, ...$field->getErrorPath()],
			false => [$currentPath],
		};

		$this->setError(
			message: $message,
			errorPath: $this->errorPath,
		);
	}

	abstract public function validate(mixed $value, bool $exception = true): bool;
}
