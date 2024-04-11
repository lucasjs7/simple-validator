<?php

class tString implements iType {

	public readonly string $name;
	private string $errorMsg;

	public function validate(): bool {
		return false;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getError(): string {
		return $this->errorMsg;
	}
}
