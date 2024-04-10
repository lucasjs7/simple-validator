<?php

namespace Validator\Fields;

use TypeError;

class GroupFields {

	private array $dataFields = [];
	private ?string $errorMsg = null;

	public function __construct(
		private readonly array $data,
		private readonly bool $exceptionField,
	) {
		//
	}

	public function add(string $name): Field|false {
		return !array_key_exists($name, $this->dataFields)
			? $this->dataFields[$name] = new Field($name)
			: false;
	}

	public function addAll(array $fields): bool {
		$validAttrs = $this->getValidFields();

		foreach ($fields as $fieldName => $fieldData) {
			if (array_key_exists($fieldName, $this->dataFields)) {
				$this->errorMsg = "O campo \"$fieldName\" já foi declarado.";
				return false;
			}

			$this->dataFields[$fieldName] = new Field($fieldName);
			$pField = $this->dataFields[$fieldName];

			foreach ($fieldData as $attrName => $attrValue) {
				if (!in_array($attrName, $validAttrs)) {
					$this->setError("O atributo \"$attrName\" não existe.");
					return false;
				}

				$setMethodName = match ($attrName) {
					'required' => 'required',
					'type' 	   => 'type',
				};

				if (!method_exists($pField, $setMethodName)) {
					$this->setError("O método usado para atribuir o valor do campo \"$attrName\" não existe.");
					return false;
				}

				try {
					$pField->{$setMethodName}($attrValue);
				} catch (TypeError $e) {
					$this->setError("O valor do atributo \"$attrName\" do campo \"$fieldName\" é inválido.");
					return false;
				}
			}
		}

		return true;
	}

	public function get(string $name): Field|false {
		return $this->dataFields[$name] ?? false;
	}

	public function validate(): bool {
		foreach ($this->dataFields as $pField) {
			$validate = $pField->validate($this->data);

			if (!$validate['status']) {
				$this->errorMsg = $validate['message'];
				return false;
			}
		}

		return true;
	}

	private function getValidFields(): array {
		$vField = new Field('');
		$classNameLen = strlen(get_class($vField));
		$arrayVField = (array) $vField;
		$validAttrs = array_keys($arrayVField);

		foreach ($validAttrs as &$attrName) {
			$attrName = trim(substr($attrName, ($classNameLen + 1)));
		}

		return $validAttrs;
	}

	private function setError(string $message): void {
		$this->errorMsg = $message;

		if ($this->exceptionField) {
			throw new ExceptionField($message);
		}
	}

	public function getError(): ?string {
		return $this->errorMsg;
	}
}
