<?php

namespace Lib\SimpleValidator\Type;

interface iTypeBase {

	public function validate(mixed $value, bool $exception = true): bool;

	public function attrsValidate(mixed $value): void;

	public function typeValidate(mixed $value): bool;

	public function save(string $name): void;
}
