<?php

namespace Lib\SimpleValidator\Type\Attribute;

class AttrData {

	private mixed $value = null;
	private bool $error = false;

	public function setValue(mixed $value): void {
		$this->value = $value;
	}

	public function getValue(): mixed {
		return $this->value;
	}

	public function setError(bool $value): void {
		$this->error = $value;
	}

	public function getError(): string {
		return $this->error;
	}
}
