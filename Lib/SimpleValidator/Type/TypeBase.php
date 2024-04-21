<?php

namespace Lib\SimpleValidator\Type;

use Exception;
use Lib\SimpleValidator\ValidatorException;
use Lib\SimpleValidator\Type\Attribute\AttrError;
use Lib\SimpleValidator\Type\Attribute\Attribute;

abstract class TypeBase implements iTypeBase {

	protected readonly Attribute $attr;
	protected string $errorMsg = '';
	protected bool $exception = true;

	public function __construct() {
		$this->attr = new Attribute;
	}

	protected function setError(string $message): void {
		$this->errorMsg = $message;

		if ($this->exception) {
			throw new ValidatorException($message);
		}
	}

	public function getError(): string {
		return $this->errorMsg;
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
				throw new Exception('Este campo é obrigatório.');
			} elseif (!$isEmpty && !$this->typeValidate($value)) {
				throw new Exception('O valor passado não corresponde ao tipo esperado.');
			}

			$this->attrsValidate($value);

			return true;
		} catch (Exception $e) {
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
		$emptyMax 	   = self::isEmpty($this->attr->max);
		$emptyMin 	   = self::isEmpty($this->attr->min);
		$emptyOptions  = self::isEmpty($this->attr->options);
		$emptyFormat   = self::isEmpty($this->attr->format);
		$emptyUnsigned = self::isEmpty($this->attr->unsigned);

		$countGroups = 0;

		$countGroups += (int) (!$emptyMax || !$emptyMin || !$emptyUnsigned);
		$countGroups += (int) (!$emptyOptions);
		$countGroups += (int) (!$emptyFormat);

		$invalidGroups = 0;

		$invalidGroups += (int) (!$emptyUnsigned && !$emptyMin);

		$noGroupUsed = ($countGroups == 0);
		$validGroups = ($countGroups == 1);

		return (($noGroupUsed || $validGroups) && $invalidGroups == 0);
	}

	abstract public function required(bool $value = true): static;

	abstract public static function pattern(string $name): static;
}
