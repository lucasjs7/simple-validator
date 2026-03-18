<?php

namespace Lucasjs7\SimpleValidator\Type;

interface iTypeBase {

    public function __construct(?string $label = null);

    public function validate(mixed $value, bool $exception = true): bool;

    public function attrsValidate(mixed $value): void;

    public function typeValidate(mixed $value): bool;

    public function save(string $name): void;

    public static function pattern(string $name): self;
}
