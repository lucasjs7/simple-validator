<?php

namespace Lib\SimpleValidator\Type;

use Exception;
use Lib\SimpleValidator\Core;
use Lib\SimpleValidator\Type\Attribute\AttrError;
use Lib\SimpleValidator\Type\Attribute\Attribute;

abstract class TypeBase extends Core implements iTypeBase {

	protected readonly Attribute $attr;

	public function __construct() {
		$this->attr = new Attribute;
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

			AttrError::buildError($this->attr, 'Estão sendo usados atributos conflitantes.');
		}
	}

	protected function checkAttributes(): bool {
		$emptyRegex    = self::isEmpty($this->attr->regex->getValue());
		$emptyMax 	   = self::isEmpty($this->attr->max->getValue());
		$emptyMin 	   = self::isEmpty($this->attr->min->getValue());
		$emptyOptions  = self::isEmpty($this->attr->options->getValue());
		$emptyFormat   = self::isEmpty($this->attr->format->getValue());
		$emptyUnsigned = self::isEmpty($this->attr->unsigned->getValue());

		$countGroups = 0;

		$countGroups += (int) (!$emptyRegex);
		$countGroups += (int) (!$emptyMax || !$emptyMin || !$emptyUnsigned);
		$countGroups += (int) (!$emptyOptions);
		$countGroups += (int) (!$emptyFormat);

		$invalidGroups = 0;

		$invalidGroups += (int) (!$emptyUnsigned && !$emptyMin);

		$noGroupUsed = ($countGroups == 0);
		$validGroups = ($countGroups == 1 && $invalidGroups == 0);

		return ($noGroupUsed || $validGroups);
	}

	abstract public static function new(): static;

	abstract public function required(bool $value = true): static;

	abstract public static function pattern(string $name): static;
}
