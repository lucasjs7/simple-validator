<?php

namespace Lucasjs7\SimpleValidator;

interface iDataStructure {

    public function validate(mixed $value, bool $exception = true): bool;

    public function info(): array;
}
