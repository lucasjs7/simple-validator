<?php

namespace Lib\SimpleValidator\Type;

use Lib\SimpleValidator\Type\Attribute\{tOptions, tMin, tMax};

class _String extends Base {

	use tOptions, tMin, tMax;

	public static function new(): _String {
		return new self;
	}

	public function validate(mixed $value, bool $exception = true): bool {
		if (!parent::validate($value, $exception)) {
			return false;
		}

		[$status, $message] = $this->validateOptions($value);

		if (!$status) {
			$this->setError($message);
			return false;
		}

		[$status, $message] = $this->validateMin($value);

		if (!$status) {
			$this->setError($message);
			return false;
		}

		[$status, $message] = $this->validateMax($value);

		if (!$status) {
			$this->setError($message);
			return false;
		}

		return true;
	}
}
