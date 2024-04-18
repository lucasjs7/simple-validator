<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\tFormat;

class _Date extends Base {

	use tFormat, tNew;

	public function __construct() {
		parent::__construct();

		if ($this->attr->format->getValue() === null) {
			$this->attr->format->setValue('Y-m-d');
		}
	}

	public function typeValidate(mixed $value): bool {
		return is_string($value);
	}

	public function attrsValidate(mixed $value): void {
		$this->validateFormat($value);
	}
}
