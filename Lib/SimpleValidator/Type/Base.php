<?php

namespace Lib\SimpleValidator\Type;

use Error;
use Lib\SimpleValidator\Type\Attribute\AttrError;
use Lib\SimpleValidator\Type\Attribute\Attribute as Attribute;

abstract class Base implements iBase {

	protected readonly Attribute $attr;
	protected string $errorMsg = '';
	protected bool $exception = true;

	public function __construct() {
		$this->attr = new Attribute;
	}

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
		$this->attr->required->setValue($value);
		return $this;
	}

	protected static function isEmpty(mixed $value): bool {
		return ($value === null  || $value === '');
	}

	public function validate(mixed $value, bool $exception = true): bool {
		$isEmpty = self::isEmpty($value);

		try {
			$this->exception = $exception;
			$this->verifyConflicts();

			if ($this->attr->required->getValue() && $isEmpty) {
				throw new Error('Este campo é obrigatório.');
			} elseif (!$isEmpty && !$this->typeValidate($value)) {
				throw new Error('O valor passado não corresponde ao tipo esperado.');
			}

			$this->attrsValidate($value);

			return true;
		} catch (Error $e) {
			if ($this->attr->required->getValue() || !$isEmpty) {
				$this->setError($e->getMessage());
				return false;
			}

			return true;
		}
	}

	protected function verifyConflicts(): void {
		if (!$this->checkAttributes()) {
			foreach ($this->attr as $nameAttr => $attribute) {
				if ($nameAttr != 'required' && $attribute->getValue() !== null) {
					$attribute->setError(true);
				}
			}

			AttrError::buildError($this->attr, 'Está sendo usado atributos conflitantes.');
		}
	}

	protected function checkAttributes(): bool {
		$validGroups = [];

		$validGroups[] = ($this->attr->max->getValue() !== null || $this->attr->min->getValue() !== null);
		$validGroups[] = ($this->attr->options->getValue() !== null);
		$validGroups[] = ($this->attr->format->getValue() !== null);

		return (array_sum($validGroups) <= 1);
	}
}
