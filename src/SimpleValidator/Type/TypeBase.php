<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Type\Attribute\AttrError;
use Lucasjs7\SimpleValidator\Type\Attribute\Attribute;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

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
				throw new Exception(Lng::get([], 'type', 'type-base', 'error-required'));
			} elseif (!$isEmpty && !$this->typeValidate($value)) {
				$descType = Lng::get([], 'type', "desc-type-{$this->name()}");
				throw new Exception(Lng::get(['type' => $descType], 'type', 'type-base', 'error-type'));
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

			AttrError::buildError($this->attr, Lng::get([], 'type', 'type-base', 'error-attr-conflict'));
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
