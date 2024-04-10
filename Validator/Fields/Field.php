<?php

namespace Validator\Fields;

class Field {

	private bool $required = false;
	private ?string $type = null;

	public function __construct(
		private string $name
	) {
		//
	}

	public function required(bool $value = true): Field {
		$this->required = $value;
		return $this;
	}

	public function isRequired(): bool {
		return $this->required;
	}


	// !!!
	// validar o param $value, para ver se está dentro da
	// lista suportada no método validateType
	// !!!
	public function type(string $value): Field {
		$this->type = $value;
		return $this;
	}

	public function validate(array $data): array {
		$keyExists = array_key_exists($this->name, $data);
		$validationOne = ($this->required() || $keyExists);
		$validationTwo = (!$keyExists || !$this->validateType($data[$this->name]));

		if ($validationOne && $validationTwo) {
			return [
				'status' => false,
				'message' => "O campo \"$this->name\" passado no Body é inválido."
			];
		}

		return ['status' => true];
	}

	private function validateType(mixed $value): bool {
		return match ($this->type) {
			'string'         => is_string($value),
			'int', 'integer' => (filter_var($value, FILTER_VALIDATE_INT) !== false),
			'array'          => is_array($value),
			'list'           => array_is_list($value),
			'array'          => is_array($value),
			null			 => false
		};
	}
}
