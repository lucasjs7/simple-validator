<?php

namespace Lib\SimpleValidator;

use Lib\SimpleValidator\Type\TypeBase;

abstract class DataStructure extends Core {

	protected array $errorPath;

	public function getErrorPath(): array {
		return $this->errorPath;
	}

	protected function setErrorPath(
		string $message,
		array  $currentPath,
		DataStructure|TypeBase $field,
	): void {
		$finalPath = $currentPath;

		if ($field instanceof DataStructure) {
			$finalPath = array_merge($finalPath, $field->getErrorPath());
		}

		$this->errorPath = $finalPath;
		$this->setError($message);
	}
}
