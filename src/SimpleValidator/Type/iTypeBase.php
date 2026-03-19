<?php

namespace Lucasjs7\SimpleValidator\Type;

use Attribute;

interface iTypeBase {

    public function __construct(?string $label = null);

    public function getAttr(): Attribute;

    public function __clone(): void;

    public function validate(mixed $value, bool $exception = true, bool $selfField = true): bool;

    public function info(): string;

    public function label(string $value): static;

    public static function new(?string $label = null): static;

    public function required(bool $value = true): static;

    public function attrsValidate(mixed $value): void;

    public function typeValidate(mixed $value): bool;

    public function save(string $name): void;

    public static function pattern(string $name): self;
}
