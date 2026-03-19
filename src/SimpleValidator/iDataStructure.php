<?php

namespace Lucasjs7\SimpleValidator;

interface iDataStructure {

    public function validate(mixed $value, bool $exception = true): bool;

    /**
     * @return array<string|int, mixed>
     */
    public function info(): array;
}
