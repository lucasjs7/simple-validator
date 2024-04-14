<?php

namespace Lib\SimpleValidator\Type;

interface iBase {

	public function required(bool $value = true);

	public function validate(mixed $value, bool $exception = true): bool;
}
