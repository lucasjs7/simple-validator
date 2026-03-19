<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\Attribute;

interface iTypeBase {

    public function __construct(?string $label = null);

    public function getAttr(): Attribute;

    public function __clone(): void;

    public function validate(mixed $value, bool $exception = true, bool $selfField = true): bool;

    public function info(): string;

    public function label(string $value): static;

    public static function new(?string $label = null): TypeBase;

    public function required(bool $value = true): static;

    public function attrsValidate(mixed $value): void;

    public function typeValidate(mixed $value): bool;

    public function save(string $name): void;

    public static function pattern(string $name): TypeBase;

    public function getError(): string;

    public function attrError(Attribute $attr, string $errorMessage): void;

    public function isRequired(): bool;

    public function errorImplementation(): bool;
}
