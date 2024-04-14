<?php

namespace Lib\SimpleValidator\Type;

abstract class Base implements iBase {

	protected float $min;
	protected float $max;
	protected array $options;
	protected array $format;
	protected bool $required = false;

	protected string $errorMsg = '';
	protected bool $exception = true;

	protected function setError(string $message): void {
		$this->errorMsg = $message;

		if ($this->exception) {
			throw new TypeException($message);
		}
	}

	public function getError(): string {
		return $this->errorMsg;
	}

	public function required(bool $value = true): Base {
		$this->required = $value;
		return $this;
	}

	public function validate(mixed $value, bool $exception = true): bool {
		$this->exception = $exception;

		if (!$this->checkAttributes()) {
			$this->setError('Está sendo usado atributos conflitantes.');
			return false;
		}

		return true;
	}

	protected function checkAttributes(): bool {
		$validGroups = [];

		$validGroups[] = (!empty($this->max) || !empty($this->min));
		$validGroups[] = (!empty($this->options));
		$validGroups[] = (!empty($this->format));

		return (array_sum($validGroups) <= 1);
	}
}
